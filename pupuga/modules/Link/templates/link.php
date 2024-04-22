<?php
/**
 * @var Pupuga\Modules\Link\Init $params
 */
?>
<span class="link-custom"><?php if (!empty($params->data['link'])) : ?><a class="link-custom__link <?php echo $params->atts['style'] ?>" style="<?php if(isset($params->atts['size']) && !empty($params->atts['size'])) echo 'font-size:'.$params->atts['size'].'em' ?>" href="<?php echo $params->data['link'] ?>" target="<?php echo $params->data['target'] ?>"><?php endif ?>
        <?php if (isset($params->atts['icon']) && !empty($params->atts['icon']) && ($params->atts['position'] == 'left' || !isset($params->atts['position']))) : ?><i class="link-custom__icon fa fa-<?php echo $params->atts['icon'] ?>" aria-hidden="true"></i><?php endif ?>
        <?php if (isset($params->atts['text']) && !empty($params->atts['text'])) : ?><span class="link-custom__text"><?php echo $params->atts['text'] ?></span><?php endif ?>
        <?php if (isset($params->atts['icon']) && !empty($params->atts['icon']) && $params->atts['position'] == 'right') : ?><i class="link-custom__icon fa fa-<?php echo $params->atts['icon'] ?>" aria-hidden="true"></i><?php endif ?>
        <?php if (!empty($params->data['link'])) : ?></a><?php endif ?>
</span>