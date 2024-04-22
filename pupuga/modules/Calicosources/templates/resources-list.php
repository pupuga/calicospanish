<?php if (is_array($params['resources']) && count($params['resources']) > 0) : ?>
    <div class="resources-list">
        <?php foreach ($params['resources'] as $resource) : ?>
            <div class="resources-list__item resources-list__item--<?php echo $resource->levelSlug ?> resources-list__item--<?php echo $resource->object_id ?>">
                <div class="resources-list__content resources-list__content--<?php echo $resource->levelSlug ?>">
                    <div class="resources-list__corner resources-list__corner--<?php echo $resource->levelSlug ?>"><div class="resources-list__corner-text">Level<strong><?php echo $resource->levelStep ?></strong></div></div>
                    <?php if($params['params']['kind'] != 'gallery') : ?>
                    <div class="resources-list__preview resources-list__preview--<?php echo $resource->levelSlug ?>">
                        <?php $thumbnail = (empty($resource->thumbnail)) ? __URLASSETS__.'resources-thumbnail.png' : $resource->thumbnail ?>
                        <?php $classImage = (empty($resource->thumbnail)) ? 'without-image' : 'with-image' ?>
                        <div class="resources-list__thumbnail resources-list__thumbnail--<?php echo $resource->levelSlug ?> resources-list__thumbnail--<?php echo $classImage ?>"><img src="<?php echo $thumbnail ?>"></div>
                        <?php if ($params['params']['kind'] == 'video') : ?>
                            <div class="modal-trigger resources-list__play resources-list__play--<?php echo $resource->levelSlug ?>" data-video="<?php echo Pupuga\Libs\Files\Files::getTemplate($params['params']['kind'] . '-' . $resource->template, true, ['resources' => $resource, 'params' => $params['params']],  __DIR__ . '/resources/');?>">
                                <div class="resources-list__play-icon resources-list__play-icon--<?php echo $resource->levelSlug ?>"><i class="fa fa-play-circle" aria-hidden="true"></i></div>
                            </div>
                        <?php endif ?>
                    </div>
                    <?php endif ?>
                    <div class="resources-list__info resources-list__info--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery') : ?> resources-list__info--single<?php endif ?>">
                        <?php if(!empty($resource->addidtionalTitle) || !empty($resource->addidtionalSubtitle) || !empty($resource->addidtionalDescription) || $params['params']['kind'] == 'file' || $params['params']['kind'] == 'gallery' || $params['params']['kind'] == 'video') : ?>
                            <div class="resources-list__text resources-list__text--<?php echo $resource->levelSlug ?>">
                                <?php if(($params['params']['kind'] == 'file' || $params['params']['kind'] == 'gallery') && !empty($resource->day)) : ?>
                                    <div class="resources-list__title-lesson resources-list__title-lesson--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery') : ?> resources-list__title-lesson--single<?php endif ?>">Unit <?php echo $resource->lesson ?></div>
                                <?php endif ?>
                                <?php if(isset($resource->error)) : ?><div class="resources-list__info-messages resources-list__info-messages--error"><?php echo $resource->error ?></div><?php endif ?>
                                <?php if(!empty($resource->addidtionalTitle)) : ?><div class="resources-list__title resources-list__title--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery') : ?> resources-list__title--single<?php endif ?>"><?php echo $resource->addidtionalTitle ?></div><?php endif ?>
                                <?php if(!empty($resource->addidtionalSubtitle)) : ?><div class="resources-list__subtitle resources-list__subtitle--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery') : ?> resources-list__subtitle--single<?php endif ?>"><?php echo $resource->addidtionalSubtitle ?></div><?php endif ?>
                                <?php if(!empty($resource->addidtionalDescription)) : ?><div class="resources-list__description resources-list__description--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery') : ?> resources-list__description--single<?php endif ?>"><?php echo $resource->addidtionalDescription ?></div><?php endif ?>
                            </div>
                        <?php endif ?>
                        <div class="resources-list__source resources-list__source--<?php echo $resource->levelSlug ?><?php if($params['params']['kind'] == 'gallery' || $params['params']['kind'] == 'video') : ?> resources-list__source--single<?php endif ?>"><?php Pupuga\Libs\Files\Files::getTemplate($params['params']['kind'], true, ['resources' => $resource, 'params' => $params['params']], __DIR__ . '/resources/'); ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
<?php else : ?>
    <div class="message message--info">We don't have resources yet.</div>
<?php endif ?>