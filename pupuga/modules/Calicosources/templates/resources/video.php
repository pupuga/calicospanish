<div class="resources-list__download-buttons  resources-list__download-buttons--single resources-list__download-buttons--left">
    <?php if (!empty($params['resources']->downloadFileLink)) : ?>
        <?php Pupuga\Libs\Files\Files::getTemplate('button-view', true, ['link' => $params['resources']->viewFileLink, 'label' => ''], __DIR__ . '/'); ?>
        <?php Pupuga\Libs\Files\Files::getTemplate('button-download', true, ['link' => $params['resources']->downloadFileLink, 'label' => ''], __DIR__ . '/'); ?>
    <?php endif ?>
    <?php if ($params['resources']->buy == 1) : ?>
        <?php Pupuga\Libs\Files\Files::getTemplate('button-buy', true, ['link' => $params['resources']->link, 'label' => ' printed copy'], __DIR__ . '/'); ?>
    <?php endif ?>
</div>