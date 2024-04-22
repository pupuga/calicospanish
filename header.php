<!doctype html>
<html>
<head>
    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('meta', true) ?>
    <?php wp_head() ?>
    <?php Pupuga\Libs\Files\Files::getCss(__DIRASSETS__ . 'skeleton.css', true) ?>
    <script>let globalData = <?php echo Pupuga\Core\Base\Common::app()->getJs() ?></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-3732449-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-3732449-3');
    </script>
</head>
<body class="<?php if (is_front_page()) : ?>front-page<?php else : ?>no-front-page<?php endif ?> <?php if (is_account_page() && is_user_logged_in()) : ?>account-page<?php endif ?>">
<div class="modal">
    <div class="modal__content">
        <div class="modal__close"><i class="fa fa-times modal__close-icon" aria-hidden="true"></i></div>
        <div class="modal__data"></div>
    </div>
</div>
<!-- spinner -->
<?php //Pupuga\Libs\Files\Files::getTemplatePupuga('spinner', true) ?>
<!-- spinner end -->
<!-- mobile -->
<?php Pupuga\Libs\Files\Files::getTemplatePupuga('responsive', true) ?>
<!-- mobile end-->
<!-- general -->
<div class="mobile-menu">
    <div class="mobile-menu__wrapper-block">
        <nav class="mobile-menu__block mobile-menu__block--custom">
            <ul>
                <?php Pupuga\Core\Load\Menu::app()->menuStandard('Mobile Menu')->action() ?>
            </ul>
        </nav>
        <nav class="mobile-menu__block mobile-menu__block--auto"></nav>
    </div>
</div>
<div class="general">
    <!-- header -->
    <header class="general__header">
        <div class="general__header--top">
            <nav class="skeleton-narrow general__menu general__menu--right general__menu--purple">
                <ul>
                    <?php $menu = is_user_logged_in() ? 'Main Pages (User)' : 'Main Pages' ?>
                    <?php Pupuga\Core\Load\Menu::app()
                        ->menuStandard($menu)
                        ->replaceShortCodeLink(
                            array('//logout//' => wp_logout_url(get_permalink(wc_get_page_id('myaccount'))))
                        )
                        ->action() ?>
                    <li><a class="cart-contents"></a></li>
                </ul>
            </nav>
        </div>
        <div class="block-columns general__header--bottom skeleton-narrow">
            <div class="block-columns__left">
                <?php Pupuga\Libs\Files\Files::getTemplatePupuga('logo', true, array('class' => 'general__logo')) ?>
            </div>
            <div class="block-columns__right <?php if (is_user_logged_in()) : ?>user-logged<?php else : ?>user-guest<?php endif ?>">
                <?php //if (wc_memberships_is_user_active_member()) : ?>
                <?php if (is_user_logged_in()) : ?>
                    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('menu', true, array('slug' => 'Services Pages (Members)', 'class' => 'general__menu general__menu--right general__menu--button')) ?>
                <?php else : ?>
                    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('menu', true, array('slug' => 'Services Pages', 'class' => 'general__menu general__menu--right hide-768')) ?>
                <?php endif ?>
            </div>
        </div>
        <?php
        global  $post;
        $posttype = get_post_type($post );
        if (((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')) {
            Pupuga\Core\Load\Widget::getWidget('Header area', true, array('class' => 'wrapper-widget '));
        } else {
            Pupuga\Core\Load\Widget::getWidget('Header area', true, array('class' => 'wrapper-widget general__header--under'));
        }
        ?>
    </header><!-- header end -->