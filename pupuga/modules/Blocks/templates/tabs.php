<?php $tabsSlugs = array(); ?>
<div class="block-module-tabs">
    <div class="block-module-tabs__titles">
        <?php $i = 0 ?>
        <?php foreach ($params['module']['tabs'] as $param) : ?>
            <?php $tabsSlugs[$i] = $param['tab_title'] ? sanitize_title($param['tab_title']) : '' ?>
            <div data-slug="<?php echo $tabsSlugs[$i] ?>" class="block-module-tabs__title <?php if($i === 0 ) : ?>block-module-tabs__title--active<?php endif ?>" style="<?php echo isset($params['block']->atts['color']) ? 'color:' . $params['block']->atts['color'] : '' ?>"><?php echo $param['tab_title'] ?></div>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
    <div class="block-module-tabs__contents">
        <?php $i = 0 ?>
        <?php foreach ($params['module']['tabs'] as $param) : ?>
            <div data-slug="<?php echo $tabsSlugs[$i] ?>" class="block-module-tabs__text <?php if($i === 0 ) : ?>block-module-tabs__text--active<?php endif ?>"><?php echo Pupuga\Libs\Data\Html::transformHtml($param['tab_text']) ?></div>
            <?php $i++ ?>
        <?php endforeach ?>
    </div>
</div>
