<?php $breadcrumb = Pupuga\Libs\Files\Files::getTemplate('breadcrumb', false, ['breadcrumb' => $params['breadcrumb']], __DIR__ . '/') ?>
<form class="level-form display-none" method="GET" action="<?php echo home_url('day') ?>"><input type="hidden" name="lesson" value="<?php echo $params['level']->term_id ?>"></form>
<section class="round-arrow-rectangle-blocks">
    <?php foreach ($params['data'] as $dayStep) : ?>
        <article class="round-arrow-rectangle-block">
            <div class="round-arrow-rectangle-block__area round-arrow-rectangle-block__area--align-items-reset round-arrow-rectangle-block__area--<?php echo $params['style'] ?>">
                <?php if ($dayStep->term_type == 'first-day-preview') : ?>
                    <div class="round-block round-block--<?php echo $params['style'] ?> level-background-color level-background-color--<?php echo $params['style'] ?>">
                        <div class="round-block__position round-block__position--<?php echo $params['style'] ?>"><h4 class="round-block__subtitle">Day</h4><h3 class="round-block__title round-block__title--white"><?php echo $params['day'] ?></h3></div>
                    </div>
                <?php else : ?>
                    <div class="round-block round-block--no-border"><svg x="0px" y="0px" viewBox="0 0 260 260"><use xlink:href="#type-icon--<?php echo $dayStep->term_type ?>" x="0" y="0"></svg></div>
                <?php endif ?>
                <div class="arrow-rectangle-block arrow-rectangle-block--<?php echo $params['style'] ?>">
                    <div class="arrow-rectangle-block__area arrow-rectangle-block__area--fixed-corner arrow-rectangle-block__area--<?php echo $params['style'] ?>">
                        <header class="arrow-rectangle-block__header">
                            <nav class="arrow-rectangle-block__breadcrumb"><?php echo $breadcrumb ?></nav>
                            <h3 class="arrow-rectangle-block__title arrow-rectangle-block__title--<?php echo $params['style'] ?>"><?php echo $dayStep->post_title ?></h3>
                        </header>
                        <section class="arrow-rectangle-block__content arrow-rectangle-block__content--<?php echo $params['style'] ?>"><?php echo wpautop($dayStep->post_content) ?></section>
                        <?php if (count($dayStep->modules) > 0) : ?>
                            <section class="arrow-rectangle-block__modules arrow-rectangle-block__modules--<?php echo $params['style'] ?>">
                                <?php foreach ($dayStep->modules as $module) : $module = (new Pupuga\Modules\Calicosources\TypeSource($module))?>
                                    <div class="arrow-rectangle-block__module arrow-rectangle-block__module--<?php echo $params['style'] ?> arrow-rectangle-block__module--<?php echo $module->getModuleType() ?>"><?php echo $module->getModuleContent() ?></div>
                                <?php endforeach ?>
                            </section>
                        <?php endif ?>
                        <?php if(!empty($dayStep->buttonsHtml)) :?>
                            <div class="arrow-rectangle-block__sources-buttons arrow-rectangle-block__sources-buttons--<?php echo $params['style'] ?>"><?php  echo $dayStep->buttonsHtml ?></div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach ?>
</section>
    