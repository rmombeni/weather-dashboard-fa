<?php
/**
 * get_weather.php
 * پراکسی سمت سرور برای گرفتن اطلاعات آب و هوا از wttr.in
 * مستندات: https://github.com/chubin/wttr.in
 *
 * پارامتر ورودی (GET):
 *   location -> نام شهر (مثلا Tehran) یا مختصات به صورت "lat,lon"
 *
 * خروجی: JSON با ساختار یکسان، صرف نظر از موفقیت یا خطا
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Configuration
define('CACHE_DIR', __DIR__ . '/cache/');
define('CACHE_TTL', 600); // 10 minutes in seconds
define('REQUEST_TIMEOUT', 8);

// Ensure cache directory exists
if (!is_dir(CACHE_DIR)) {
    @mkdir(CACHE_DIR, 0755, true);
}

// فقط GET مجاز است
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'روش درخواست نامعتبر است']);
    exit;
}

$location = isset($_GET['location']) ? trim($_GET['location']) : '';

if ($location === '') {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'نام شهر یا مختصات ارسال نشده است']);
    exit;
}

// اجازه فقط به کاراکترهای امن: حروف، اعداد، فاصله، کاما، نقطه، خط تیره، زیرخط، اسلش (برای City/Country)
if (!preg_match('/^[\p{L}\p{N}\s,.\-_\/+]{1,100}$/u', $location)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'مقدار مکان نامعتبر است']);
    exit;
}

// Cache key based on location
$cacheKey = 'weather_' . md5(strtolower($location));
$cacheFile = CACHE_DIR . $cacheKey . '.json';

// Check cache first
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < CACHE_TTL)) {
    $cachedData = @file_get_contents($cacheFile);
    if ($cachedData !== false) {
        echo $cachedData;
        exit;
    }
}

// ساخت آدرس wttr.in با فرمت JSON کامل (j1) و زبان فارسی برای توضیحات
$encodedLocation = rawurlencode($location);
$url = "https://wttr.in/{$encodedLocation}?format=j1&lang=fa";

$context = stream_context_create([
    'http' => [
        'method'  => 'GET',
        'timeout' => REQUEST_TIMEOUT,
        'header'  => "User-Agent: curl/8.0\r\nAccept: application/json\r\n",
    ],
]);

$response = false;
$httpCode = null;

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => REQUEST_TIMEOUT,
        CURLOPT_USERAGENT      => 'curl/8.0',
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
} else {
    $response = @file_get_contents($url, false, $context);
}

if ($response === false) {
    http_response_code(502);
    echo json_encode([
        'ok' => false,
        'error' => 'ارتباط با سرویس آب و هوا (wttr.in) برقرار نشد. لطفا دوباره تلاش کنید.',
    ]);
    exit;
}

$data = json_decode($response, true);

if (!is_array($data) || !isset($data['current_condition'][0])) {
    http_response_code(502);
    echo json_encode([
        'ok' => false,
        'error' => 'شهر یافت نشد یا پاسخ سرویس آب و هوا نامعتبر بود.',
    ]);
    exit;
}

$current   = $data['current_condition'][0];
$nearest   = $data['nearest_area'][0] ?? null;
$weatherArr= $data['weather'] ?? [];

// نام شهر: اگر وارد کرده کاربر مختصات بود از nearest_area استفاده می‌کنیم
$cityName = null;
$region   = null;
$country  = null;
$latitude = null;
$longitude= null;
$population = null;
if ($nearest) {
    $cityName   = $nearest['areaName'][0]['value'] ?? null;
    $region     = $nearest['region'][0]['value'] ?? null;
    $country    = $nearest['country'][0]['value'] ?? null;
    $latitude   = $nearest['latitude'] ?? null;
    $longitude  = $nearest['longitude'] ?? null;
    $population = $nearest['population'] ?? null;
}
if (!$cityName) {
    $cityName = $location;
}

// آدرس کامل و دقیق (مثل خط «Location:» در خود wttr.in) از طریق واچرخوانی معکوس نامینیتیم/OpenStreetMap
$fullAddress = null;
if ($latitude !== null && $longitude !== null) {
    $geoUrl = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$latitude}&lon={$longitude}&accept-language=fa";
    $geoResponse = false;

    if (function_exists('curl_init')) {
        $gch = curl_init($geoUrl);
        curl_setopt_array($gch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 6,
            CURLOPT_USERAGENT      => 'IranWeatherApp/1.0 (demo; contact: example@example.com)',
            CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $geoResponse = curl_exec($gch);
        curl_close($gch);
    } else {
        $geoContext = stream_context_create([
            'http' => [
                'method'  => 'GET',
                'timeout' => 6,
                'header'  => "User-Agent: IranWeatherApp/1.0 (demo; contact: example@example.com)\r\nAccept: application/json\r\n",
            ],
        ]);
        $geoResponse = @file_get_contents($geoUrl, false, $geoContext);
    }

    if ($geoResponse !== false) {
        $geoData = json_decode($geoResponse, true);
        if (is_array($geoData) && isset($geoData['display_name'])) {
            $fullAddress = $geoData['display_name'];
        }
    }
}

$descFa = $current['lang_fa'][0]['value'] ?? ($current['weatherDesc'][0]['value'] ?? '');

// تابع کمکی برای استخراج تمیز فیلدهای ساعتی
function extractHourly($hourlyArr) {
    $out = [];
    foreach ($hourlyArr as $h) {
        $out[] = [
            'time'               => $h['time'] ?? null,
            'temp_c'             => $h['tempC'] ?? null,
            'temp_f'             => $h['tempF'] ?? null,
            'feelslike_c'        => $h['FeelsLikeC'] ?? null,
            'feelslike_f'        => $h['FeelsLikeF'] ?? null,
            'weather_code'       => $h['weatherCode'] ?? null,
            'description'        => $h['lang_fa'][0]['value'] ?? ($h['weatherDesc'][0]['value'] ?? ''),
            'chance_of_rain'     => $h['chanceofrain'] ?? null,
            'chance_of_snow'     => $h['chanceofsnow'] ?? null,
            'chance_of_thunder'  => $h['chanceofthunder'] ?? null,
            'chance_of_fog'      => $h['chanceoffog'] ?? null,
            'chance_of_frost'    => $h['chanceoffrost'] ?? null,
            'chance_of_overcast' => $h['chanceofovercast'] ?? null,
            'chance_of_sunshine' => $h['chanceofsunshine'] ?? null,
            'chance_of_windy'    => $h['chanceofwindy'] ?? null,
            'chance_of_remdry'   => $h['chanceofremdry'] ?? null,
            'humidity'           => $h['humidity'] ?? null,
            'wind_kmph'          => $h['windspeedKmph'] ?? null,
            'wind_miles'         => $h['windspeedMiles'] ?? null,
            'wind_dir'           => $h['winddir16Point'] ?? null,
            'wind_dir_deg'       => $h['winddirDegree'] ?? null,
            'wind_gust_kmph'     => $h['WindGustKmph'] ?? null,
            'wind_gust_miles'    => $h['WindGustMiles'] ?? null,
            'dewpoint_c'         => $h['DewPointC'] ?? null,
            'dewpoint_f'         => $h['DewPointF'] ?? null,
            'windchill_c'        => $h['WindChillC'] ?? null,
            'windchill_f'        => $h['WindChillF'] ?? null,
            'heatindex_c'        => $h['HeatIndexC'] ?? null,
            'heatindex_f'        => $h['HeatIndexF'] ?? null,
            'pressure'           => $h['pressure'] ?? null,
            'pressure_inches'    => $h['pressureInches'] ?? null,
            'visibility'         => $h['visibility'] ?? null,
            'visibility_miles'   => $h['visibilityMiles'] ?? null,
            'cloud_cover'        => $h['cloudcover'] ?? null,
            'precip_mm'          => $h['precipMM'] ?? null,
            'precip_inches'      => $h['precipInches'] ?? null,
            'uv_index'           => $h['uvIndex'] ?? null,
            'diffuse_radiation'  => $h['diffRad'] ?? null,
            'solar_radiation'    => $h['solarRad'] ?? null,
            'shortwave_radiation'=> $h['shortRad'] ?? null,
        ];
    }
    return $out;
}

$forecast = [];
foreach ($weatherArr as $day) {
    $astro = $day['astronomy'][0] ?? [];
    $forecast[] = [
        'date'          => $day['date'] ?? null,
        'max_temp_c'    => $day['maxtempC'] ?? null,
        'min_temp_c'    => $day['mintempC'] ?? null,
        'avg_temp_c'    => $day['avgtempC'] ?? null,
        'sun_hour'      => $day['sunHour'] ?? null,
        'uv_index'      => $day['uvIndex'] ?? null,
        'total_snow_cm' => $day['totalSnow_cm'] ?? null,
        'sunrise'       => $astro['sunrise'] ?? null,
        'sunset'        => $astro['sunset'] ?? null,
        'moonrise'      => $astro['moonrise'] ?? null,
        'moonset'       => $astro['moonset'] ?? null,
        'moon_phase'    => $astro['moon_phase'] ?? null,
        'moon_illumination' => $astro['moon_illumination'] ?? null,
        'hourly'        => extractHourly($day['hourly'] ?? []),
    ];
}

$result = [
    'ok'   => true,
    'city' => $cityName,
    'region'  => $region,
    'country' => $country,
    'latitude'   => $latitude,
    'longitude'  => $longitude,
    'population' => $population,
    'full_address' => $fullAddress,
    'weather_url'=> 'https://wttr.in/' . rawurlencode($cityName),
    'query'      => $data['request'][0]['query'] ?? $location,
    'query_type' => $data['request'][0]['type'] ?? null,

    // وضعیت لحظه‌ای (کامل، متریک و امپریال)
    'temperature_c'    => $current['temp_C'] ?? null,
    'temperature_f'    => $current['temp_F'] ?? null,
    'feelslike_c'      => $current['FeelsLikeC'] ?? null,
    'feelslike_f'      => $current['FeelsLikeF'] ?? null,
    'humidity'         => $current['humidity'] ?? null,
    'wind_kmph'        => $current['windspeedKmph'] ?? null,
    'wind_miles'       => $current['windspeedMiles'] ?? null,
    'wind_dir'         => $current['winddir16Point'] ?? null,
    'wind_dir_deg'     => $current['winddirDegree'] ?? null,
    'pressure'         => $current['pressure'] ?? null,
    'pressure_inches'  => $current['pressureInches'] ?? null,
    'visibility'       => $current['visibility'] ?? null,
    'visibility_miles' => $current['visibilityMiles'] ?? null,
    'uv_index'         => $current['uvIndex'] ?? null,
    'cloud_cover'      => $current['cloudcover'] ?? null,
    'precip_mm'        => $current['precipMM'] ?? null,
    'precip_inches'    => $current['precipInches'] ?? null,
    'weather_code'     => $current['weatherCode'] ?? null,
    'description'      => $descFa,
    'observation_time' => $current['localObsDateTime'] ?? null,

    // پیش‌بینی چند روز آینده به همراه اطلاعات نجومی و ساعتی
    'forecast' => $forecast,
];

// Cache the result
@file_put_contents($cacheFile, json_encode($result, JSON_UNESCAPED_UNICODE));

echo json_encode($result, JSON_UNESCAPED_UNICODE);
