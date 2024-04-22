<div class="block-module-list">
    <?php foreach ($params['html'] as $param) : ?>
        <div class="block-module-list__cell">
            <div class="block-module-list__text"><?php echo Pupuga\Libs\Data\Html::transformHtml($param['list_items_editor']) ?></div>
            <div class="block-module-list__items">
                <?php foreach ($param['list_items_loop'] as $listItem) : ?>
                    <div class="block-module-list__item">
                        <div class="block-module-list__item-label"><?php echo Pupuga\Libs\Data\Html::transformHtml($listItem['list_items_label']) ?></div>
                        <div class="block-module-list__item-text"><?php echo Pupuga\Libs\Data\Html::transformHtml($listItem['list_items_data']) ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endforeach ?>
</div>