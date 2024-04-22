<?php
/**
 * @var Pupuga\Modules\Blocks\Init $params
 */
?>

<div class="blocks <?php echo $params->data->meta->block_class ?>" style="<?php echo $params->data->meta->block_style ?>">
    <?php echo Pupuga\Libs\Data\Html::transformHtml($params->data->modules) ?>
</div>
