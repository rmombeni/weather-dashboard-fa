<?php
// index.php — Weather Dashboard with professional Persian RTL interface
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>آب و هوا</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  /* ═══════════════════════════════════════════════════
     DESIGN SYSTEM — Tokens
     Aesthetic: Clear — information density, calm authority
     Type: Vazirmatn (minor third 1.200 scale)
     ═══════════════════════════════════════════════════ */
  :root {
    /* ── Type Scale (1.200 minor third) ── */
    --font: 'Vazirmatn', sans-serif;
    --step--1: 0.833rem;
    --step-0: 1rem;
    --step-1: 1.125rem;
    --step-2: 1.35rem;
    --step-3: 1.62rem;
    --step-4: 1.944rem;
    --step-5: 2.333rem;
    --step-6: 2.8rem;

    /* ── Space Scale ── */
    --sp-3xs: 0.25rem;
    --sp-2xs: 0.5rem;
    --sp-xs: 0.75rem;
    --sp-s: 1rem;
    --sp-m: 1.5rem;
    --sp-l: 2rem;
    --sp-xl: 3rem;
    --sp-2xl: 4.5rem;

    /* ── Radius ── */
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --radius-pill: 999px;

    /* ── Motion ── */
    --dur-fast: 120ms;
    --dur: 220ms;
    --dur-slow: 400ms;
    --ease: cubic-bezier(0.2, 0, 0, 1);
    --ease-out: cubic-bezier(0.16, 1, 0.3, 1);

    /* ── Shadows ── */
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
    --shadow-lg: 0 8px 28px rgba(0,0,0,0.12);

    /* ── Colors: Light Mode ── */
    --c-bg: #f5f3ef;
    --c-surface: #ffffff;
    --c-surface-2: #f0ede8;
    --c-ink: #1a1d23;
    --c-ink-2: #4a5060;
    --c-ink-3: #7c8494;
    --c-line: #e0ddd6;
    --c-accent: #0e7c7b;
    --c-accent-ink: #ffffff;
    --c-primary: #d4940a;
    --c-primary-ink: #1a1d23;
    --c-success: #2d8a4e;
    --c-warning: #c77c14;
    --c-error: #c43e3e;
    --c-header-from: #142c4d;
    --c-header-to: #0e7c7b;
    --c-header-text: #ffffff;
    --c-header-muted: rgba(255,255,255,0.75);
    --c-header-input: rgba(255,255,255,0.12);
    --c-header-input-bg: rgba(255,255,255,0.95);
    --c-header-input-text: #1a1d23;
    --c-header-input-placeholder: #8a97a3;
    --c-focus: #0e7c7b;
    --c-hourly-active-bg: #e8f5f4;
    --c-hourly-active-border: #0e7c7b;
    --c-detail-item-bg: #f5f3ef;
    --c-link: #0e7c7b;
    --c-text-muted: #7c8494;
    --c-spinner-track: #e0ddd6;
    --c-spinner-fill: #0e7c7b;
  }

  @media (prefers-color-scheme: dark) {
    :root:not([data-theme="light"]) {
      --c-bg: #0c1219;
      --c-surface: #151d28;
      --c-surface-2: #1c2633;
      --c-ink: #e4eaf0;
      --c-ink-2: #98a8b8;
      --c-ink-3: #5e7082;
      --c-line: #253040;
      --c-accent: #26bfae;
      --c-accent-ink: #0c1219;
      --c-primary: #ffc233;
      --c-primary-ink: #1a1d23;
      --c-success: #4eca6e;
      --c-warning: #f0a030;
      --c-error: #ff6b6b;
      --c-header-from: #080e16;
      --c-header-to: #0a3d3a;
      --c-header-text: #e4eaf0;
      --c-header-muted: rgba(228,234,240,0.65);
      --c-header-input: rgba(255,255,255,0.08);
      --c-header-input-bg: rgba(21,29,40,0.95);
      --c-header-input-text: #e4eaf0;
      --c-header-input-placeholder: #5e7082;
      --c-focus: #26bfae;
      --c-hourly-active-bg: #1a3a36;
      --c-hourly-active-border: #26bfae;
      --c-detail-item-bg: #1c2633;
      --c-link: #26bfae;
      --c-text-muted: #5e7082;
      --c-spinner-track: #253040;
      --c-spinner-fill: #26bfae;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.2);
      --shadow-md: 0 4px 12px rgba(0,0,0,0.3);
      --shadow-lg: 0 8px 28px rgba(0,0,0,0.4);
    }
  }

  :root[data-theme="dark"] {
    --c-bg: #0c1219;
    --c-surface: #151d28;
    --c-surface-2: #1c2633;
    --c-ink: #e4eaf0;
    --c-ink-2: #98a8b8;
    --c-ink-3: #5e7082;
    --c-line: #253040;
    --c-accent: #26bfae;
    --c-accent-ink: #0c1219;
    --c-primary: #ffc233;
    --c-primary-ink: #1a1d23;
    --c-success: #4eca6e;
    --c-warning: #f0a030;
    --c-error: #ff6b6b;
    --c-header-from: #080e16;
    --c-header-to: #0a3d3a;
    --c-header-text: #e4eaf0;
    --c-header-muted: rgba(228,234,240,0.65);
    --c-header-input: rgba(255,255,255,0.08);
    --c-header-input-bg: rgba(21,29,40,0.95);
    --c-header-input-text: #e4eaf0;
    --c-header-input-placeholder: #5e7082;
    --c-focus: #26bfae;
    --c-hourly-active-bg: #1a3a36;
    --c-hourly-active-border: #26bfae;
    --c-detail-item-bg: #1c2633;
    --c-link: #26bfae;
    --c-text-muted: #5e7082;
    --c-spinner-track: #253040;
    --c-spinner-fill: #26bfae;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.2);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.3);
    --shadow-lg: 0 8px 28px rgba(0,0,0,0.4);
  }

  :root[data-theme="light"] {
    --c-bg: #f5f3ef;
    --c-surface: #ffffff;
    --c-surface-2: #f0ede8;
    --c-ink: #1a1d23;
    --c-ink-2: #4a5060;
    --c-ink-3: #7c8494;
    --c-line: #e0ddd6;
    --c-accent: #0e7c7b;
    --c-accent-ink: #ffffff;
    --c-primary: #d4940a;
    --c-primary-ink: #1a1d23;
    --c-success: #2d8a4e;
    --c-warning: #c77c14;
    --c-error: #c43e3e;
    --c-header-from: #142c4d;
    --c-header-to: #0e7c7b;
    --c-header-text: #ffffff;
    --c-header-muted: rgba(255,255,255,0.75);
    --c-header-input: rgba(255,255,255,0.12);
    --c-header-input-bg: rgba(255,255,255,0.95);
    --c-header-input-text: #1a1d23;
    --c-header-input-placeholder: #8a97a3;
    --c-focus: #0e7c7b;
    --c-hourly-active-bg: #e8f5f4;
    --c-hourly-active-border: #0e7c7b;
    --c-detail-item-bg: #f5f3ef;
    --c-link: #0e7c7b;
    --c-text-muted: #7c8494;
    --c-spinner-track: #e0ddd6;
    --c-spinner-fill: #0e7c7b;
    --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
    --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
    --shadow-lg: 0 8px 28px rgba(0,0,0,0.12);
  }

  /* ═══════════════════════════════════════════════════
     BASE
     ═══════════════════════════════════════════════════ */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  html {
    transition: background-color var(--dur-slow) var(--ease);
  }

  body {
    min-height: 100dvh;
    font-family: var(--font);
    font-size: var(--step-0);
    line-height: 1.6;
    color: var(--c-ink);
    background: var(--c-bg);
    transition: background-color var(--dur-slow) var(--ease), color var(--dur-slow) var(--ease);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }

  /* ═══════════════════════════════════════════════════
     FOCUS
     ═══════════════════════════════════════════════════ */
  :focus-visible {
    outline: 2px solid var(--c-focus);
    outline-offset: 2px;
    border-radius: 2px;
  }
  :focus:not(:focus-visible) { outline: none; }

  /* ═══════════════════════════════════════════════════
     SKIP LINK
     ═══════════════════════════════════════════════════ */
  .skip-link {
    position: absolute;
    left: -9999px;
    top: var(--sp-s);
    z-index: 9999;
    background: var(--c-accent);
    color: var(--c-accent-ink);
    padding: var(--sp-2xs) var(--sp-s);
    border-radius: var(--radius-sm);
    font-weight: 600;
    text-decoration: none;
  }
  .skip-link:focus { left: var(--sp-s); }

  /* ═══════════════════════════════════════════════════
     HEADER / MASTHEAD
     ═══════════════════════════════════════════════════ */
  .masthead {
    position: relative;
    background: linear-gradient(160deg, var(--c-header-from) 0%, var(--c-header-to) 100%);
    padding: var(--sp-xl) var(--sp-m) var(--sp-2xl);
    overflow: hidden;
    transition: background var(--dur-slow) var(--ease);
  }

  .masthead::before {
    content: "";
    position: absolute;
    inset: 0;
    opacity: 0.05;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cg fill='none' stroke='%23FFFFFF' stroke-width='0.8'%3E%3Ccircle cx='30' cy='30' r='20'/%3E%3Ccircle cx='30' cy='30' r='10'/%3E%3Cline x1='30' y1='10' x2='30' y2='50'/%3E%3Cline x1='10' y1='30' x2='50' y2='30'/%3E%3C/g%3E%3C/svg%3E");
    background-size: 60px 60px;
    pointer-events: none;
  }

  .masthead-inner {
    position: relative;
    max-width: 520px;
    margin: 0 auto;
    text-align: center;
    color: var(--c-header-text);
  }

  .masthead h1 {
    font-size: clamp(1.4rem, 4vw, 1.75rem);
    font-weight: 800;
    letter-spacing: -0.01em;
    margin: 0 0 var(--sp-3xs);
    line-height: 1.2;
  }

  .today-label {
    font-size: var(--step--1);
    color: var(--c-header-muted);
    margin: 0 0 var(--sp-m);
    font-weight: 400;
  }

  /* ── Search Component ── */
  .search-form {
    display: flex;
    flex-direction: column;
    gap: var(--sp-xs);
    margin-bottom: var(--sp-s);
  }

  .search-row {
    display: flex;
    gap: var(--sp-2xs);
    position: relative;
  }

  .search-input {
    flex: 1;
    min-width: 0;
    padding: var(--sp-xs) var(--sp-m);
    padding-left: var(--sp-xl);
    border-radius: var(--radius-md);
    border: 2px solid transparent;
    font-family: var(--font);
    font-size: var(--step-0);
    background: var(--c-header-input-bg);
    color: var(--c-header-input-text);
    transition: border-color var(--dur) var(--ease), box-shadow var(--dur) var(--ease);
  }
  .search-input::placeholder { color: var(--c-header-input-placeholder); }
  .search-input:focus {
    outline: none;
    border-color: var(--c-header-text);
    box-shadow: 0 0 0 3px rgba(255,255,255,0.2);
  }

  .search-icon {
    position: absolute;
    right: var(--sp-xs);
    top: 50%;
    transform: translateY(-50%);
    color: var(--c-header-input-placeholder);
    pointer-events: none;
  }

  .btn-search {
    flex: 0 0 auto;
    padding: var(--sp-xs) var(--sp-m);
    border-radius: var(--radius-md);
    border: none;
    background: var(--c-primary);
    color: var(--c-primary-ink);
    font-family: var(--font);
    font-size: var(--step-0);
    font-weight: 700;
    cursor: pointer;
    min-height: 44px;
    transition: transform var(--dur-fast) var(--ease), opacity var(--dur) var(--ease);
  }
  .btn-search:hover { opacity: 0.9; }
  .btn-search:active { transform: scale(0.97); }
  .btn-search:disabled { opacity: 0.5; cursor: not-allowed; }

  .search-actions {
    display: flex;
    gap: var(--sp-2xs);
    justify-content: center;
  }

  .btn-icon {
    flex: 0 0 auto;
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    border: none;
    background: var(--c-header-input);
    color: var(--c-header-text);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background var(--dur) var(--ease), transform var(--dur-fast) var(--ease);
  }
  .btn-icon:hover { background: rgba(255,255,255,0.2); }
  .btn-icon:active { transform: scale(0.94); }
  .btn-icon svg { pointer-events: none; }
  .btn-icon[aria-busy="true"] svg { animation: spin 1s linear infinite; }

  .btn-locate {
    background: none;
    border: none;
    color: var(--c-header-muted);
    font-family: var(--font);
    font-size: var(--step--1);
    cursor: pointer;
    padding: var(--sp-3xs) var(--sp-xs);
    text-decoration: underline;
    text-underline-offset: 3px;
    min-height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-3xs);
    transition: color var(--dur) var(--ease);
  }
  .btn-locate:hover { color: var(--c-header-text); }
  .btn-locate svg { flex-shrink: 0; }

  /* ═══════════════════════════════════════════════════
     LAYOUT
     ═══════════════════════════════════════════════════ */
  .page {
    max-width: 520px;
    margin: calc(-1 * var(--sp-xl)) auto 0;
    padding: 0 var(--sp-s) var(--sp-xl);
    position: relative;
  }

  .card {
    background: var(--c-surface);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-md);
    padding: var(--sp-m);
    margin-bottom: var(--sp-s);
    transition: background var(--dur-slow) var(--ease), box-shadow var(--dur-slow) var(--ease);
  }

  /* ═══════════════════════════════════════════════════
     STATES
     ═══════════════════════════════════════════════════ */
  .state-msg {
    text-align: center;
    padding: var(--sp-xl) var(--sp-s);
    color: var(--c-ink-2);
    font-size: var(--step-0);
    line-height: 1.7;
  }
  .state-msg--error { color: var(--c-error); }
  .state-msg--error .state-icon { color: var(--c-error); }
  .state-msg .state-icon {
    font-size: 2.5rem;
    display: block;
    margin-bottom: var(--sp-s);
  }
  .state-msg .state-hint {
    font-size: var(--step--1);
    color: var(--c-ink-3);
    margin-top: var(--sp-2xs);
  }
  .state-msg .btn-retry {
    display: inline-flex;
    align-items: center;
    gap: var(--sp-2xs);
    margin-top: var(--sp-s);
    padding: var(--sp-2xs) var(--sp-m);
    border-radius: var(--radius-md);
    border: none;
    background: var(--c-accent);
    color: var(--c-accent-ink);
    font-family: var(--font);
    font-size: var(--step-0);
    font-weight: 600;
    cursor: pointer;
    min-height: 44px;
    transition: opacity var(--dur) var(--ease);
  }
  .state-msg .btn-retry:hover { opacity: 0.85; }

  .spinner {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 3px solid var(--c-spinner-track);
    border-top-color: var(--c-spinner-fill);
    margin: 0 auto var(--sp-s);
    animation: spin 0.8s linear infinite;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* ═══════════════════════════════════════════════════
     WEATHER CARD — Current
     ═══════════════════════════════════════════════════ */
  .weather-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: var(--sp-s);
    margin-bottom: var(--sp-xs);
  }
  .weather-header .city-name {
    font-size: var(--step-2);
    font-weight: 700;
    line-height: 1.2;
    margin: 0;
  }
  .weather-header .region-line {
    font-size: var(--step--1);
    color: var(--c-ink-3);
    margin: var(--sp-3xs) 0 0;
  }
  .weather-header .weather-icon {
    font-size: 2.8rem;
    line-height: 1;
    flex-shrink: 0;
  }

  .hero-temp {
    display: flex;
    align-items: baseline;
    gap: var(--sp-2xs);
    margin: var(--sp-xs) 0 var(--sp-3xs);
  }
  .hero-temp .temp-value {
    font-size: clamp(3rem, 10vw, 4rem);
    font-weight: 900;
    letter-spacing: -0.03em;
    line-height: 1;
    font-variant-numeric: tabular-nums;
  }
  .hero-temp .temp-unit {
    font-size: var(--step-2);
    font-weight: 600;
    color: var(--c-ink-3);
  }

  .weather-desc {
    font-size: var(--step-0);
    color: var(--c-ink-2);
    margin: 0 0 var(--sp-3xs);
  }
  .weather-minmax {
    font-size: var(--step--1);
    color: var(--c-ink-3);
    margin: 0 0 var(--sp-m);
  }

  /* ── Stats Grid ── */
  .stat-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--sp-xs);
    padding-top: var(--sp-m);
    border-top: 1px solid var(--c-line);
  }
  .stat-item {
    text-align: center;
    padding: var(--sp-xs) var(--sp-3xs);
    border-radius: var(--radius-sm);
    transition: background var(--dur) var(--ease);
  }
  .stat-item:hover { background: var(--c-surface-2); }
  .stat-item .stat-icon {
    font-size: 1.1rem;
    display: block;
    margin-bottom: var(--sp-3xs);
  }
  .stat-item .stat-val {
    font-size: var(--step-0);
    font-weight: 700;
    display: block;
    font-variant-numeric: tabular-nums;
  }
  .stat-item .stat-lbl {
    font-size: 0.7rem;
    color: var(--c-ink-3);
    display: block;
    margin-top: 2px;
  }

  /* ── Details Expandable ── */
  .details-expand {
    margin-top: var(--sp-m);
    border-top: 1px solid var(--c-line);
    padding-top: var(--sp-xs);
  }
  .details-expand summary {
    cursor: pointer;
    font-size: var(--step--1);
    font-weight: 600;
    color: var(--c-accent);
    list-style: none;
    display: flex;
    align-items: center;
    gap: var(--sp-2xs);
    min-height: 44px;
    padding: var(--sp-2xs) 0;
  }
  .details-expand summary::-webkit-details-marker { display: none; }
  .details-expand summary::before {
    content: "+";
    font-weight: 900;
    font-size: var(--step-1);
    width: 20px;
    text-align: center;
  }
  .details-expand[open] summary::before { content: "\2212"; }

  .extra-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--sp-2xs);
    margin-top: var(--sp-s);
  }
  .extra-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: var(--step--1);
    background: var(--c-detail-item-bg);
    border-radius: var(--radius-sm);
    padding: var(--sp-2xs) var(--sp-xs);
    transition: background var(--dur) var(--ease);
  }
  .extra-item .ek { color: var(--c-ink-3); }
  .extra-item .ev { font-weight: 700; font-variant-numeric: tabular-nums; }

  /* ═══════════════════════════════════════════════════
     FORECAST CARD
     ═══════════════════════════════════════════════════ */
  .forecast-title {
    font-size: var(--step-0);
    font-weight: 700;
    margin: 0 0 var(--sp-s);
    display: flex;
    align-items: center;
    gap: var(--sp-2xs);
  }

  /* ── Day Tabs ── */
  .day-tabs {
    display: flex;
    gap: var(--sp-2xs);
    margin-bottom: var(--sp-m);
  }
  .day-tab {
    flex: 1;
    text-align: center;
    padding: var(--sp-xs) var(--sp-2xs);
    border-radius: var(--radius-md);
    background: var(--c-surface-2);
    border: 2px solid transparent;
    cursor: pointer;
    font-family: var(--font);
    min-height: 44px;
    transition: background var(--dur) var(--ease), border-color var(--dur) var(--ease), color var(--dur) var(--ease);
  }
  .day-tab:hover { border-color: var(--c-line); }
  .day-tab[aria-selected="true"] {
    background: var(--c-accent);
    border-color: var(--c-accent);
    color: var(--c-accent-ink);
  }
  .day-tab .tab-name {
    font-size: var(--step--1);
    font-weight: 700;
    display: block;
    line-height: 1.3;
  }
  .day-tab .tab-range {
    font-size: 0.7rem;
    opacity: 0.85;
    font-variant-numeric: tabular-nums;
  }

  /* ── Hourly Strip ── */
  .hourly-strip {
    display: flex;
    gap: var(--sp-2xs);
    overflow-x: auto;
    padding-bottom: var(--sp-2xs);
    scrollbar-width: thin;
    scroll-snap-type: x proximity;
    -webkit-overflow-scrolling: touch;
  }
  .hourly-strip::-webkit-scrollbar { height: 4px; }
  .hourly-strip::-webkit-scrollbar-track { background: var(--c-surface-2); border-radius: 2px; }
  .hourly-strip::-webkit-scrollbar-thumb { background: var(--c-line); border-radius: 2px; }

  .hour-card {
    flex: 0 0 auto;
    min-width: 68px;
    text-align: center;
    background: var(--c-surface-2);
    border-radius: var(--radius-md);
    padding: var(--sp-xs) var(--sp-2xs);
    cursor: pointer;
    border: 2px solid transparent;
    scroll-snap-align: start;
    transition: background var(--dur) var(--ease), border-color var(--dur) var(--ease);
  }
  .hour-card:hover { border-color: var(--c-line); }
  .hour-card[aria-selected="true"] {
    border-color: var(--c-hourly-active-border);
    background: var(--c-hourly-active-bg);
  }
  .hour-card .hc-time {
    font-size: 0.7rem;
    color: var(--c-ink-3);
    margin-bottom: var(--sp-3xs);
    font-variant-numeric: tabular-nums;
  }
  .hour-card .hc-icon { font-size: 1.3rem; margin-bottom: var(--sp-3xs); }
  .hour-card .hc-temp {
    font-size: var(--step--1);
    font-weight: 700;
    font-variant-numeric: tabular-nums;
  }
  .hour-card .hc-rain {
    font-size: 0.65rem;
    color: var(--c-accent);
    margin-top: 2px;
    font-variant-numeric: tabular-nums;
  }

  /* ── Hour Detail ── */
  .hour-detail {
    margin-top: var(--sp-m);
    padding-top: var(--sp-m);
    border-top: 1px solid var(--c-line);
  }
  .hour-detail-title {
    font-size: var(--step--1);
    font-weight: 700;
    color: var(--c-ink-3);
    margin: 0 0 var(--sp-s);
  }

  /* ═══════════════════════════════════════════════════
     SUN & MOON CARD
     ═══════════════════════════════════════════════════ */
  .sm-title {
    font-size: var(--step-0);
    font-weight: 700;
    margin: 0 0 var(--sp-m);
    display: flex;
    align-items: center;
    gap: var(--sp-2xs);
  }
  .sm-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--sp-2xs);
  }
  .sm-item {
    text-align: center;
    padding: var(--sp-xs) var(--sp-3xs);
    border-radius: var(--radius-sm);
    background: var(--c-surface-2);
    transition: background var(--dur) var(--ease);
  }
  .sm-item .sm-icon { font-size: 1.2rem; display: block; margin-bottom: var(--sp-3xs); }
  .sm-item .sm-val { font-size: var(--step--1); font-weight: 700; display: block; }
  .sm-item .sm-lbl { font-size: 0.65rem; color: var(--c-ink-3); }
  .sm-footer {
    text-align: center;
    font-size: var(--step--1);
    color: var(--c-ink-3);
    padding-top: var(--sp-s);
    border-top: 1px solid var(--c-line);
    margin-top: var(--sp-s);
    line-height: 1.8;
  }

  /* ═══════════════════════════════════════════════════
     LOCATION CARD
     ═══════════════════════════════════════════════════ */
  .loc-address {
    font-size: var(--step--1);
    color: var(--c-ink-2);
    line-height: 1.7;
    background: var(--c-detail-item-bg);
    border-radius: var(--radius-md);
    padding: var(--sp-xs) var(--sp-s);
    margin: 0 0 var(--sp-s);
    transition: background var(--dur) var(--ease);
  }
  .loc-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--sp-2xs);
  }
  .loc-item {
    background: var(--c-detail-item-bg);
    border-radius: var(--radius-md);
    padding: var(--sp-xs) var(--sp-s);
    text-align: center;
    transition: background var(--dur) var(--ease);
  }
  .loc-item .loc-val {
    font-weight: 700;
    font-size: var(--step-0);
    display: block;
    font-variant-numeric: tabular-nums;
  }
  .loc-item .loc-lbl {
    font-size: 0.7rem;
    color: var(--c-ink-3);
  }
  .loc-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--sp-2xs);
    text-align: center;
    margin-top: var(--sp-s);
    font-size: var(--step--1);
    color: var(--c-link);
    text-decoration: none;
    font-weight: 600;
    min-height: 44px;
    transition: opacity var(--dur) var(--ease);
  }
  .loc-link:hover { opacity: 0.7; }

  /* ── Footnote ── */
  .footnote {
    margin-top: var(--sp-xs);
    font-size: 0.7rem;
    color: var(--c-text-muted);
    text-align: center;
  }
  .footnote a { color: var(--c-link); text-decoration: none; }
  .footnote a:hover { text-decoration: underline; }

  /* ═══════════════════════════════════════════════════
     SCROLLBAR
     ═══════════════════════════════════════════════════ */
  @media (prefers-color-scheme: dark) {
    :root:not([data-theme="light"]) {
      scrollbar-color: var(--c-accent) var(--c-surface);
    }
  }
  :root[data-theme="dark"] { scrollbar-color: var(--c-accent) var(--c-surface); }
  :root[data-theme="light"] { scrollbar-color: var(--c-accent) var(--c-surface); }

  /* ═══════════════════════════════════════════════════
     RESPONSIVE — Tablet
     ═══════════════════════════════════════════════════ */
  @media (min-width: 600px) {
    .masthead { padding: var(--sp-2xl) var(--sp-l) calc(var(--sp-2xl) + var(--sp-m)); }
    .masthead-inner { max-width: 580px; }
    .page { max-width: 640px; padding: 0 var(--sp-m) var(--sp-xl); }
    .card { padding: var(--sp-l); }
    .hero-temp .temp-value { font-size: clamp(3.5rem, 8vw, 4.5rem); }
  }

  /* ═══════════════════════════════════════════════════
     RESPONSIVE — Desktop
     ═══════════════════════════════════════════════════ */
  @media (min-width: 900px) {
    .masthead { padding: var(--sp-2xl) var(--sp-l) calc(var(--sp-2xl) + var(--sp-l)); }
    .masthead-inner { max-width: 640px; }
    .search-form { flex-direction: row; align-items: center; max-width: 520px; margin-inline: auto; }
    .search-row { flex: 1; }

    .page {
      max-width: 1040px;
      margin: calc(-1 * var(--sp-2xl)) auto 0;
      padding: 0 var(--sp-l) var(--sp-2xl);
      display: grid;
      grid-template-columns: 380px 1fr;
      grid-template-areas:
        "current forecast"
        "sunmoon forecast"
        "location forecast"
        "footnote footnote";
      gap: var(--sp-m);
      align-items: start;
    }
    #weatherCard { grid-area: current; margin-bottom: 0; }
    #sunMoonCard { grid-area: sunmoon; margin-bottom: 0; }
    #locationCard { grid-area: location; margin-bottom: 0; }
    #forecastCard { grid-area: forecast; margin-bottom: 0; align-self: start; }
    .footnote { grid-area: footnote; }

    .card { padding: var(--sp-l); }
    .hero-temp .temp-value { font-size: clamp(3.5rem, 6vw, 5rem); }
    .stat-grid { grid-template-columns: repeat(4, 1fr); gap: var(--sp-xs); }
    .hourly-strip { flex-wrap: wrap; overflow-x: visible; }
    .hour-card { min-width: 80px; }
    .sm-grid { gap: var(--sp-xs); }
  }

  @media (min-width: 1100px) {
    .page { grid-template-columns: 420px 1fr; }
  }

  /* ═══════════════════════════════════════════════════
     REDUCED MOTION
     ═══════════════════════════════════════════════════ */
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
      scroll-behavior: auto !important;
    }
  }
