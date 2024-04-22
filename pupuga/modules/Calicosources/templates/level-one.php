<article class="round-arrow-rectangle-block <?php if(\Pupuga\Modules\Calicosources\User::app()->isFreePlanUser() && !$params->trial) :?>round-arrow-rectangle-block--disable modal-trigger<?php endif ?>" <?php if(\Pupuga\Modules\Calicosources\User::app()->isFreePlanUser() && !$params->trial) :?>data-template=".template--free-trial-denied" data-wrapper="modal--free-trial-denied"<?php endif ?>>
    <div class="round-arrow-rectangle-block__link round-arrow-rectangle-block__link--<?php echo $params->level ?> <?php if (\Pupuga\Modules\Calicosources\User::app()->isFreePlanUser() && !$params->trial) :?>round-arrow-rectangle-block__link--disable<?php endif ?>">
        <form class="round-arrow-rectangle-block__lesson-form display-none" method="GET" action="<?php echo home_url('day') ?>"><input type="hidden" name="lesson" value="<?php echo $params->term_id ?>"></form>
        <div class="round-block round-block--<?php echo $params->level ?>">
            <div class="round-block__position round-block__position--<?php echo $params->level ?>"><h4 class="round-block__subtitle round-block__subtitle--<?php echo $params->level ?>">Unit</h4><h3 class="round-block__title round-block__title--<?php echo $params->level ?>"><?php echo $number = $params->order ?></h3></div>
        </div>
        <div class="arrow-rectangle-block arrow-rectangle-block--<?php echo $params->level ?>">
            <div class="arrow-rectangle-block__area arrow-rectangle-block__area--<?php echo $params->level ?>">
                <header class="arrow-rectangle-block__header arrow-rectangle-block__header--<?php echo $params->level ?>">
                    <h4 class="arrow-rectangle-block__subtitle arrow-rectangle-block__subtitle--<?php echo $params->level ?>">Unit <?php echo $number ?>:</h4>
                    <h3 class="arrow-rectangle-block__title arrow-rectangle-block__title--<?php echo $params->level ?>"><?php echo $params->title ?><?php if (!empty($params->title_plus)) : ?><span class="arrow-rectangle-block__title-plus arrow-rectangle-block__title-plus--<?php echo $params->level ?>"> (<?php echo $params->title_plus ?>)</span><?php endif ?></h3>
                </header>
                <section class="arrow-rectangle-block__description arrow-rectangle-block__description--<?php echo $params->level ?>"><?php echo $params->description ?></section>
                <footer class="arrow-rectangle-block__footer arrow-rectangle-block__footer--<?php echo $params->level ?>">
                    <div class="resources-count-block resources-count-block--<?php echo $params->level ?>">
                        <h3 class="resources-count-block__title resources-count-block__title--<?php echo $params->level ?>">This unit includes:</h3>
                        <div class="resources-count-block__list resources-count-block__list--<?php echo $params->level ?>">
                            <ul class="grid-line grid-line--<?php echo $params->level ?>">
                                <?php foreach ($params->sources as $params->source) : ?>
                                    <li class="grid-line__item grid-line__item--<?php echo $params->level ?>">
                                        <span class="grid-line__icon grid-line__icon--<?php echo $params->level ?>"><i class="fa fa-<?php echo $params->source['icon'] ?>" aria-hidden="true"></i></span><span class="grid-line__count grid-line__count--<?php echo $params->level ?>"><?php echo $params->source['count'] ?></span><span class="grid-line__title grid-line__title--<?php echo $params->level ?>"><?php echo $params->source['name'] ?></span>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</article>