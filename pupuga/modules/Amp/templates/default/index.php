<?php
/**
 * @var Pupuga\Modules\Amp\getDefaultParams $params
*/
?>
<!doctype html>
<html amp lang="<?php echo $params->getLang() ?>">
<head>
    <?php echo $params->getHeadTemplate() ?>
</head>
<body>
    <?php echo $params->getBodyTemplate() ?>
    <?php echo $params->getGooglePageview() ?>
</body>
</html>