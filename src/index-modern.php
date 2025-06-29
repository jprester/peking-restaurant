<?php
// Page configuration
$currentPage = 'home';
$pageTitle = 'Kineski restoran Peking - Autentična kineska kuhinja u Zagrebu';
$pageDescription = 'Dobrodošli u Kineski restoran Peking - jedan od prvih zagrebačkih azijskih restorana koji nudi vrhunska jela iz bogate kineske gastronomske tradicije.';
$pageKeywords = 'kineski restoran, Peking, Zagreb, kineska hrana, autentična kineska kuhinja, azijska hrana, restoran Zagreb';
$bodyClass = 'home-page';
$useTextLogo = false; // Set to true to use text instead of image logo

// Include modern header
include 'inc/modern-header.php';
?>

<!-- Hero Section with Image Slider -->
<section class="hero-section" aria-label="Dobrodošlica">
    <div class="hero-slider" data-slider="true" data-autoplay="true" data-delay="5000" data-effect="slide">
        <img src="img/slide2.jpg" 
             alt="Unutrašnjost kineskog restorana Peking" 
             data-caption="Dobrodošli u autentični kineski restoran"
             loading="eager"
             width="1200" 
             height="600">
        <img src="img/slide3.jpg" 
             alt="Tradicionalna kineska jela" 
             data-caption="Otkrijte bogatu tradiciju kineske gastronomije"
             loading="lazy"
             width="1200" 
             height="600">
        <img src="img/slide1.jpg" 
             alt="Elegantan ambijent restorana" 
             data-caption="Uživajte u elegantnom ambijentu"
             loading="lazy"
             width="1200" 
             height="600">
    </div>
    
    <!-- Hero Content Overlay -->
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content text-center animate-on-scroll">
                <h1 class="hero-title font-primary text-5xl font-bold mb-6 text-white">
                    Dobrodošli u Kineski restoran Peking
                </h1>
                <p class="hero-subtitle text-xl mb-8 text-white opacity-90">
                    Otkrijte autentičnu kinesku kuhinju u srcu Zagreba
                </p>
                <div class="hero-actions flex gap-4 justify-center">
                    <a href="meni.php" class="btn btn--primary btn--lg">
                        Pogledaj meni
                    </a>
                    <a href="kontakt.php" class="btn btn--outline btn--lg">
                        Rezerviraj stol
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Welcome Section -->
<section class="welcome-section py-16" id="welcome">
    <div class="container">
        <div class="grid grid--cols-1 lg:grid--cols-2 gap-12 items-center">
            <div class="welcome-content animate-on-scroll">
                <h2 class="section-title font-primary text-3xl mb-6 color-primary">
                    Tradicija i kvaliteta od 2014. godine
                </h2>
                <div class="section-content text-lg leading-relaxed">
                    <p class="mb-6">
                        Kineski restoran <strong>Peking</strong> je jedan od prvih zagrebačkih azijskih restorana 
                        koji nudi vrhunska jela iz bogate kineske gastronomske tradicije. Naša misija je 
                        pružiti vam autentično iskustvo kineske kuhinje kroz pažljivo pripremljena jela 
                        koristeći tradicionalne recepte i najkvalitetnije sastojke.
                    </p>
                    <p class="mb-6">
                        U našem restoranu možete uživati u širokom spektru specijaliteta - od klasičnih 
                        jela poput Peking patke do regionalnih delicija koje će vas odvesti na kulinarno 
                        putovanje kroz Kinu.
                    </p>
                    <div class="welcome-features grid grid--cols-1 sm:grid--cols-2 gap-4 mt-8">
                        <div class="feature-item flex items-center gap-3">
                            <div class="feature-icon w-6 h-6 color-primary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium">Autentični recepti</span>
                        </div>
                        <div class="feature-item flex items-center gap-3">
                            <div class="feature-icon w-6 h-6 color-primary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium">Svježi sastojci</span>
                        </div>
                        <div class="feature-item flex items-center gap-3">
                            <div class="feature-icon w-6 h-6 color-primary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium">Iskusni kuhari</span>
                        </div>
                        <div class="feature-item flex items-center gap-3">
                            <div class="feature-icon w-6 h-6 color-primary">
                                <svg viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="font-medium">Elegantan ambijent</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="welcome-image animate-on-scroll">
                <figure class="image-container">
                    <img src="img/restaurant-interior.jpg" 
                         alt="Unutrašnjost restorana Peking s elegantnim stolovima" 
                         class="w-full h-auto rounded-lg shadow-lg"
                         loading="lazy"
                         width="600" 
                         height="400">
                    <figcaption class="sr-only">Elegantan unutrašnji ambijent restorana</figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>

