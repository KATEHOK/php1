<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    const strict_types = 1;
    ini_set('error_reporting', (string)E_ALL);
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    ?>
    <?php
    const SITE_NAME = "GadgetHub";
    const CART_BTN = "Cart";
    const DOOR_BTN = "Sign in";
    const FOOTER_TXT = "Lorem ipsum dolor sit amet consectetur
    adipisicing elit.
    Praesentium magnam non
    nihil odio, commodi natus, laboriosam voluptatem et eius neque vel? Deleniti ut itaque soluta optio
    rerum tenetur illum assumenda.";
    const CHANGE_DATE = "26.02.2021";
    const SITE_VERSION = "2.1.8.15.15"; // php.osp.js.scc.html
    const COPY = "&copy;All rights reserved 2021";
    $vkLink = "https://vk.com/id260666925";
    $instagramLink = "https://www.instagram.com/_4l4h_/";
    $githubLink = "https://github.com/KATEHOK";
    $email = "a.timin2003@mail.ru";
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME ?></title>
    <script src="https://use.fontawesome.com/b8217314ad.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <script defer src="js/Vue.js"></script>
    <script defer src="js/FilterComponent.js"></script>
    <script defer src="js/ProductComponent.js"></script>
    <script defer src="js/CartComponent.js"></script>
    <script defer src="js/main.js"></script>
</head>

<body>
    <!-- Буду использовать своей зачётный проект с курса JavaScript 2 -->
    <div class="body-container" id="app">
        <div class="main-wrapper container">
            <header class="main-header">
                <div class="main-header-logo-wrapper"></div>
                <h1 class="main-header-title"><?php echo SITE_NAME ?></h1>
                <div class="main-header-icons">
                    <filt ref="filt"></filt>
                    <button class="main-header-cart-btn main-header-icon btn" @click="$root.$refs.cart.showCart = !$root.$refs.cart.showCart"><?php echo CART_BTN ?></button>
                    <button class="main-header-door-btn main-header-icon btn"><?php echo DOOR_BTN ?></button>
                    <cart ref="cart"></cart>
                </div>
            </header>
            <main class="main">
                <products ref="products"></products>
            </main>
        </div>
        <footer class="main-footer container">
            <div class="main-footer-wrapper">
                <p class="main-footer-wrapper-txt main-footer-item"><?php echo FOOTER_TXT ?></p>
                <span class="main-footer-wrapper-date main-footer-item"><?php echo CHANGE_DATE ?></span>
                <span class="main-footer-wrapper-version main-footer-item"><?php echo SITE_VERSION ?></span>
                <span class="main-footer-wrapper-copy main-footer-item"><?php echo COPY ?></span>
            </div>
            <?php
            $contucts = [
                "<a href=\"$vkLink\" class=\"main-footer-contucts-item-link\" target=\"_blank\">VK</a>",
                "<a href=\"$instagramLink\" class=\"main-footer-contucts-item-link\" target=\"_blank\">Instagram</a>",
                "<a href=\"$githubLink\" class=\"main-footer-contucts-item-link\" target=\"_blank\">GitHub</a>",
                "$email",
            ];
            echo '<ul class="main-footer-contacts main-footer-item">';
            foreach ($contucts as $contuct) {
                echo '<li class="main-footer-contucts-item">' . $contuct . '</li>';
            }
            echo '</ul>';
            ?>
        </footer>
    </div>
</body>

</html>