            <!-- Category Sidebar -->
            <div class="meni-list">
                <ul>
                    <?php foreach ($categories as $cat): ?>
                        <li class="<?= isset($category) && $cat['id'] == $category['id'] ? 'active' : '' ?>">
                            <a href="<?= BASE_URL ?>/menu/<?= (int) $cat['id'] ?>">
                                <?= htmlspecialchars($cat['nameCro']) ?>
                                <span class="en-name"><?= htmlspecialchars($cat['nameEn']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                    <?php foreach ($comboGroups as $pc => $combos): ?>
                        <li class="combo-link <?= isset($personCount) && $pc == $personCount ? 'active' : '' ?>">
                            <a href="<?= BASE_URL ?>/menu/combo/<?= (int) $pc ?>">
                                MENU ZA <?= (int) $pc ?> OSOBE
                                <span class="en-name">Menu for <?= (int) $pc ?> people</span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Mobile Category Navigation -->
            <div class="mob-cat-wrap menu-mobile-nav">
                <div class="mob-cat-toggle">
                    <?php
                        $toggleLabel = 'Odaberi kategoriju';
                        if (isset($category)) {
                            $toggleLabel = htmlspecialchars($category['nameCro']);
                        } elseif (isset($personCount)) {
                            $toggleLabel = 'Menu za ' . (int) $personCount . ' osobe';
                        }
                    ?>
                    <button id="menuCategoryToggle">
                        <span><?= $toggleLabel ?></span>
                        <span class="mob-cat-arrow">&#9662;</span>
                    </button>
                </div>
                <nav class="mob-cat-list" id="menuCategoryList">
                    <ul>
                        <?php foreach ($categories as $cat): ?>
                            <li><a href="<?= BASE_URL ?>/menu/<?= (int) $cat['id'] ?>" class="<?= isset($category) && $cat['id'] == $category['id'] ? 'active' : '' ?>"><?= htmlspecialchars($cat['nameCro']) ?></a></li>
                        <?php endforeach; ?>
                        <?php foreach ($comboGroups as $pc => $combos): ?>
                            <li><a href="<?= BASE_URL ?>/menu/combo/<?= (int) $pc ?>" class="<?= isset($personCount) && $pc == $personCount ? 'active' : '' ?>">Menu za <?= (int) $pc ?> osobe</a></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
