<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';
use App\Config;

$headerTitle = Config::get('product_name', 'Panduan Bisnis Digital');
$siteTitle   = Config::get('site_title', $headerTitle);
$siteTagline = Config::get('site_tagline', 'Langkah Praktis Memulai Karir di Era Digital');
$footerText  = Config::get('footer_text', 'Garansi kepuasan 100%.');
$favicon     = Config::get('favicon_file', '');

use App\Logger;
use App\TelegramBot;

// Redirect to setup if not configured
if (!Config::isSetupComplete()) {
    header('Location: /setup.php'); exit;
}

// Log visit
if ($pdo) {
    $bot    = new TelegramBot(Config::get('telegram_bot_token', ''));
    $admin  = (int) Config::get('telegram_admin_chat_id', 0);
    $logger = new Logger($pdo, $bot, $admin);
    $logger->log('/', 'page_view');

    // Only notify for new session visits
    if (empty($_SESSION['visited'])) {
        $_SESSION['visited'] = true;
        $logger->notifyTraffic('new_visit', [
            'Referer' => $_SERVER['HTTP_REFERER'] ?? 'Direct',
            'UA'      => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 60),
        ]);
    }
}

$price    = (int) Config::get('product_price', 309000);
$priceStr = 'Rp ' . number_format($price, 0, ',', '.');
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= htmlspecialchars($siteTitle) ?><?= $siteTagline ? ' — ' . htmlspecialchars($siteTagline) : '' ?></title>
<meta name="description" content="<?= htmlspecialchars($siteTitle) ?> — <?= htmlspecialchars($siteTagline) ?>. Hanya <?= $priceStr ?>.">
<?php if ($favicon): ?>
<link rel="icon" href="/assets/img/<?= htmlspecialchars($favicon) ?>?v=<?= time() ?>">
<?php endif; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<!-- ANNOUNCEMENT BAR -->
<div class="announce-bar">🚀 PENDAFTARAN DIBUKA! Panduan Bisnis & Karir Digital — <a href="#pricing">Dapatkan Sekarang →</a></div>

<!-- HEADER -->
<header class="header">
  <a href="/" class="header__logo">
    <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="16" cy="16" r="14" fill="#f59e0b"/>
      <text x="16" y="21" text-anchor="middle" font-size="14" font-weight="bold" fill="#fff">🚀</text>
    </svg>
    Kelas Digital
  </a>
  <nav class="header__nav">
    <a href="#features" class="btn btn--ghost btn--sm">Isi Modul</a>
    <a href="#pricing" class="btn btn--primary btn--sm" id="header-buy-btn">Daftar Sekarang</a>
  </nav>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero__eyebrow fade-up">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
    Terstruktur · Praktis · Untuk Pemula
  </div>
  <h1 class="hero__title fade-up fade-up--1" style="font-weight:700">
    Langkah Praktis Memulai<br><span>Karir & Bisnis Digital</span>
  </h1>
  <p class="hero__subtitle fade-up fade-up--2">
    Platform Freelance · Tools Produktivitas · Video Eksklusif · PDF Panduan Lengkap — semua dalam satu paket edukasi.
  </p>
  <div class="fade-up fade-up--3" style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
    <a href="#pricing" class="btn btn--primary btn--lg" id="hero-cta">Mulai Belajar — <?= $priceStr ?></a>
    <a href="#features" class="btn btn--ghost btn--lg">Lihat Kurikulum</a>
  </div>
  <div class="fade-up fade-up--4" style="display:flex;align-items:center;justify-content:center;gap:8px;margin-top:24px">
    <div style="display:flex;gap:2px"><span style="color:#fbbc04;font-size:16px">★</span><span style="color:#fbbc04;font-size:16px">★</span><span style="color:#fbbc04;font-size:16px">★</span><span style="color:#fbbc04;font-size:16px">★</span><span style="color:#fbbc04;font-size:16px">★</span></div>
    <span style="font-size:13px;color:var(--c-text-sec);font-weight:500">4.9/5 dari <strong style="color:var(--c-text-primary)">1.200+</strong> siswa aktif</span>
  </div>
  <!-- Guarantee badge -->
  <div class="fade-up fade-up--4" style="margin-top:20px;display:flex;justify-content:center;padding:0 16px;">
    <div style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;gap:10px;background:#fef9c3;border:1px solid #fde047;border-radius:12px;padding:12px 20px;font-size:13px;color:#a16207;font-weight:500;text-align:center;">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" style="flex-shrink:0;"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
      <div><strong style="margin:0 3px">GARANSI KEPUASAN</strong> — Materi tidak sesuai? Uang kembali 100%!</div>
    </div>
  </div>
