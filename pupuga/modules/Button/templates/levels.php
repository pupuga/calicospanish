<?php
/**
 * @var Pupuga\Modules\Button\Init $params
 */
?>

<?php
    $level = ($_GET['level'] != 'all-levels' && !empty($_GET['level'])) ? strtolower(substr($_GET['level'], -1)) : '';
    $link = (isset($params->atts['link'.$level])) ? $params->atts['link'.$level] : $params->atts['link'];
?>
<a href="<?php echo $link ?>" class="button <?php echo $params->atts['class'] ?><?php echo $params->data['class'] ?>" style="<?php echo $params->atts['style'] ?> <?php  echo $params->data['width'] ?>">
    <?php echo $params->data['title'] ?><?php echo !empty($level) ? ' Level ' . strtoupper($level) : '' ?>
</a>