<!-- Featured Dishes Section -->
<section class="featured-dishes-section py-16 bg-light" id="featured-dishes">
    <div class="container">
        <div class="section-header text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-primary text-3xl mb-4 color-primary">
                Naši specijaliteti
            </h2>
            <p class="section-subtitle text-lg color-text-light max-w-2xl mx-auto">
                Otkrijte najpopularnija jela našeg restorana, pripremljena po tradicionalnim receptima
            </p>
        </div>
        
        <div class="dishes-grid grid grid--cols-1 md:grid--cols-2 lg:grid--cols-3 gap-8">
            
            <!-- Featured Dish 1 -->
            <article class="dish-card card animate-on-scroll">
                <div class="dish-image">
                    <img src="img/dish-peking-duck.jpg" 
                         alt="Peking patka s tradicionalnim preljevima" 
                         class="card__image"
                         loading="lazy"
                         width="300" 
                         height="200">
                </div>
                <div class="card__body">
                    <h3 class="dish-title card__title">Peking patka</h3>
                    <p class="dish-description card__description">
                        Naš najpoznatiji specijalitet - sočna patka pripremljena po tradicionalnom receptu 
                        s hrskavom kožicom i aromatičnim preljevima.
                    </p>
                    <div class="dish-price color-accent font-bold text-lg">185,00 kn</div>
                </div>
            </article>
            
            <!-- Featured Dish 2 -->
            <article class="dish-card card animate-on-scroll">
                <div class="dish-image">
                    <img src="img/dish-kung-pao.jpg" 
                         alt="Kung Pao piletina s povrćem i kikirikijem" 
                         class="card__image"
                         loading="lazy"
                         width="300" 
                         height="200">
                </div>
                <div class="card__body">
                    <h3 class="dish-title card__title">Kung Pao piletina</h3>
                    <p class="dish-description card__description">
                        Pikantna piletina s povrćem, kikirikijem i tradicionalnim kineskim začinima 
                        koja će razbuditi vaše okusne pupoljke.
                    </p>
                    <div class="dish-price color-accent font-bold text-lg">95,00 kn</div>
                </div>
            </article>
            
            <!-- Featured Dish 3 -->
            <article class="dish-card card animate-on-scroll">
                <div class="dish-image">
                    <img src="img/dish-sweet-sour.jpg" 
                         alt="Slatko-kisela svinjetina s ananasima" 
                         class="card__image"
                         loading="lazy"
                         width="300" 
                         height="200">
                </div>
                <div class="card__body">
                    <h3 class="dish-title card__title">Slatko-kisela svinjetina</h3>
                    <p class="dish-description card__description">
                        Savršena kombinacija slatkih i kiselih okusa s mekanom svinjetinom 
                        i svježim povrćem.
                    </p>
                    <div class="dish-price color-accent font-bold text-lg">89,00 kn</div>
                </div>
            </article>
            
        </div>
        
        <div class="section-footer text-center mt-12 animate-on-scroll">
            <a href="meni.php" class="btn btn--primary btn--lg">
                Pogledaj kompletan meni
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-choose-section py-16" id="why-choose">
    <div class="container">
        <div class="section-header text-center mb-12 animate-on-scroll">
            <h2 class="section-title font-primary text-3xl mb-4 color-primary">
                Zašto odabrati Peking restoran?
            </h2>
        </div>
        
        <div class="features-grid grid grid--cols-1 md:grid--cols-2 lg:grid--cols-4 gap-8">
            
            <div class="feature-card text-center animate-on-scroll">
                <div class="feature-icon-large w-16 h-16 mx-auto mb-4 color-primary">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="feature-title font-primary text-xl mb-3">Visoka kvaliteta</h3>
                <p class="feature-description color-text-light">
                    Koristimo samo najkvalitetnije sastojke i tradicionalne metode pripreme
                </p>
            </div>
            
            <div class="feature-card text-center animate-on-scroll">
                <div class="feature-icon-large w-16 h-16 mx-auto mb-4 color-primary">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <h3 class="feature-title font-primary text-xl mb-3">Autentičnost</h3>
                <p class="feature-description color-text-light">
                    Originalni kineski recepti preneseni iz generacije u generaciju
                </p>
            </div>
            
            <div class="feature-card text-center animate-on-scroll">
                <div class="feature-icon-large w-16 h-16 mx-auto mb-4 color-primary">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                    </svg>
                </div>
                <h3 class="feature-title font-primary text-xl mb-3">Izvrsna usluga</h3>
                <p class="feature-description color-text-light">
                    Naše osoblje će učiniti sve da vaš posjet bude nezaboravan
                </p>
            </div>
            
            <div class="feature-card text-center animate-on-scroll">
                <div class="feature-icon-large w-16 h-16 mx-auto mb-4 color-primary">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                </div>
                <h3 class="feature-title font-primary text-xl mb-3">Dugogodišnje iskustvo</h3>
                <p class="feature-description color-text-light">
                    Više od desetljeća iskustva u pripremi autentične kineske hrane
                </p>
            </div>
            
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="cta-section py-16 bg-primary text-white text-center">
    <div class="container">
        <div class="cta-content animate-on-scroll">
            <h2 class="cta-title font-primary text-3xl mb-6">
                Rezervirajte svoj stol danas
            </h2>
            <p class="cta-subtitle text-xl mb-8 opacity-90">
                Doživite autentične okuse Kine u srcu Zagreba
            </p>
            <div class="cta-actions flex gap-4 justify-center">
                <a href="kontakt.php" class="btn btn--secondary btn--lg">
                    Rezerviraj stol
                </a>
                <a href="tel:+38514xxxxxx" class="btn btn--outline btn--lg text-white border-white hover:bg-white hover:text-primary">
                    Pozovi nas
                </a>
            </div>
        </div>
    </div>
</section>

<?php
// Include modern footer
include 'inc/modern-footer.php';
?>