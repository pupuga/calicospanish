<?php //print_r($params->data->getLevels()) ?>
<section class="levels-block">
    <div class="levels-block__list">
        <?php foreach ($params->data->getLevels() as $level) : ?>
        <article class="round-arrow-rectangle-block">
            <div class="round-arrow-rectangle-block__link round-arrow-rectangle-block__link--<?php echo $params->slug ?>">
                <form class="round-arrow-rectangle-block__lesson-form display-none" method="GET" action="<?php echo home_url($level->slug) ?>"></form>
                <div class="round-block round-block--no-border"><img src="<?php echo $level->image ?>" alt="<?php echo $level->title ?>"></div>
                <div class="arrow-rectangle-block arrow-rectangle-block--<?php echo $level->slug ?>">
                    <div class="arrow-rectangle-block__area arrow-rectangle-block__area--<?php echo $level->slug ?>">
                        <header class="arrow-rectangle-block__header arrow-rectangle-block__header--<?php echo $level->slug ?>">
                            <h3 class="arrow-rectangle-block__title arrow-rectangle-block__title--<?php echo $level->slug ?>"><?php echo $level->title ?><?php if (!empty($level->titlePlus)) : ?><span class="arrow-rectangle-block__title-plus arrow-rectangle-block__title-plus--<?php echo $level->slug ?>"> (<?php echo $level->titlePlus ?>)</span><?php endif ?></h3>
                        </header>
                        <section class="arrow-rectangle-block__description arrow-rectangle-block__description--<?php echo $level->slug ?>"><?php echo $level->description ?></section>
                        <footer class="arrow-rectangle-block__footer arrow-rectangle-block__footer--<?php echo $level->slug ?>">
                            <div class="resources-count-block resources-count-block--<?php echo $level->slug ?>">
                                <h3 class="resources-count-block__title resources-count-block__title--<?php echo $level->slug ?>">This level includes:</h3>
                                <div class="resources-count-block__list resources-count-block__list--<?php echo $level->slug ?>">
                                    <ul class="grid-line grid-line--<?php echo $level->slug ?>">
                                        <?php foreach ($level->sources as $source) : ?>
                                        <li class="grid-line__item grid-line__item--<?php echo $level->slug ?>">
                                            <span class="grid-line__icon grid-line__icon--<?php echo $level->slug ?>"><i class="fa fa-<?php echo $source['icon'] ?>" aria-hidden="true"></i></span><span class="grid-line__count grid-line__count--<?php echo $level->slug ?>"><?php echo $source['count'] ?></span><span class="grid-line__title grid-line__title--<?php echo $level->slug ?>"><?php echo $source['name'] ?></span>
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
    <?php endforeach ?>
    </div>
</section>
