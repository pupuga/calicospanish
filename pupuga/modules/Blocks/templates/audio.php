<div class="resources-data">
    <div><h3 class="resources-data__title"><?php echo $params['module']['audio_module__title'] ?></h3></div>
    <div class="resources-data__content">
        <div class="resources-list resources-list--free">
            <?php foreach ($params['module']['audio_module__items'] as $resource) : ?>
                <div class="resources-list__item resources-list__item--<?php echo $params['module']['audio_module__color_style'] ?>">
                    <div class="resources-list__content resources-list__content--<?php echo $params['module']['audio_module__color_style'] ?>">
                        <div class="resources-list__corner resources-list__corner--<?php echo $params['module']['audio_module__color_style'] ?>">
                            <div class="resources-list__corner-text">Level<strong><?php echo strtoupper(substr($params['module']['audio_module__color_style'], -1)) ?></strong></div>
                        </div>
                        <div class="resources-list__preview resources-list__preview--<?php echo $params['module']['audio_module__color_style'] ?>">
                            <?php $thumbnail = (!isset($resource['audio_module__image']) || empty($resource['audio_module__image'])) ? __URLASSETS__ . 'resources-thumbnail.png' : wp_get_attachment_image_url($resource['audio_module__image'], 'full') ?>
                            <?php $classImage = (!isset($resource['audio_module__image']) || empty($resource['audio_module__image'])) ? 'without-image' : 'with-image' ?>
                            <div class="resources-list__thumbnail resources-list__thumbnail--<?php echo $resource->levelSlug ?> resources-list__thumbnail--<?php echo $classImage ?>">
                                <img src="<?php echo $thumbnail ?>" title="<?php echo $resource['audio_module__title'] ?>">
                            </div>
                        </div>
                        <div class="resources-list__info resources-list__info--<?php echo $params['module']['audio_module__color_style'] ?>">
                            <div class="resources-list__text resources-list__text--<?php echo $params['module']['audio_module__color_style'] ?>">
                                <div class="resources-list__title resources-list__title--<?php echo $params['module']['audio_module__color_style'] ?>"><?php echo $resource['audio_module__title'] ?></div>
                            </div>
                            <div class="resources-list__source resources-list__source--<?php echo $params['module']['audio_module__color_style'] ?>">
                                <div class="resources-list__audio">
                                    <audio src="<?php echo wp_get_attachment_url($resource['audio_module__file']) ?>" preload="none"></audio>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>