<?php
/**
 * Template Name: Page with Sidebar
 *
 * Template Post Type: page, post
 */
?>

<?php get_header() ?>
    <div class="general__page-with-sidebar">
        <?php Pupuga\Libs\Files\Files::getTemplatePupuga('main',true) ?>
        <?php Pupuga\Core\Load\Widget::getWidget('sidebar', true, array('class' => 'wrapper-widget wrapper-widget--sidebar')); ?>
    </div>
<?php get_footer() ?>