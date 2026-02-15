<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? 'Kineski restoran Peking' ?></title>
    <meta name="description" content="Kineski restoran Peking - Zagreb. Kineska hrana, dostava.">
    <meta name="keywords" content="Kineski restoran, Peking, Kineska hrana, restaurant, chinese, Zagreb">
    <link rel="icon" href="<?= BASE_URL ?>/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>
<body>

<div class="main">

    <!-- Mobile Header -->
    <div class="mob-head">
        <a href="<?= BASE_URL ?>/" class="mob-logo"><img src="<?= BASE_URL ?>/img/logo.png" width="80" height="78" alt="Peking logo"></a>
        <button class="mob-toggle" id="mobileMenuToggle" aria-label="Otvori navigaciju">
            <span class="mob-toggle-bar"></span>
            <span class="mob-toggle-bar"></span>
            <span class="mob-toggle-bar"></span>
        </button>
    </div>
    <nav class="mob-nav" id="mobileMenu">
        <ul>
            <li><a href="<?= BASE_URL ?>/" class="<?= ($activePage ?? '') === 'home' ? 'active' : '' ?>">Početna</a></li>
            <li><a href="<?= BASE_URL ?>/about" class="<?= ($activePage ?? '') === 'about' ? 'active' : '' ?>">O nama</a></li>
            <li><a href="<?= BASE_URL ?>/menu" class="<?= ($activePage ?? '') === 'menu' ? 'active' : '' ?>">Meni</a></li>
            <li><a href="<?= BASE_URL ?>/contact" class="<?= ($activePage ?? '') === 'contact' ? 'active' : '' ?>">Kontakt</a></li>
        </ul>
    </nav>

    <!-- Header -->
    <div class="head-bg">
        <div class="container">
            <div class="site-header">
                <div class="site-logo">
                    <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/img/logo.png" width="134" height="130" alt="Peking logo"></a>
                </div>

                <nav class="site-nav">
                    <ul>
                        <li><a href="<?= BASE_URL ?>/" class="<?= ($activePage ?? '') === 'home' ? 'pressed' : '' ?>">Početna</a></li>
                        <li><a href="<?= BASE_URL ?>/about" class="<?= ($activePage ?? '') === 'about' ? 'pressed' : '' ?>">O nama</a></li>
                        <li><a href="<?= BASE_URL ?>/menu" class="<?= ($activePage ?? '') === 'menu' ? 'pressed' : '' ?>">Meni</a></li>
                        <li><a href="<?= BASE_URL ?>/contact" class="<?= ($activePage ?? '') === 'contact' ? 'pressed' : '' ?>">Kontakt</a></li>
                    </ul>
                </nav>
