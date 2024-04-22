</div><!-- general end -->
<footer class="general__footer">
    <div class="general__footer-top">
        <?php Pupuga\Core\Load\Widget::getWidget('Footer area', true, array('class' => 'wrapper-widget wrapper-widget--footer')) ?>
    </div>
    <div class="general__footer-bottom">
        <div class="block-columns skeleton">
            <div class="block-columns__left"><?php echo Pupuga\Libs\Data\Date::getCopyright('2017') ?></div>
            <div class="block-columns__right hide-768">
                <?php Pupuga\Libs\Files\Files::getTemplatePupuga('menu', true, array('slug' => 'Helping Pages', 'class' => 'general__menu general__menu--separators')) ?>
            </div>
        </div>
    </div>
</footer><!-- footer end -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
<?php wp_footer() ?>
<?php if(isset(Pupuga\Core\Base\Common::app()->common['types_svg'])) :?><div class="display-none"><?php echo Pupuga\Core\Base\Common::app()->common['types_svg'] ?></div><?php endif ?>
<?php new Pupuga\Modules\Gdpr\Init() ?>
<?php do_action('main_content_bottom') ?>
</body>
</html>