<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $pageTitle ?? 'Kineski restoran Peking' ?></title>
    <meta name="description" content="Kineski restoran Peking - Zagreb. Kineska hrana, dostava.">
    <meta name="keywords" content="Kineski restoran, Peking, Kineska hrana, restaurant, chinese, Zagreb">
    <link rel="icon" href="<?= BASE_URL ?>/img/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Rufina:wght@400;700&family=Marcellus+SC&family=Linden+Hill&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>
<body>

<div id="main">

    <!-- Mobile Header -->
    <div class="mob-head">
        <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/img/logo.png" width="134" height="130" alt="Peking logo"></a>
    </div>

    <!-- Header -->
    <div id="head_bg">
        <div class="container">
            <div id="header">
                <div id="logo">
                    <a href="<?= BASE_URL ?>/"><img src="<?= BASE_URL ?>/img/logo.png" width="134" height="130" alt="Peking logo"></a>
                </div>

                <nav id="navigation">
                    <ul>
                        <li><a href="<?= BASE_URL ?>/" class="<?= ($activePage ?? '') === 'home' ? 'pressed' : '' ?>">Početna</a></li>
                        <li><a href="<?= BASE_URL ?>/about" class="<?= ($activePage ?? '') === 'about' ? 'pressed' : '' ?>">O nama</a></li>
                        <li><a href="<?= BASE_URL ?>/menu" class="<?= ($activePage ?? '') === 'menu' ? 'pressed' : '' ?>">Meni</a></li>
                        <li><a href="<?= BASE_URL ?>/contact" class="<?= ($activePage ?? '') === 'contact' ? 'pressed' : '' ?>">Kontakt</a></li>
                    </ul>
                </nav>

                <div class="mobile-meninav">
                    <a href="#" id="mobileMenuToggle">NAVIGACIJA</a>
                </div>
                <div class="mobile-menilist" id="mobileMenu">
                    <ul>
                        <li><a href="<?= BASE_URL ?>/">Početna</a></li>
                        <li><a href="<?= BASE_URL ?>/about">O nama</a></li>
                        <li><a href="<?= BASE_URL ?>/menu">Meni</a></li>
                        <li><a href="<?= BASE_URL ?>/contact">Kontakt</a></li>
                    </ul>
                </div>
