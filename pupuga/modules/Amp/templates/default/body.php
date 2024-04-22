<?php
/**
 * @var Pupuga\Modules\Amp\getDefaultParams $params
 */
?>
<div class="amp-general">
    <div class="amp-general__header">
        <div class="amp-general__logo">
            <a href="<?php echo home_url() ?>"><?php echo $params->getLogo() ?></a>
        </div>
    </div>
    <div class="amp-wrapper amp-wrapper--main">
        <div class="amp-general__article">
            <h1 class="amp-title"><?php echo $params->getTitle() ?></h1>
            <?php echo wp_get_attachment_image($params->getId()) ?>
            <amp-img src="<?php echo $params->getThumbnailSrc() ?>"
                     width="<?php echo $params->getThumbnailWidth() ?>"
                     height="<?php echo $params->getThumbnailHeight() ?>"
                     alt="<?php echo $params->getThumbnailAlt() ?>"
                     layout="responsive"
                     class="amp-image amp-image--thumbnail">
                <div fallback>offline</div>
            </amp-img>
            <div class="amp-content">
                <?php echo $params->getContent() ?>
            </div>
        </div>
        <div class="amp-general__articles">
            <h3 class="amp-section-title">Siste artikler</h3>
            <div class="amp-items">
                <?php echo $params->getPosts(3, 'post') ?>
            </div>
        </div>
    </div>
</div>
<div class="amp-general__footer">
    <div class="amp-wrapper">Copyright &copy; <?php echo $params->getDateCopyright() ?> <?php echo $params->getName() ?></div>
</div>




