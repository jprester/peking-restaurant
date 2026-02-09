
                <div class="page-title">
                    <h1><img src="<?= BASE_URL ?>/img/title3.png"  alt="Meni"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="page-down">
        <div class="container menu-layout">

            <?php include APP_ROOT . '/Views/partials/menuSidebar.php'; ?>

            <!-- Combo Menus -->
            <div class="dish-menu">
                <?php foreach ($menus as $menu): ?>
                    <div class="dish-menu-top"></div>
                    <div class="dish-menu-content">
                        <table class="menu-table">
                            <tr>
                                <td colspan="3" class="table-title">
                                    <?= htmlspecialchars($menu['name']) ?>
                                    <span class="combo-price"><?= number_format((float) $menu['price'], 2, ',', '') ?> &euro;</span>
                                </td>
                            </tr>
                            <?php foreach ($menu['items'] as $item): ?>
                                <tr>
                                    <td class="td-number"><?= (int) $item['itemNumber'] ?></td>
                                    <td class="td-dish">
                                        <strong><?= htmlspecialchars($item['nameCro']) ?></strong><br>
                                        <span class="dish-en"><?= htmlspecialchars($item['nameEn']) ?></span>
                                    </td>
                                    <td class="td-price"></td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="table-bottom">&nbsp;</td>
                            </tr>
                        </table>
                    </div>
                    <div class="dish-menu-bottom"></div>
                    <br>
                <?php endforeach; ?>

                <?php if (empty($menus)): ?>
                    <p class="text-body" style="text-align: center; padding: 20px;">
                        Nema dostupnih menija za <?= (int) $personCount ?> osobe.
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
