<?php
/**
 * @var Pupuga\Modules\Icons\Init $params
 */
?>
<span class="icons-font">
    <?php if (!empty($params->data['link'])) : ?><a class="icons-font__link" href="<?php echo $params->data['link'] ?>"><?php endif ?>
        <i class="icons-font__icon fa fa-<?php echo $params->atts['icon'] ?>" aria-hidden="true">
            <?php if(isset($params->atts['text']) && !empty($params->atts['text'])) : ?>
                <span class="icons-font__text"><?php echo $params->atts['text']?></span>
            <?php endif ?>
        </i>
    <?php if (!empty($params->data['link'])) : ?></a><?php endif ?>
</span>