
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
                        <li class="combo-link <?= $pc == $personCount ? 'active' : '' ?>">
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

            <!-- Combo Menus -->
            <div id="jelovnik">
                <?php foreach ($menus as $menu): ?>
                    <div id="jelovnik_top"></div>
                    <div id="jelovnik_content">
                        <table class="meni-table">
                            <tr>
                                <td colspan="3" class="table_naslov">
                                    <?= htmlspecialchars($menu['name']) ?>
                                    <span class="combo-price"><?= number_format((float) $menu['price'], 2, ',', '') ?> &euro;</span>
                                </td>
                            </tr>
                            <?php foreach ($menu['items'] as $item): ?>
                                <tr>
                                    <td class="td-broj"><?= (int) $item['itemNumber'] ?></td>
                                    <td class="td-jelo">
                                        <strong><?= htmlspecialchars($item['nameCro']) ?></strong><br>
                                        <span class="dish-en"><?= htmlspecialchars($item['nameEn']) ?></span>
                                    </td>
                                    <td class="td-cijena"></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="t_bottom">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                    <div id="jelovnik_bottom"></div>
                    <br>
                <?php endforeach; ?>

                <?php if (empty($menus)): ?>
                    <p class="txt3" style="text-align: center; padding: 20px;">
                        Nema dostupnih menija za <?= (int) $personCount ?> osobe.
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
