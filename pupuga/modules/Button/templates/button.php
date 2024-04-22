<?php
/**
 * @var Pupuga\Modules\Button\Init $params
 */
?>

<a href="<?php echo $params->atts['link'] ?>" class="button <?php echo $params->atts['class'] ?><?php echo $params->data['class'] ?>" style="<?php echo $params->atts['style'] ?> <?php  echo $params->data['width'] ?>"><?php echo $params->data['title'] ?></a>