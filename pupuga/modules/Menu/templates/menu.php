<?php
/**
 * @var Pupuga\Modules\Menu\Init $params
 */
?>
<?php if($params->atts['enable'] !== false) : ?>
    <div class="general__wrapper-block">
        <?php Pupuga\Libs\Files\Files::getTemplatePupuga(
            'menu',
            true,
            array('slug' => $params->atts['name'], 'class' => 'general__menu ' . $params->atts['class'], 'span' => $params->atts['span']))
        ?>
    </div>
<?php endif ?>