</section>

<!-- TRUST BAR -->
<div class="trust-bar fade-up fade-up--4">
  <div class="trust-item">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    Akses Langsung
  </div>
  <div class="trust-item">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    Pembayaran QRIS Aman
  </div>
  <div class="trust-item">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    Dukungan Komunitas
  </div>
  <div class="trust-item">
    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
    Materi Berkualitas
  </div>
</div>

<!-- STATS BAR -->
<div class="stats-bar">
  <div class="stats-bar__inner">
    <div class="stat-item"><div class="stat-item__num"><span>5.000</span>+</div><div class="stat-item__label">Siswa Aktif</div></div>
    <div class="stat-item"><div class="stat-item__num"><span>50</span>+</div><div class="stat-item__label">Modul Video</div></div>
    <div class="stat-item"><div class="stat-item__num"><span>4.9</span>/5</div><div class="stat-item__label">Rating Kepuasan</div></div>
    <div class="stat-item"><div class="stat-item__num"><span>100</span>%</div><div class="stat-item__label">Garansi Belajar</div></div>
  </div>
</div>
<section class="features-section" id="features">
  <h2>Apa yang Ada di Dalam Paket</h2>
  <p class="subtitle">Satu paket edukasi lengkap, langsung bisa dipelajari dan dipraktekkan</p>
  <div class="features-grid">
    <?php
    // Filled Material Design SVG icons — Google product style

    // Gemini: 4-pointed star (signature Gemini shape)
    $svgGemini = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C10.84 7.47 7.47 10.84 2 12c5.47 1.16 8.84 4.53 10 10 1.16-5.47 4.53-8.84 10-10C16.53 10.84 13.16 7.47 12 2z"/></svg>';

    // Veo: filled video camera
    $svgVideo = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>';

    // Image Generation: filled landscape photo
    $svgImage = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>';

    // Deep Research: filled magnifying glass with sparkle
    $svgResearch = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/><path d="M12 10h-2v2H9v-2H7V9h2V7h1v2h2v1z" style="transform:translate(3px,3px);transform-origin:center"/></svg>';

    // 5 TB Storage: Google Drive triangle style
    $svgCloud = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/></svg>';

    // AI Credits: lightning bolt
    $svgCredits = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 2v11h3v9l7-12h-4l4-8z"/></svg>';

    // NotebookLM Plus: headphones on book
    $svgNotebook = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM9 4h2v5l-1-.75L9 9V4zm9 16H6V4h1v9l3-2.25L13 13V4h5v16z"/></svg>';

    // Gmail: M-shape envelope (Google Mail style)
    $svgMail = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>';

    // Producer.ai: music note
    $svgMusic = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/></svg>';

    // Google Antigravity / Code: code brackets
    $svgCode = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z"/></svg>';

    // Developer Program: terminal/settings
    $svgDev = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 3H4v10c0 2.21 1.79 4 4 4h6c2.21 0 4-1.79 4-4v-3h2c1.11 0 2-.89 2-2V5c0-1.11-.89-2-2-2zm0 5h-2V5h2v3zM4 19h16v2H4z"/></svg>';

    // Android Studio AI: Android robot head
    $svgAndroid = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6 18c0 .55.45 1 1 1h1v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h2v3.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5V19h1c.55 0 1-.45 1-1V8H6v10zm-2.5-2C2.67 16 2 15.33 2 14.5v-5C2 8.67 2.67 8 3.5 8S5 8.67 5 9.5v5c0 .83-.67 1.5-1.5 1.5zm17 0c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5zM12 1.5C9.33 1.5 7.02 2.89 5.72 5h12.56C16.98 2.89 14.67 1.5 12 1.5zM9.5 4c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zm5 0c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5z"/></svg>';

    // Icon SVGs untuk paket cuan
    $svgApk    = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.7 9.05 7.42c1.42.07 2.38.74 3.2.8 1.21-.24 2.38-.93 3.7-.84 1.58.13 2.77.77 3.53 1.96-3.24 1.94-2.7 6.07.58 7.19-.66 1.57-1.51 3.1-3.01 3.75zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/></svg>';
    $svgWeb    = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>';
    $svgVideo2 = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 10.5V7c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1v10c0 .55.45 1 1 1h12c.55 0 1-.45 1-1v-3.5l4 4v-11l-4 4z"/></svg>';
    $svgPdf    = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-8.5 7.5c0 .83-.67 1.5-1.5 1.5H9v2H7.5V7H10c.83 0 1.5.67 1.5 1.5v1zm5 2c0 .83-.67 1.5-1.5 1.5h-2.5V7H15c.83 0 1.5.67 1.5 1.5v3zm4-3H19v1h1.5V11H19v2h-1.5V7h3v1.5zM9 9.5h1v-1H9v1zM4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm10 5.5h1v-3h-1v3z"/></svg>';
    $svgBonus  = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1l2.753 8.472h8.986l-7.268 5.284 2.753 8.472L12 18.944l-7.224 4.284 2.753-8.472L.261 9.472h8.986L12 1z"/></svg>';
    $svgSupport= '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>';
    $svgUpdate = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 6v3l4-4-4-4v3c-4.42 0-8 3.58-8 8 0 1.57.46 3.03 1.24 4.26L6.7 14.8c-.45-.83-.7-1.79-.7-2.8 0-3.31 2.69-6 6-6zm6.76 1.74L17.3 9.2c.44.84.7 1.79.7 2.8 0 3.31-2.69 6-6 6v-3l-4 4 4 4v-3c4.42 0 8-3.58 8-8 0-1.57-.46-3.03-1.24-4.26z"/></svg>';
    $svgMoney  = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>';

    $features = [
      [$svgApk,    'Tools Produktivitas',  'Kumpulan aplikasi terpilih untuk menunjang efisiensi kerja digital Anda.','#fef9c3','#ca8a04'],
      [$svgWeb,    'Platform Freelance',   'Daftar platform online terpercaya untuk memulai karir freelance dari rumah.','#e6f4ea','#34a853'],
      [$svgVideo2, 'Video Tutorial Edukasi', 'Video step-by-step eksklusif yang membahas strategi digital secara detail.','#fce8e6','#ea4335'],
      [$svgPdf,    'PDF Panduan Lengkap',  'Modul panduan komprehensif 100+ halaman. Bisa dibaca kapan saja & di mana saja.','#e8f0fe','#1a73e8'],
      [$svgBonus,  'Bonus Template Khusus','Template dokumen dan materi tambahan yang terus diupdate secara berkala.','#fff8e1','#f29900'],
      [$svgSupport,'Grup Diskusi VIP',     'Akses grup komunitas member. Tempat diskusi, networking, dan berbagi wawasan.','#f3e8ff','#9333ea'],
      [$svgUpdate, 'Update Seumur Hidup',  'Akses materi yang diupdate mengikuti perkembangan industri digital terbaru.','#e6f4ea','#34a853'],
      [$svgMoney,  'Garansi Kepuasan',     'Jika materi tidak memberikan wawasan baru bagi Anda, kami berikan jaminan refund.','#fef9c3','#ca8a04'],
    ];
    foreach ($features as [$icon, $title, $desc, $bg, $color]):
    ?>
    <div class="feature-card">
      <div class="feature-card__icon" style="background:<?= $bg ?>;color:<?= $color ?>">
        <?= $icon ?>
      </div>
      <div class="feature-card__title"><?= $title ?></div>
      <div class="feature-card__desc"><?= $desc ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- SECURITY BADGES -->