</style>
</head>
<body>

<a href="#main" class="skip-link">رفتن به محتوا</a>

<header class="masthead" role="banner">
  <div class="masthead-inner">
    <h1>وضعیت آب و هوا</h1>
    <p class="today-label" id="todayFa" aria-live="polite">—</p>

    <form class="search-form" role="search" aria-label="جستجوی شهر" onsubmit="return false;">
      <div class="search-row">
        <label for="cityInput" class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip-path:inset(50%);white-space:nowrap;">نام شهر</label>
        <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
          <circle cx="11" cy="11" r="8"></circle>
          <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="cityInput" class="search-input" placeholder="نام شهر را وارد کنید… مثلاً Isfahan" autocomplete="off" aria-describedby="searchHint">
        <button id="searchBtn" class="btn-search" type="submit">جستجو</button>
      </div>
      <span id="searchHint" class="sr-only" style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip-path:inset(50%);white-space:nowrap;">نام شهر فارسی یا انگلیسی را تایپ کنید و دکمه جستجو را بزنید</span>

      <div class="search-actions">
        <button id="refreshBtn" class="btn-icon" type="button" aria-label="به‌روزرسانی اطلاعات آب و هوا" title="به‌روزرسانی">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M23 4v6h-6"></path>
            <path d="M1 20v-6h6"></path>
            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
          </svg>
        </button>
        <button id="themeToggle" class="btn-icon" type="button" aria-label="تغییر تم روشن/تاریک" title="تغییر تم">
          <svg id="themeIconSun" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
          <svg id="themeIconMoon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
        </button>
        <button id="locateBtn" class="btn-icon" type="button" aria-label="استفاده از موقعیت مکانی من" title="موقعیت من">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
            <circle cx="12" cy="10" r="3"></circle>
          </svg>
        </button>
      </div>
    </form>
  </div>
