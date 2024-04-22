<?php if (count($params['resources']->galleryImages) > 0) : ?>
    <div class="resources-list__module-slider-pro slider-pro">
        <div class="sp-slides">
            <?php foreach ($params['resources']->galleryImages as $image)  : ?>
                <div class="sp-slide">
                    <img class="sp-image"
                         data-src="<?php echo $image['full'] ?>"
                         data-small="<?php echo $image['folder'] . $image['sizes']['medium_large']['file'] ?>"
                         data-medium="<?php echo $image['full'] ?>"
                         data-large="<?php echo $image['full'] ?>"
                         data-retina="<?php echo $image['full'] ?>">
                </div>
            <?php endforeach ?>
        </div>
        <div class="sp-thumbnails">
            <?php foreach ($params['resources']->galleryImages as $image)  : ?><img class="sp-thumbnail" src="<?php echo $image['folder'] . $image['sizes']['thumbnail']['file'] ?>"><?php endforeach ?>
        </div>
    </div>
    <div class="resources-list__download-text">Download a printable sheet of <?php echo $params['resources']->level ?> flash cards to use at home, or purchase a professionally printed set.</div>
    <div class="resources-list__download-buttons  resources-list__download-buttons--single">
        <?php Pupuga\Libs\Files\Files::getTemplate('button-view', true, ['link' => $params['resources']->viewFileLink, 'label' => ''], __DIR__ . '/'); ?>
        <?php Pupuga\Libs\Files\Files::getTemplate('button-download', true, ['link' => $params['resources']->downloadFileLink, 'label' => ''], __DIR__ . '/'); ?>
        <?php if ($params['resources']->buy == 1) : ?>
            <?php Pupuga\Libs\Files\Files::getTemplate('button-buy', true, ['link' => $params['resources']->link, 'label' => ' printed copy'], __DIR__ . '/'); ?>
        <?php endif ?>
    </div>
<?php endif ?>