<div class="security-section">
  <div class="security-section__inner">
    <div class="sec-badge"><div class="sec-badge__icon">🔒</div><div class="sec-badge__text"><div class="sec-badge__title">Pembayaran Aman</div><div class="sec-badge__sub">Diproses via QRIS resmi BI</div></div></div>
    <div class="sec-badge"><div class="sec-badge__icon">✅</div><div class="sec-badge__text"><div class="sec-badge__title">Materi 100% Original</div><div class="sec-badge__sub">Disusun oleh praktisi ahli</div></div></div>
    <div class="sec-badge"><div class="sec-badge__icon">💬</div><div class="sec-badge__text"><div class="sec-badge__title">Komunitas Aktif</div><div class="sec-badge__sub">Ruang diskusi responsif</div></div></div>
    <div class="sec-badge"><div class="sec-badge__icon">🛡️</div><div class="sec-badge__text"><div class="sec-badge__title">Garansi Kepuasan</div><div class="sec-badge__sub">Tidak puas? Refund penuh</div></div></div>
  </div>
</div>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
  <div class="pricing-card fade-up">
    <div class="pricing-card__badge">Terpopuler</div>
    <div class="pricing-card__header">
      <div style="margin-bottom:8px"><span class="urgency-badge">🎓 Tingkatkan skill digital Anda hari ini!</span></div>
      <div class="pricing-card__name">Bundel Ecourse Digital</div>
      <div class="pricing-card__tagline">Panduan terstruktur membangun karir freelance dan bisnis online</div>
      <div class="pricing-card__price">
        <div class="pricing-card__amount"><?= $priceStr ?></div>
        <div class="pricing-card__period">/12 bulan</div>
      </div>
      <div class="pricing-card__promo">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41s-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"/></svg>
        Paket 12 bulan — hemat vs langganan bulanan
      </div>
    </div>
    <div class="pricing-card__body">
      <div class="pricing-card__cta">
        <a href="checkout.php" class="btn btn--primary btn--full btn--lg" id="pricing-buy-btn">
          Beli Sekarang
        </a>
      </div>
      <ul class="feature-list">
        <li><strong>Tools Produktivitas</strong> — Kumpulan aplikasi penunjang kerja digital</li>
        <li><strong>Platform Freelance</strong> — Rekomendasi platform terpercaya</li>
        <li><strong>Video Tutorial Edukasi</strong> — Panduan visual step-by-step</li>
        <li><strong>PDF Panduan Lengkap</strong> — Modul 100+ halaman siap pelajari</li>
        <li><strong>Bonus Template Khusus</strong> — Aset digital tambahan untuk Anda</li>
        <li><strong>Grup Diskusi VIP</strong> — Komunitas networking member aktif</li>
        <li><strong>Update Seumur Hidup</strong> — Akses materi baru tanpa biaya tambahan</li>
        <li><strong>🛡️ Garansi Kepuasan</strong> — Tidak puas dengan materinya? Uang kembali 100%</li>
      </ul>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <h2>Cara Pendaftaran</h2>
  <p class="subtitle">Proses mudah, akses materi terbuka dalam hitungan menit</p>
  <div class="steps-grid">
    <?php
    $steps = [
      ['1','Pilih Paket','Selesaikan pembayaran via QRIS — sistem terenkripsi aman'],
      ['2','Akses Platform','Link akses dashboard akan dikirim instan ke email Anda'],
      ['3','Mulai Belajar','Pelajari video & baca PDF panduan sesuai kurikulum'],
      ['4','Terapkan Skill','Praktekkan wawasan baru Anda di dunia profesional'],
    ];
    foreach ($steps as [$n, $t, $d]):
    ?>
    <div class="step-item">
      <div class="step-circle"><?= $n ?></div>
      <div class="step-item__title"><?= $t ?></div>
      <div class="step-item__desc"><?= $d ?></div>
    </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- TESTIMONIALS -->