</header>

<main id="main" class="page" tabindex="-1">

  <div class="card" id="weatherCard" role="region" aria-label="وضعیت فعلی آب و هوا">
    <div class="state-msg" id="stateMsg">
      <div class="spinner" aria-hidden="true"></div>
      <span aria-live="polite">در حال دریافت آب و هوای تهران…</span>
    </div>
  </div>

  <div class="card" id="sunMoonCard" role="region" aria-label="اطلاعات خورشید و ماه" style="display:none;"></div>

  <div class="card" id="forecastCard" role="region" aria-label="پیش‌بینی آب و هوا" style="display:none;"></div>

  <div class="card" id="locationCard" role="region" aria-label="اطلاعات موقعیت مکانی" style="display:none;"></div>

  <p class="footnote">منبع داده: <a href="https://wttr.in" target="_blank" rel="noopener noreferrer">wttr.in</a></p>
</main>

<script>
(function(){
  var cityInput    = document.getElementById('cityInput');
  var searchBtn    = document.getElementById('searchBtn');
  var locateBtn    = document.getElementById('locateBtn');
  var refreshBtn   = document.getElementById('refreshBtn');
  var themeToggle  = document.getElementById('themeToggle');
  var themeIconSun = document.getElementById('themeIconSun');
  var themeIconMoon= document.getElementById('themeIconMoon');
  var weatherCard  = document.getElementById('weatherCard');
  var sunMoonCard  = document.getElementById('sunMoonCard');
  var forecastCard = document.getElementById('forecastCard');
  var locationCard = document.getElementById('locationCard');
  var todayFaEl    = document.getElementById('todayFa');

  var DEFAULT_CITY = 'Tehran';
  var currentForecast = [];
  var activeDayIndex = 0;
  var activeHourIndex = 0;

  /* ─── Theme ─── */
  function getSystemTheme() {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
  }
  function getInitialTheme() {
    var saved = localStorage.getItem('theme');
    if (saved === 'light' || saved === 'dark') return saved;
    return getSystemTheme();
  }
  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
      themeIconSun.style.display = 'block';
      themeIconMoon.style.display = 'none';
    } else {
      themeIconSun.style.display = 'none';
      themeIconMoon.style.display = 'block';
    }
  }
  function toggleTheme() {
    var current = document.documentElement.getAttribute('data-theme') || getSystemTheme();
    applyTheme(current === 'dark' ? 'light' : 'dark');
  }
  themeToggle.addEventListener('click', toggleTheme);

  /* ─── Persian Calendar ─── */
  function toPersianDigits(input) {
    var map = {'0':'۰','1':'۱','2':'۲','3':'۳','4':'۴','5':'۵','6':'۶','7':'۷','8':'۸','9':'۹'};
    return String(input).replace(/[0-9]/g, function(d){ return map[d]; });
  }

  function gregorianToJalali(gy, gm, gd) {
    var g_d_m = [0,31,59,90,120,151,181,212,243,273,304,334];
    var gy2 = (gm > 2) ? (gy + 1) : gy;
    var days = 355666 + (365 * gy) + Math.floor((gy2 + 3) / 4) - Math.floor((gy2 + 99) / 100) +
               Math.floor((gy2 + 399) / 400) + gd + g_d_m[gm - 1];
    var jy = -1595 + (33 * Math.floor(days / 12053));
    days %= 12053;
    jy += 4 * Math.floor(days / 1461);
    days %= 1461;
    if (days > 365) {
      jy += Math.floor((days - 1) / 365);
      days = (days - 1) % 365;
    }
    var jm, jd;
    if (days < 186) { jm = 1 + Math.floor(days / 31); jd = 1 + (days % 31); }
    else { jm = 7 + Math.floor((days - 186) / 30); jd = 1 + ((days - 186) % 30); }
    return [jy, jm, jd];
  }

  var JALALI_MONTHS = ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
  var WEEKDAYS_FA = { 0:'یکشنبه', 1:'دوشنبه', 2:'سه‌شنبه', 3:'چهارشنبه', 4:'پنجشنبه', 5:'جمعه', 6:'شنبه' };

  function jalaliLabelFromDate(dateObj) {
    var r = gregorianToJalali(dateObj.getFullYear(), dateObj.getMonth()+1, dateObj.getDate());
    var weekday = WEEKDAYS_FA[dateObj.getDay()];
    return weekday + ' ' + toPersianDigits(r[2]) + ' ' + JALALI_MONTHS[r[1]-1] + ' ' + toPersianDigits(r[0]);
  }
  function shortJalaliFromISODate(isoDateStr) {
    var parts = isoDateStr.split('-').map(Number);
    var r = gregorianToJalali(parts[0], parts[1], parts[2]);
    return toPersianDigits(r[2]) + ' ' + JALALI_MONTHS[r[1]-1];
  }
  function weekdayFaFromISODate(isoDateStr) {
    var d = new Date(isoDateStr + 'T00:00:00');
    return WEEKDAYS_FA[d.getDay()];
  }

  todayFaEl.textContent = jalaliLabelFromDate(new Date());

  /* ─── Display Maps ─── */
  var ICONS = {
    '113': '☀️', '116': '⛅', '119': '☁️', '122': '☁️',
    '143': '🌫️', '248': '🌫️', '260': '🌫️',
    '176': '🌦️', '263': '🌦️', '266': '🌦️', '293': '🌦️', '353': '🌦️',
    '179': '🌨️', '182': '🌨️', '317': '🌨️', '320': '🌨️', '323': '🌨️', '362': '🌨️', '365': '🌨️', '368': '🌨️',
    '185': '🌧️', '281': '🌧️', '284': '🌧️', '296': '🌧️', '299': '🌧️', '302': '🌧️',
    '305': '🌧️', '308': '🌧️', '311': '🌧️', '314': '🌧️', '356': '🌧️',
    '200': '⛈️', '359': '⛈️', '386': '⛈️', '389': '⛈️', '392': '⛈️', '395': '⛈️',
    '227': '🌨️', '230': '❄️', '326': '❄️', '329': '❄️', '332': '❄️', '335': '❄️', '338': '❄️', '371': '❄️',
    '350': '🧊', '374': '🧊', '377': '🧊'
  };
  function iconFor(code) { return ICONS[String(code)] || '⛅'; }

  var WIND_FA = {
    'N':'شمال','NNE':'شمال شمال‌شرقی','NE':'شمال‌شرقی','ENE':'شرق شمال‌شرقی',
    'E':'شرق','ESE':'شرق جنوب‌شرقی','SE':'جنوب‌شرقی','SSE':'جنوب جنوب‌شرقی',
    'S':'جنوب','SSW':'جنوب جنوب‌غربی','SW':'جنوب‌غربی','WSW':'غرب جنوب‌غربی',
    'W':'غرب','WNW':'غرب شمال‌غربی','NW':'شمال‌غربی','NNW':'شمال شمال‌غربی'
  };
  function windFa(dir) { return WIND_FA[dir] || dir || '—'; }

  var MOON_FA = {
    'New Moon':'ماه نو', 'Waxing Crescent':'هلال رو به رشد', 'First Quarter':'تربیع اول',
    'Waxing Gibbous':'بدر ناقص (رو به رشد)', 'Full Moon':'ماه کامل (بدر)',
    'Waning Gibbous':'بدر ناقص (رو به کاهش)', 'Last Quarter':'تربیع آخر', 'Waning Crescent':'هلال رو به کاهش'
  };
  function moonFa(phase) { return MOON_FA[phase] || phase || '—'; }

  function uvLevelFa(uv) {
    var v = parseInt(uv, 10);
    if (isNaN(v)) return '—';
    if (v <= 2) return 'کم';
    if (v <= 5) return 'متوسط';
    if (v <= 7) return 'زیاد';
    if (v <= 10) return 'خیلی‌زیاد';
    return 'شدید';
  }

  function timeAmPmToFa(t) {
    if (!t) return '—';
    var m = t.match(/(\d+):(\d+)\s*(AM|PM)/i);
    if (!m) return t;
    var h = parseInt(m[1], 10);
    var min = m[2];
    var suffix = m[3].toUpperCase() === 'AM' ? 'ق.ظ' : 'ب.ظ';
    return toPersianDigits(String(h).padStart(2,'0')) + ':' + toPersianDigits(min) + ' ' + suffix;
  }

  function hourLabelToFa(hhmm) {
    var num = parseInt(hhmm, 10);
    var h = Math.floor(num / 100);
    return toPersianDigits(String(h).padStart(2,'0')) + ':۰۰';
  }

  /* ─── Render Helpers ─── */
  function escapeHtml(str) {
    var div = document.createElement('div');
    div.textContent = str == null ? '' : str;
    return div.innerHTML;
  }
  function fa(val) { return val == null ? '—' : toPersianDigits(val); }

  function setLoading(message) {
    weatherCard.innerHTML = '<div class="state-msg"><div class="spinner" aria-hidden="true"></div><span aria-live="polite">' + escapeHtml(message) + '</span></div>';
    sunMoonCard.style.display = 'none';
    forecastCard.style.display = 'none';
    locationCard.style.display = 'none';
  }

  function setError(message, hint) {
    var hintHtml = hint ? '<p class="state-hint">' + escapeHtml(hint) + '</p>' : '';
    weatherCard.innerHTML = '<div class="state-msg state-msg--error"><span class="state-icon" aria-hidden="true">⚠️</span><span aria-live="assertive">' + escapeHtml(message) + '</span>' + hintHtml + '<button class="btn-retry" type="button" onclick="document.getElementById(\'refreshBtn\').click()">تلاش مجدد</button></div>';
    sunMoonCard.style.display = 'none';
    forecastCard.style.display = 'none';
    locationCard.style.display = 'none';
  }

  function renderCurrent(data) {
    var icon = iconFor(data.weather_code);
    var today = data.forecast && data.forecast[0] ? data.forecast[0] : null;
    var regionLine = [data.region, data.country].filter(Boolean).join('، ');

    weatherCard.innerHTML = '' +
      '<div class="weather-header">' +
        '<div>' +
          '<p class="city-name">' + escapeHtml(data.city) + '</p>' +
          '<p class="region-line">' + escapeHtml(regionLine) + '</p>' +
        '</div>' +
        '<div class="weather-icon" aria-hidden="true">' + icon + '</div>' +
      '</div>' +

      '<div class="hero-temp">' +
        '<span class="temp-value">' + fa(data.temperature_c) + '</span>' +
        '<span class="temp-unit">°C</span>' +
      '</div>' +
      '<p class="weather-desc">' + escapeHtml(data.description) + '</p>' +
      '<p class="weather-minmax">' + (today ? ('بیشینه ' + fa(today.max_temp_c) + '° · کمینه ' + fa(today.min_temp_c) + '°') : '') + '</p>' +

      '<div class="stat-grid" role="list" aria-label="آمار آب و هوا">' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">🌡️</span><span class="stat-val">' + fa(data.feelslike_c) + '°</span><span class="stat-lbl">احساس می‌شود</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">💧</span><span class="stat-val">' + fa(data.humidity) + '٪</span><span class="stat-lbl">رطوبت</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">🧭</span><span class="stat-val">' + fa(data.wind_kmph) + ' km/h</span><span class="stat-lbl">باد از ' + escapeHtml(windFa(data.wind_dir)) + '</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">📊</span><span class="stat-val">' + fa(data.pressure) + '</span><span class="stat-lbl">فشار (hPa)</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">👁️</span><span class="stat-val">' + fa(data.visibility) + ' km</span><span class="stat-lbl">میدان دید</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">🔆</span><span class="stat-val">' + escapeHtml(uvLevelFa(data.uv_index)) + '</span><span class="stat-lbl">شاخص UV</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">☁️</span><span class="stat-val">' + fa(data.cloud_cover) + '٪</span><span class="stat-lbl">ابرناکی</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">🌧️</span><span class="stat-val">' + fa(data.precip_mm) + ' mm</span><span class="stat-lbl">بارش</span></div>' +
        '<div class="stat-item" role="listitem"><span class="stat-icon" aria-hidden="true">🌇</span><span class="stat-val">' + escapeHtml(timeAmPmToFa((data.forecast && data.forecast[0]) ? data.forecast[0].sunset : null)) + '</span><span class="stat-lbl">غروب آفتاب</span></div>' +
      '</div>' +

      '<details class="details-expand">' +
        '<summary>جزئیات بیشتر و واحدهای امپریال</summary>' +
        '<div class="extra-grid">' +
          '<div class="extra-item"><span class="ek">دما (فارنهایت)</span><span class="ev">' + fa(data.temperature_f) + '°F</span></div>' +
          '<div class="extra-item"><span class="ek">احساس‌شده (فارنهایت)</span><span class="ev">' + fa(data.feelslike_f) + '°F</span></div>' +
          '<div class="extra-item"><span class="ek">سرعت باد (مایل/ساعت)</span><span class="ev">' + fa(data.wind_miles) + ' mph</span></div>' +
          '<div class="extra-item"><span class="ek">جهت باد (درجه)</span><span class="ev">' + fa(data.wind_dir_deg) + '°</span></div>' +
          '<div class="extra-item"><span class="ek">فشار (اینچ جیوه)</span><span class="ev">' + fa(data.pressure_inches) + ' inHg</span></div>' +
          '<div class="extra-item"><span class="ek">میدان دید (مایل)</span><span class="ev">' + fa(data.visibility_miles) + ' mi</span></div>' +
          '<div class="extra-item"><span class="ek">بارش (اینچ)</span><span class="ev">' + fa(data.precip_inches) + ' in</span></div>' +
          '<div class="extra-item"><span class="ek">آخرین به‌روزرسانی</span><span class="ev">' + escapeHtml(data.observation_time || '—') + '</span></div>' +
        '</div>' +
      '</details>';

    renderLocation(data);
  }

  function renderLocation(data) {
    var hasCoords = data.latitude != null && data.longitude != null;
    locationCard.style.display = 'block';
    locationCard.innerHTML = '' +
      '<p class="sm-title"><span aria-hidden="true">📍</span> موقعیت</p>' +
      (data.full_address ? '<p class="loc-address">' + escapeHtml(data.full_address) + (hasCoords ? ' [' + data.latitude + '، ' + data.longitude + ']' : '') + '</p>' : '') +
      '<div class="loc-grid" role="list">' +
        '<div class="loc-item" role="listitem"><span class="loc-val">' + escapeHtml(data.region || '—') + '</span><span class="loc-lbl">استان / منطقه</span></div>' +
        '<div class="loc-item" role="listitem"><span class="loc-val">' + escapeHtml(data.country || '—') + '</span><span class="loc-lbl">کشور</span></div>' +
        '<div class="loc-item" role="listitem"><span class="loc-val">' + (data.population ? fa(data.population) + ' نفر' : '—') + '</span><span class="loc-lbl">جمعیت</span></div>' +
        '<div class="loc-item" role="listitem"><span class="loc-val">' + (hasCoords ? (fa(data.latitude) + '، ' + fa(data.longitude)) : '—') + '</span><span class="loc-lbl">مختصات جغرافیایی</span></div>' +
      '</div>' +
      (hasCoords ? '<a class="loc-link" target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps?q=' + encodeURIComponent(data.latitude + ',' + data.longitude) + '">🗺️ نمایش روی نقشه</a>' : '') +
      '<a class="loc-link" target="_blank" rel="noopener noreferrer" href="' + escapeHtml(data.weather_url) + '">مشاهده در wttr.in</a>';
  }

  function renderSunMoon(dayData) {
    if (!dayData) { sunMoonCard.style.display = 'none'; return; }
    sunMoonCard.style.display = 'block';
    sunMoonCard.innerHTML = '' +
      '<p class="sm-title"><span aria-hidden="true">🌗</span> خورشید و ماه</p>' +
      '<div class="sm-grid">' +
        '<div class="sm-item"><span class="sm-icon" aria-hidden="true">🌅</span><span class="sm-val">' + escapeHtml(timeAmPmToFa(dayData.sunrise)) + '</span><span class="sm-lbl">طلوع آفتاب</span></div>' +
        '<div class="sm-item"><span class="sm-icon" aria-hidden="true">🌇</span><span class="sm-val">' + escapeHtml(timeAmPmToFa(dayData.sunset)) + '</span><span class="sm-lbl">غروب آفتاب</span></div>' +
        '<div class="sm-item"><span class="sm-icon" aria-hidden="true">🌙</span><span class="sm-val">' + escapeHtml(timeAmPmToFa(dayData.moonrise)) + '</span><span class="sm-lbl">طلوع ماه</span></div>' +
        '<div class="sm-item"><span class="sm-icon" aria-hidden="true">🌑</span><span class="sm-val">' + escapeHtml(timeAmPmToFa(dayData.moonset)) + '</span><span class="sm-lbl">غروب ماه</span></div>' +
      '</div>' +
      '<p class="sm-footer">' + escapeHtml(moonFa(dayData.moon_phase)) + ' · روشنایی ' + fa(dayData.moon_illumination) + '٪<br>' +
      '☀️ ' + fa(dayData.sun_hour) + ' ساعت آفتابی امروز' + ((dayData.total_snow_cm && parseFloat(dayData.total_snow_cm) > 0) ? (' · ❄️ ' + fa(dayData.total_snow_cm) + ' سانتی‌متر برف') : '') + '</p>';
  }

  function renderHourly(dayData) {
    if (!dayData || !dayData.hourly) return '';
    return dayData.hourly.map(function(h, idx) {
      var selected = idx === activeHourIndex ? ' aria-selected="true"' : '';
      return '' +
        '<div class="hour-card"' + selected + ' role="option" tabindex="0" data-hour-idx="' + idx + '" aria-label="ساعت ' + hourLabelToFa(h.time) + '، ' + fa(h.temp_c) + ' درجه">' +
          '<div class="hc-time">' + hourLabelToFa(h.time) + '</div>' +
          '<div class="hc-icon" aria-hidden="true">' + iconFor(h.weather_code) + '</div>' +
          '<div class="hc-temp">' + fa(h.temp_c) + '°</div>' +
          '<div class="hc-rain">' + fa(h.chance_of_rain) + '٪ بارش</div>' +
        '</div>';
    }).join('');
  }

  var CHANCE_LABELS = [
    ['chance_of_rain', '🌧️', 'احتمال باران'],
    ['chance_of_snow', '❄️', 'احتمال برف'],
    ['chance_of_thunder', '⛈️', 'احتمال رعدوبرق'],
    ['chance_of_fog', '🌫️', 'احتمال مه'],
    ['chance_of_frost', '🧊', 'احتمال یخبندان'],
    ['chance_of_overcast', '☁️', 'احتمال ابری کامل'],
    ['chance_of_sunshine', '☀️', 'احتمال آفتابی بودن'],
    ['chance_of_windy', '🌬️', 'احتمال بادی بودن'],
    ['chance_of_remdry', '🏜️', 'احتمال خشک ماندن']
  ];

  function renderHourDetail(dayData, hourIdx) {
    if (!dayData || !dayData.hourly || !dayData.hourly[hourIdx]) return '';
    var h = dayData.hourly[hourIdx];
    var chanceItems = CHANCE_LABELS.map(function(entry) {
      var key = entry[0], icon = entry[1], label = entry[2];
      return '<div class="extra-item"><span class="ek">' + icon + ' ' + label + '</span><span class="ev">' + fa(h[key]) + '٪</span></div>';
    }).join('');

    return '' +
      '<div class="hour-detail" role="region" aria-label="جزئیات ساعت ' + hourLabelToFa(h.time) + '">' +
        '<p class="hour-detail-title">جزئیات ساعت ' + hourLabelToFa(h.time) + ' · ' + escapeHtml(h.description) + '</p>' +
        '<div class="extra-grid">' +
          '<div class="extra-item"><span class="ek">🌡️ احساس می‌شود</span><span class="ev">' + fa(h.feelslike_c) + '°C</span></div>' +
          '<div class="extra-item"><span class="ek">💧 رطوبت</span><span class="ev">' + fa(h.humidity) + '٪</span></div>' +
          '<div class="extra-item"><span class="ek">🧭 باد</span><span class="ev">' + fa(h.wind_kmph) + ' km/h از ' + escapeHtml(windFa(h.wind_dir)) + '</span></div>' +
          '<div class="extra-item"><span class="ek">🌬️ تندباد</span><span class="ev">' + fa(h.wind_gust_kmph) + ' km/h</span></div>' +
          '<div class="extra-item"><span class="ek">💦 نقطه شبنم</span><span class="ev">' + fa(h.dewpoint_c) + '°C</span></div>' +
          '<div class="extra-item"><span class="ek">🥶 سرمای باد</span><span class="ev">' + fa(h.windchill_c) + '°C</span></div>' +
          '<div class="extra-item"><span class="ek">🥵 شاخص گرما</span><span class="ev">' + fa(h.heatindex_c) + '°C</span></div>' +
          '<div class="extra-item"><span class="ek">📊 فشار</span><span class="ev">' + fa(h.pressure) + ' hPa</span></div>' +
          '<div class="extra-item"><span class="ek">👁️ میدان دید</span><span class="ev">' + fa(h.visibility) + ' km</span></div>' +
          '<div class="extra-item"><span class="ek">☁️ ابرناکی</span><span class="ev">' + fa(h.cloud_cover) + '٪</span></div>' +
          '<div class="extra-item"><span class="ek">🔆 شاخص UV</span><span class="ev">' + escapeHtml(uvLevelFa(h.uv_index)) + '</span></div>' +
          '<div class="extra-item"><span class="ek">☀️ تابش خورشیدی</span><span class="ev">' + fa(h.solar_radiation) + ' W/m²</span></div>' +
          chanceItems +
        '</div>' +
      '</div>';
  }

  function renderForecast(forecast) {
    currentForecast = forecast || [];
    if (!currentForecast.length) { forecastCard.style.display = 'none'; return; }
    forecastCard.style.display = 'block';
    activeDayIndex = 0;
    activeHourIndex = 0;
    renderForecastUI();
  }

  function renderForecastUI() {
    var tabsHtml = currentForecast.map(function(day, idx) {
      var label = idx === 0 ? 'امروز' : (idx === 1 ? 'فردا' : weekdayFaFromISODate(day.date));
      var selected = idx === activeDayIndex ? ' aria-selected="true"' : ' aria-selected="false"';
      var tabindex = idx === activeDayIndex ? ' tabindex="0"' : ' tabindex="-1"';
      return '' +
        '<button type="button" class="day-tab" role="tab"' + selected + tabindex + ' data-idx="' + idx + '" aria-label="' + escapeHtml(label) + '، بیشینه ' + fa(day.max_temp_c) + ' درجه، کمینه ' + fa(day.min_temp_c) + ' درجه">' +
          '<span class="tab-name">' + escapeHtml(label) + '</span>' +
          '<span class="tab-range">' + fa(day.max_temp_c) + '°/' + fa(day.min_temp_c) + '°</span>' +
        '</button>';
    }).join('');

    var dayData = currentForecast[activeDayIndex];

    forecastCard.innerHTML = '' +
      '<p class="forecast-title"><span aria-hidden="true">📅</span> پیش‌بینی ' + fa(currentForecast.length) + ' روز آینده</p>' +
      '<div class="day-tabs" role="tablist" aria-label="روزهای پیش‌بینی">' + tabsHtml + '</div>' +
      '<div class="hourly-strip" role="listbox" aria-label="پیش‌بینی ساعتی">' + renderHourly(dayData) + '</div>' +
      renderHourDetail(dayData, activeHourIndex);

    forecastCard.querySelectorAll('.day-tab').forEach(function(btn) {
      btn.addEventListener('click', function() {
        activeDayIndex = parseInt(btn.getAttribute('data-idx'), 10);
        activeHourIndex = 0;
        renderForecastUI();
        renderSunMoon(currentForecast[activeDayIndex]);
      });
      btn.addEventListener('keydown', function(e) {
        var tabs = Array.from(forecastCard.querySelectorAll('.day-tab'));
        var idx = tabs.indexOf(btn);
        var newIdx = -1;
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
          e.preventDefault();
          newIdx = e.key === 'ArrowLeft' ? (idx + 1) % tabs.length : (idx - 1 + tabs.length) % tabs.length;
        } else if (e.key === 'Home') { e.preventDefault(); newIdx = 0; }
        else if (e.key === 'End') { e.preventDefault(); newIdx = tabs.length - 1; }
        if (newIdx >= 0) {
          tabs[idx].setAttribute('tabindex', '-1');
          tabs[newIdx].setAttribute('tabindex', '0');
          tabs[newIdx].focus();
          tabs[newIdx].click();
        }
      });
    });

    forecastCard.querySelectorAll('.hour-card').forEach(function(card) {
      card.addEventListener('click', function() {
        activeHourIndex = parseInt(card.getAttribute('data-hour-idx'), 10);
        renderForecastUI();
      });
      card.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          card.click();
        }
      });
    });
  }

  /* ─── Fetch Weather ─── */
  function fetchWeather(location, loadingMessage) {
    setLoading(loadingMessage || ('در حال دریافت آب و هوای ' + location + '…'));
    refreshBtn.setAttribute('aria-busy', 'true');

    fetch('get_weather.php?location=' + encodeURIComponent(location))
      .then(function(res) { return res.json(); })
      .then(function(data) {
        refreshBtn.removeAttribute('aria-busy');
        if (!data.ok) {
          setError(
            data.error || 'دریافت اطلاعات آب و هوا با خطا مواجه شد.',
            'لطفاً نام شهر را بررسی کنید یا بعداً دوباره تلاش کنید.'
          );
          return;
        }
        renderCurrent(data);
        renderForecast(data.forecast);
        renderSunMoon(data.forecast && data.forecast[0]);
      })
      .catch(function() {
        refreshBtn.removeAttribute('aria-busy');
        setError(
          'ارتباط با سرور برقرار نشد.',
          'اتصال اینترنت خود را بررسی کنید و دوباره تلاش کنید.'
        );
      });
  }

  function useMyLocation() {
    if (!navigator.geolocation) {
      setError(
        'مرورگر شما از موقعیت مکانی پشتیبانی نمی‌کند.',
        'می‌توانید نام شهر را به صورت دستی وارد کنید.'
      );
      return;
    }
    setLoading('در حال دریافت موقعیت مکانی شما…');
    navigator.geolocation.getCurrentPosition(
      function(position) {
        var coords = position.coords.latitude.toFixed(4) + ',' + position.coords.longitude.toFixed(4);
        fetchWeather(coords, 'در حال دریافت آب و هوای موقعیت فعلی شما…');
      },
      function() {
        setError(
          'دسترسی به موقعیت مکانی فعال نشد.',
          'لطفاً دسترسی مکان را در تنظیمات مرورگر فعال کنید یا نام شهر را دستی وارد کنید.'
        );
      },
      { enableHighAccuracy: false, timeout: 8000, maximumAge: 10*60*1000 }
    );
  }

  /* ─── Events ─── */
  searchBtn.addEventListener('click', function() {
    var value = cityInput.value.trim();
    if (value !== '') fetchWeather(value);
  });
  cityInput.addEventListener('keydown', function(e) { if (e.key === 'Enter') { e.preventDefault(); searchBtn.click(); } });
  locateBtn.addEventListener('click', useMyLocation);
  refreshBtn.addEventListener('click', function() {
    var currentCity = cityInput.value.trim() || DEFAULT_CITY;
    fetchWeather(currentCity, 'در حال به‌روزرسانی آب و هوا…');
  });

  /* ─── Initial Load ─── */
  fetchWeather(DEFAULT_CITY, 'در حال دریافت آب و هوای تهران…');

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
      function(position) {
        var coords = position.coords.latitude.toFixed(4) + ',' + position.coords.longitude.toFixed(4);
        fetchWeather(coords, 'در حال دریافت آب و هوای موقعیت فعلی شما…');
      },
      function() { /* user denied — keep Tehran */ },
      { enableHighAccuracy: false, timeout: 8000, maximumAge: 10*60*1000 }
    );
  }

})();
</script>

</body>
</html>
