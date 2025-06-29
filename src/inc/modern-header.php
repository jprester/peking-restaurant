<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $pageDescription ?? 'Kineski restoran Peking - autentična kineska kuhinja u srcu Zagreba. Otkrijte bogatu tradiciju kineske gastronomije u našem restoranu.' ?>">
    <meta name="keywords" content="<?= $pageKeywords ?? 'kineski restoran, Peking, kineska hrana, Zagreb, autentična kineska kuhinja, azijska hrana, restoran Zagreb' ?>">
    <meta name="author" content="Janko Prester">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $pageTitle ?? 'Kineski restoran Peking' ?>">
    <meta property="og:description" content="<?= $pageDescription ?? 'Autentična kineska kuhinja u srcu Zagreba' ?>">
    <meta property="og:image" content="<?= $baseUrl ?? '' ?>/img/og-image.jpg">
    <meta property="og:url" content="<?= $canonicalUrl ?? '' ?>">
    <meta property="og:site_name" content="Kineski restoran Peking">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $pageTitle ?? 'Kineski restoran Peking' ?>">
    <meta name="twitter:description" content="<?= $pageDescription ?? 'Autentična kineska kuhinja u srcu Zagreba' ?>">
    <meta name="twitter:image" content="<?= $baseUrl ?? '' ?>/img/og-image.jpg">
    
    <!-- Canonical URL -->
    <?php if (isset($canonicalUrl)): ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
    <?php endif; ?>
    
    <title><?= htmlspecialchars($pageTitle ?? 'Kineski restoran Peking') ?></title>
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Critical CSS (inline for performance) -->
    <style>
        /* Critical above-the-fold styles */
        :root {
            --color-primary: #A5745F;
            --color-secondary: #572C2C;
            --color-background: #fefefe;
            --color-text: #333;
            --font-primary: 'Rufina', Georgia, serif;
            --font-secondary: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        
        body {
            margin: 0;
            font-family: var(--font-secondary);
            line-height: 1.6;
            color: var(--color-text);
            background-color: var(--color-background);
        }
        
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--color-text);
            color: var(--color-background);
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1000;
            transition: top 0.3s;
        }
        
        .skip-link:focus {
            top: 6px;
        }
        
        .site-header {
            background: var(--color-background);
            border-bottom: 1px solid #e0e0e0;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .site-title {
            margin: 0;
            font-family: var(--font-primary);
            color: var(--color-primary);
        }
    </style>
    
    <!-- Modern CSS (non-blocking load) -->
    <link rel="preload" href="css/modern.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="css/modern.css"></noscript>
    
    <!-- Fallback CSS for legacy browsers -->
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="css/screen.css">
    <![endif]-->
    
    <!-- Google Fonts (optimized loading) -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Rufina:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rufina:wght@400;700&family=Inter:wght@300;400;500;600;700&display=swap"></noscript>
    
    <!-- Favicon and app icons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    
    <!-- JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Restaurant",
        "name": "Kineski restoran Peking",
        "image": "<?= $baseUrl ?? '' ?>/img/restaurant-photo.jpg",
        "description": "Autentična kineska kuhinja u srcu Zagreba. Otkrijte bogatu tradiciju kineske gastronomije.",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Vaša adresa",
            "addressLocality": "Zagreb",
            "addressCountry": "HR"
        },
        "telephone": "+385 1 xxx xxxx",
        "servesCuisine": "Chinese",
        "priceRange": "$$",
        "openingHours": "Mo-Su 11:00-23:00",
        "url": "<?= $baseUrl ?? '' ?>"
    }
    </script>
    
    <!-- Legacy browser support -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="<?= $bodyClass ?? '' ?>">
    
    <!-- Skip to main content link for accessibility -->
    <a href="#main-content" class="skip-link">Preskoči na glavni sadržaj</a>
    
    <!-- Site Header -->
    <header class="site-header" role="banner">
        <div class="container">
            <div class="header-content flex flex--justify-between flex--items-center p-4">
                
                <!-- Logo / Site Title -->
                <div class="site-branding">
                    <h1 class="site-title">
                        <a href="<?= $baseUrl ?? '/' ?>" class="site-title__link">
                            <?php if (isset($useTextLogo) && $useTextLogo): ?>
                                Kineski restoran Peking
                            <?php else: ?>
                                <img src="img/logo.png" alt="Kineski restoran Peking" width="129" height="56" class="site-logo">
                            <?php endif; ?>
                        </a>
                    </h1>
                    <p class="site-tagline sr-only">Autentična kineska kuhinja u srcu Zagreba</p>
                </div>
                
                <!-- Main Navigation -->
                <nav class="main-nav" role="navigation" aria-label="Glavna navigacija">
                    <ul class="nav__list hidden-mobile" role="menubar">
                        <li class="nav__item" role="none">
                            <a href="<?= $baseUrl ?? '/' ?>" 
                               class="nav__link <?= ($currentPage ?? '') === 'home' ? 'nav__link--active' : '' ?>" 
                               role="menuitem"
                               <?= ($currentPage ?? '') === 'home' ? 'aria-current="page"' : '' ?>>
                                Početna
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="meni.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'menu' ? 'nav__link--active' : '' ?>" 
                               role="menuitem"
                               <?= ($currentPage ?? '') === 'menu' ? 'aria-current="page"' : '' ?>>
                                Meni
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="onama.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'about' ? 'nav__link--active' : '' ?>" 
                               role="menuitem"
                               <?= ($currentPage ?? '') === 'about' ? 'aria-current="page"' : '' ?>>
                                O nama
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="kontakt.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'contact' ? 'nav__link--active' : '' ?>" 
                               role="menuitem"
                               <?= ($currentPage ?? '') === 'contact' ? 'aria-current="page"' : '' ?>>
                                Kontakt
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle hidden-desktop" 
                            type="button" 
                            aria-controls="mobile-navigation" 
                            aria-expanded="false"
                            aria-label="Otvori/zatvori izbornik">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </nav>
                
                <!-- Mobile Navigation -->
                <div id="mobile-navigation" class="mobile-nav nav--mobile hidden-desktop" aria-hidden="true">
                    <ul class="nav__list" role="menubar">
                        <li class="nav__item" role="none">
                            <a href="<?= $baseUrl ?? '/' ?>" 
                               class="nav__link <?= ($currentPage ?? '') === 'home' ? 'nav__link--active' : '' ?>" 
                               role="menuitem">
                                Početna
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="meni.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'menu' ? 'nav__link--active' : '' ?>" 
                               role="menuitem">
                                Meni
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="onama.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'about' ? 'nav__link--active' : '' ?>" 
                               role="menuitem">
                                O nama
                            </a>
                        </li>
                        <li class="nav__item" role="none">
                            <a href="kontakt.php" 
                               class="nav__link <?= ($currentPage ?? '') === 'contact' ? 'nav__link--active' : '' ?>" 
                               role="menuitem">
                                Kontakt
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content Area -->
    <main id="main-content" class="site-main" role="main">
        
        <!-- Page Title Section (if not homepage) -->
        <?php if (isset($pageTitle) && ($currentPage ?? '') !== 'home'): ?>
        <section class="page-header">
            <div class="container">
                <div class="page-header__content text-center p-8">
                    <h1 class="page-title font-primary text-4xl color-primary"><?= htmlspecialchars($pageTitle) ?></h1>
                    <?php if (isset($pageSubtitle)): ?>
                    <p class="page-subtitle text-lg color-text-light mt-4"><?= htmlspecialchars($pageSubtitle) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>