
                <div id="title">
                    <h1><img src="<?= BASE_URL ?>/img/title3.png" width="96" height="60" alt="Meni"></h1>
                </div>
            </div>
        </div>
    </div>

    <div id="page_down">
        <div class="container menu-layout">

            <!-- Category Sidebar -->
            <div class="meni-list">
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li>
                            <a href="<?= BASE_URL ?>/menu/<?= (int) $cat['id'] ?>">
                                <?= htmlspecialchars($cat['nameCro']) ?>
                                <span class="en-name"><?= htmlspecialchars($cat['nameEn']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php foreach ($comboGroups as $pc => $combos): ?>
                        <li class="combo-link">
                            <a href="<?= BASE_URL ?>/menu/combo/<?= (int) $pc ?>">
                                MENU ZA <?= (int) $pc ?> OSOBE
                                <span class="en-name">Menu for <?= (int) $pc ?> people</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Mobile Menu Navigation -->
            <div class="mobile-meninav menu-mobile-nav">
                <a href="#" id="menuCategoryToggle">ODABERI KATEGORIJU</a>
            </div>
            <div class="mobile-menilist menu-mobile-list" id="menuCategoryList">
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li><a href="<?= BASE_URL ?>/menu/<?= (int) $cat['id'] ?>"><?= htmlspecialchars($cat['nameCro']) ?></a></li>
                    <?php endforeach; ?>
                    <?php foreach ($comboGroups as $pc => $combos): ?>
                        <li><a href="<?= BASE_URL ?>/menu/combo/<?= (int) $pc ?>">Menu za <?= (int) $pc ?> osobe</a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Main Image -->
            <div class="jelovnik_mainpic">
                <img src="<?= BASE_URL ?>/img/jelovnik_pic2.png" alt="Jelovnik">
            </div>

        </div>
    </div>
