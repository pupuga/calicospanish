<?php $collapseSlugsSlugs = array(); ?>
<div class="block-module-timeline">
    <?php foreach ($params['module']['tabs'] as $param) : ?>
        <?php $i = 0 ?>
        <div class="block-module-timeline__row">
            <?php $collapseSlugs[$i] = $param['tab_title'] ? sanitize_title($param['tab_title']) : '' ?>
            <div class="block-module-timeline__date"><?php echo $param['tab_title'] ?></div>
            <div class="block-module-timeline__text"><?php echo Pupuga\Libs\Data\Html::transformHtml($param['tab_text']) ?></div>
        </div>
        <?php $i++ ?>
    <?php endforeach ?>
</div>