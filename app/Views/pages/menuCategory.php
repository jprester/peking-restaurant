
                <div class="page-title">
                    <h1><img src="<?= BASE_URL ?>/img/title3.png" alt="Meni"></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="page-down">
        <div class="container menu-layout">

            <?php include APP_ROOT . '/Views/partials/menuSidebar.php'; ?>

            <!-- Dish Table -->
            <div class="jelovnik">
                <div class="jelovnik-top"></div>
                <div class="jelovnik-content">
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
                <div class="jelovnik-bottom"></div>
            </div>

        </div>
    </div>
