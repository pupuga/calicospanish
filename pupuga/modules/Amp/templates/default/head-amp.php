<?php
/**
 * @var Pupuga\Modules\Amp\getDefaultParams $params
 */
?>
<script type="application/ld+json">
{
    "@context":"http://schema.org",
    "@type":"NewsArticle",
    "mainEntityOfPage":{
        "@type":"WebPage",
        "@id":"<?php echo $params->getCanonicalUrl() ?>",
        "author":{
            "@type":"Organization",
            "name":"<?php echo $params->getName() ?>"
        },
        "datePublished":"<?php echo $params->getCreateDate() ?>",
        "dateModified":"<?php echo $params->getModifiedDate() ?>",
        "headline":"<?php echo $params->getTitle() ?>",
        "image":"<?php echo $params->getThumbnailSrc() ?>",
        "publisher":{
            "@type": "Organization",
            "name": "<?php echo $params->getName() ?>",
	        "logo":{
	            "@type":"ImageObject",
                "url":"<?php echo $params->getLogoSrc() ?>",
                "width":<?php echo $params->getLogoWidth() ?>,
                "height":<?php echo $params->getLogoHeight() ?>
            }
	    },
        "mainEntityOfPage":"<?php echo $params->getCanonicalUrl() ?>"
    },
    "headline":"<?php echo $params->getTitle() ?>",
    "datePublished":"<?php echo $params->getCreateDate() ?>",
    "dateModified":"<?php echo $params->getModifiedDate() ?>",
    "description":"<?php echo $params->getDescription() ?>",
    "thumbnailUrl":"<?php echo $params->getThumbnailSrc() ?>",
    "author":{
        "@type":"Organization",
        "name":"<?php echo $params->getName() ?>"
    },
    "publisher":{
      "@type":"Organization",
        "name":"<?php echo $params->getName() ?>",
        "logo":{
          "@type":"ImageObject",
            "url":"<?php echo $params->getLogoSrc() ?>",
            "width":<?php echo $params->getLogoWidth() ?>,
            "height":<?php echo $params->getLogoHeight() ?>
      }
    },
    "image":{
      "@type":"ImageObject",
        "url":"<?php echo $params->getThumbnailSrc() ?>",
        "height":<?php echo $params->getThumbnailWidth() ?>,
        "width":<?php echo $params->getThumbnailHeight() ?>
    }
}
</script>
<script async src="https://cdn.ampproject.org/v0.js"></script>
<script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
<script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
<style amp-boilerplate="">body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style>
<noscript><style amp-boilerplate="">body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
<style amp-custom><?php echo $params->getCustomStyles() ?></style>