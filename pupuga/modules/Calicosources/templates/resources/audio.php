<div class="resources-list__audio"><audio src="<?php echo $params['resources']->downloadFile ?>" preload="none"></audio></div>
<?php if($params['resources']->buy == 1) : ?>
    <div class="resources-list__download-buttons"><?php Pupuga\Libs\Files\Files::getTemplate('button-buy', true, ['link' => $params['resources']->link, 'label' => ' Music CD'], __DIR__ . '/'); ?></div>
<?php endif ?>