<?php if(count($params['images']) > 0) : ?>
<div class="arrow-rectangle-block__module-slider-pro slider-pro">
    <div class="sp-slides">
        <?php foreach($params['images'] as $image)  : ?>
        <div class="sp-slide">
            <img class="sp-image"
                 data-src="<?php echo $image['full'] ?>"
                 data-small="<?php echo $image['folder'] . $image['size']['sizes']['medium_large']['file'] ?>"
                 data-medium="<?php echo $image['full']  ?>"
                 data-large="<?php echo $image['full'] ?>"
                 data-retina="<?php echo $image['full'] ?>">
        </div>
        <?php endforeach ?>
    </div>
    <div class="sp-thumbnails">
        <?php foreach($params['images'] as $image)  : ?><img class="sp-thumbnail" src="<?php echo $image['folder'] . $image['size']['sizes']['thumbnail']['file'] ?>"><?php endforeach ?>
    </div>
</div>
<?php endif ?>