<section style="background:var(--c-bg-alt);border-top:1px solid var(--c-border);border-bottom:1px solid var(--c-border);padding:72px 24px">
  <div style="max-width:1000px;margin:0 auto">
    <h2 style="text-align:center;margin-bottom:8px">Apa Kata Member Kami</h2>
    <p style="text-align:center;color:var(--c-text-sec);font-size:16px;margin-bottom:48px">Bergabunglah dengan komunitas pembelajar aktif kami</p>
    <div class="testi-grid">
      <div class="testi-card">
        <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
        <div class="testi-text">“Materi sangat terstruktur dan mudah diikuti. Sebagai pemula, panduan ini sangat membantu saya memahami cara kerja platform freelance.”</div>
        <div class="testi-author"><div class="testi-avatar">A</div><div><div class="testi-name">Andi Saputra.</div><div class="testi-loc">Jakarta</div></div></div>
      </div>
      <div class="testi-card">
        <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
        <div class="testi-text">“Video tutorialnya jelas dan kualitas audionya bagus. Bonus template-nya juga sangat berguna untuk memulai project pertama saya.”</div>
        <div class="testi-author"><div class="testi-avatar" style="background:#e6f4ea;color:#34a853">S</div><div><div class="testi-name">Siti Rahayu.</div><div class="testi-loc">Surabaya</div></div></div>
      </div>
      <div class="testi-card">
        <div class="testi-stars"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
        <div class="testi-text">“Grup diskusinya sangat aktif dan suportif. Banyak insight baru yang saya dapat dari member lain. Sangat worth it!”</div>
        <div class="testi-author"><div class="testi-avatar" style="background:#fff8e1;color:#f29900">B</div><div><div class="testi-name">Budi Wicaksono.</div><div class="testi-loc">Bandung</div></div></div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section style="padding:0 24px 80px;max-width:720px;margin:0 auto">
  <h2 style="text-align:center;margin-bottom:32px">FAQ</h2>
  <div id="faq-list"></div>
  <?php
  $faqs = [
    ['Apakah materi ini cocok untuk pemula?', 'Ya! Semua materi disusun dari tingkat dasar. Sangat mudah dipahami meski Anda belum memiliki pengalaman di bidang digital sebelumnya.'],
    ['Bagaimana cara mengakses materinya?', 'Setelah pembayaran dikonfirmasi, link akses menuju dashboard pembelajaran dan grup diskusi langsung dikirim ke email Anda.'],
    ['Metode pembayaran apa yang tersedia?', 'Saat ini kami menerima pembayaran via QRIS yang didukung oleh berbagai e-wallet (GoPay, OVO, Dana, ShopeePay) dan m-Banking.'],
    ['Bagaimana cara kerja garansinya?', 'Kami memberikan <strong>Garansi Kepuasan</strong>. Jika Anda merasa materi tidak bermanfaat setelah mempelajarinya, silakan hubungi admin kami untuk proses refund 100%.'],
    ['Apakah saya harus membayar lagi untuk update materi?', 'Tidak. Anda hanya perlu membayar satu kali (sekali bayar) dan akan mendapatkan update materi terbaru secara gratis seumur hidup.'],
  ];
  foreach ($faqs as [$q, $a]):
  ?>
  <details style="border:1px solid var(--c-border);border-radius:var(--radius-md);margin-bottom:8px;overflow:hidden;cursor:pointer">
    <summary style="padding:16px 20px;font-size:14px;font-weight:500;display:flex;justify-content:space-between;align-items:center;user-select:none">
      <?= $q ?>
      <span style="font-size:18px;color:var(--c-text-sec);flex-shrink:0">+</span>
    </summary>
    <div style="padding:0 20px 16px;font-size:14px;color:var(--c-text-sec)"><?= $a ?></div>
  </details>
  <?php endforeach; ?>
</section>

<!-- FOOTER -->
<footer class="footer">
  <p>© <?= date('Y') ?> Ecourse Bisnis Digital. Hak cipta dilindungi.</p>
  <p style="margin-top:6px"><a href="#">Syarat & Ketentuan</a> · <a href="#">Kebijakan Privasi</a></p>
</footer>

<script>
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) { e.preventDefault(); target.scrollIntoView({behavior:'smooth', block:'start'}); }
  });
});

// Intersection Observer for fade-up
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); } });
}, { threshold: .1 });
document.querySelectorAll('.feature-card,.fade-up').forEach(el => observer.observe(el));

// details toggle icon
document.querySelectorAll('details').forEach(d => {
  d.addEventListener('toggle', () => {
    d.querySelector('span').textContent = d.open ? '−' : '+';
  });
});
</script>
</body>
</html>
