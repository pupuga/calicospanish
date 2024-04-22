<?php $collapseSlugsSlugs = array(); ?>
<div class="block-module-collapse">
    <div class="block-module-collapse__all">
        <a href="#" class="block-module-collapse__collapse-expand-all">Expand All / Collapse All</a>
    </div>
    <?php foreach ($params['module']['tabs'] as $param) : ?>
        <?php $i = 0 ?>
        <div class="block-module-collapse__row">
            <?php $collapseSlugs[$i] = $param['tab_title'] ? sanitize_title($param['tab_title']) : '' ?>
            <div data-slug="<?php echo $collapseSlugs[$i] ?>" class="block-module-collapse__title <?php if ($i < 0) : ?>block-module-collapse__title--open<?php endif ?>" style="<?php echo isset($params['block']->atts['color']) ? 'color:' . $params['block']->atts['color'] : '' ?>"><span class="block-module-collapse__title-text"><?php echo $param['tab_title'] ?></span></div>
            <div data-slug="<?php echo $collapseSlugs[$i] ?>" class="block-module-collapse__text <?php if ($i < 0) : ?>block-module-collapse__text--open<?php endif ?>"><?php echo Pupuga\Libs\Data\Html::transformHtml($param['tab_text']) ?></div>
        </div>
        <?php $i++ ?>
    <?php endforeach ?>
</div>