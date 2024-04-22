<div class="block-module-items">
    <?php foreach ($params['html'] as $param) : ?>
    <div class="block-module-items__cell">
        <div class="block-module-items__image"><?php echo wp_get_attachment_image($param['item_image'], 'full') ?></div>
        <div class="block-module-items__text"><?php echo Pupuga\Libs\Data\Html::transformHtml($param['item_text']) ?></div>
    </div>
    <?php endforeach ?>
</div>