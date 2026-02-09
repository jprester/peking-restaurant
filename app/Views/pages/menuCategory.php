
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
            <div class="dish-menu">
                <div class="dish-menu-top"></div>
                <div class="dish-menu-content">
                    <table class="menu-table">
                        <tr>
                            <td colspan="3" class="table-title">
                                <?= htmlspecialchars($category['nameCro']) ?>
                                / <?= htmlspecialchars($category['nameEn']) ?>
                            </td>
                        </tr>
                        <?php foreach ($dishes as $dish): ?>
                            <tr>
                                <td class="td-number"><?= htmlspecialchars($dish['dishNumber']) ?></td>
                                <td class="td-dish">
                                    <strong><?= htmlspecialchars($dish['nameCro']) ?></strong><br>
                                    <span class="dish-en"><?= htmlspecialchars($dish['nameEn']) ?></span>
                                </td>
                                <td class="td-price"><?= number_format((float) $dish['price'], 2, ',', '') ?> &euro;</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="table-bottom">&nbsp;</td>
                        </tr>
                    </table>
                </div>
                <div class="dish-menu-bottom"></div>
            </div>

        </div>
    </div>
