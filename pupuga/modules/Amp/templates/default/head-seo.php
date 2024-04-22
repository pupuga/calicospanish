<?php
/**
 * @var Pupuga\Modules\Amp\getDefaultParams $params
 */
?>
<link rel="canonical" href="<?php echo $params->getCanonicalUrl() ?>">
<meta name="description" content="<?php echo $params->getDescription() ?>">
<meta name="H1" content="<?php echo $params->getTitle() ?>">
<?php if(!empty($params->getTwitter())) : ?>
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="<?php echo $params->getTwitter() ?>">
    <meta property="twitter:creator" content="<?php echo $params->getTwitter() ?>">
    <meta property="twitter:title" content="<?php echo $params->getTitle() ?>">
    <meta property="twitter:description" content="<?php echo $params->getDescription() ?>">
    <meta property="twitter:image:src" content="<?php echo $params->getThumbnailSrc() ?>">
<?php endif ?>
<meta property="og:type" content="article">
<meta property="og:title" content="<?php echo $params->getTitle() ?>">
<meta property="og:description" content="<?php echo $params->getDescription() ?>">
<meta property="og:url" content="<?php echo $params->getAmpUrl() ?>">
<meta property="og:image" content="<?php echo $params->getThumbnailSrc() ?>">
<meta property="og:image:width" content="<?php echo $params->getThumbnailWidth() ?>">
<meta property="og:image:height" content="<?php echo $params->getThumbnailHeight() ?>">