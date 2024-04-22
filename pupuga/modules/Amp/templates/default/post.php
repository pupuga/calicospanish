<?php
/**
 * @var Pupuga\Modules\Amp\getDefaultParams $getParams
 */

$getParams = $params['getParams'];

?>

<a class="amp-item" href="<?php the_permalink() ?>">
    <div class="amp-item__image"><?php echo $getParams->transformImageToAmpImage($params['id']) ?></div>
    <h4 class="amp-item__title"><?php the_title() ?></h4>
</a>
