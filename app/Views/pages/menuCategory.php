
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
                        <li class="<?= $cat['id'] == $category['id'] ? 'active' : '' ?>">
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

            <!-- Dish Table -->
            <div id="jelovnik">
                <div id="jelovnik_top"></div>
                <div id="jelovnik_content">
                    <table class="meni-table">
                        <tr>
                            <td colspan="3" class="table_naslov">
                                <?= htmlspecialchars($category['nameCro']) ?>
                                / <?= htmlspecialchars($category['nameEn']) ?>
                            </td>
                        </tr>
                        <?php foreach ($dishes as $dish): ?>
                            <tr>
                                <td class="td-broj"><?= htmlspecialchars($dish['dishNumber']) ?></td>
                                <td class="td-jelo">
                                    <strong><?= htmlspecialchars($dish['nameCro']) ?></strong><br>
                                    <span class="dish-en"><?= htmlspecialchars($dish['nameEn']) ?></span>
                                </td>
                                <td class="td-cijena"><?= number_format((float) $dish['price'], 2, ',', '') ?> &euro;</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="t_bottom">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <div id="jelovnik_bottom"></div>
            </div>

        </div>
    </div>
