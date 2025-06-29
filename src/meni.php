<?php
// Initialize Bootstrap before any output
require_once 'admin/init.php';

$visit1 = '';
$visit2 = '';
$visit3 = 'pressed';
$visit4 = '';

// Set title image for this page
$title_image = 'title3.png';
$title_width = '63';
$title_height = '61';

include 'inc/header.php';
?>

<div class="clearer"></div>

<div class="clear"></div>

<div class="page-down">
    <div class="container_12">
        <div class="grid_6">
        <div class="food-menu-list">
                <ul>
                    <?php include 'inc/food-menu-list.php'; ?>
                </ul>
            </div>

            <div class="text-c">
            <div class="mobile-meninav">
                    <a href="#">
                        Izbor jela 
                        <span class="darrow">
                            <img src="img/darrow.png" alt="" width="13" height="11" border="0" />
                        </span>
                    </a>
                </div>
            </div>

            <div class="text-c">
                <div class="mobile-menilist">
                    <ul>
                        <?php include 'inc/food-menu-list.php'; ?>
                    </ul>
                </div>
            </div>
            <br />
        </div>

        <div class="grid_6">
            <div class="food-menu">
                <div class="food-menu-top"></div>
                <div class="food-menu-content">
                    <p class="food-menu-image-wrapper">
                        <img src="img/jelovnik_pic2.png" class="food-menu-image" />
                    </p>
                </div>
                <div class="food-menu-bottom"></div>

                <br />
                <p class="text-c txt2 italic">Sve cijene su izražene u EUR</p>
                <br />
                <br />
            </div>
        </div>

        <div class="clear"></div>
    </div>
</div>

<br />
<br />
<?php include 'inc/footer.php'; ?>
