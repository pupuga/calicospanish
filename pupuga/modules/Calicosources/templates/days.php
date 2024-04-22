<?php
/**
 * @var Pupuga\Modules\Calicosources\Init $params
 * @var Pupuga\Modules\Calicosources\Days $data
 */
?>

<?php $data = $params->data; ?>

<nav class="general__block general__block--level-header">
    <?php Pupuga\Libs\Files\Files::getTemplate('breadcrumb', true, ['breadcrumb' => $data->getBreadcrumb()], __DIR__ . '/'); ?>
</nav>
<div class="general__block">
    <?php Pupuga\Libs\Files\Files::getTemplate('present', true, ['data' => $data->getLevelData()], __DIR__ . '/'); ?>
</div>
<?php if ($data->getAccess()) : ?>
<div class="general__block">
    <div class="days-tabs">
        <div class="days-tabs__controls">
            <div class="controls-prev-next">
                <div class="controls-prev-next__preview">Select a Day to start learning:</div>
                <?php Pupuga\Libs\Files\Files::getTemplate('days-tabs', true, ['data' => $data], __DIR__ . '/'); ?>
            </div>
        </div>
        <nav class="days-tabs__tabs">
            <div class="days-tabs__items">
                <?php foreach ($data->getDays() as $day) : ?>
                    <div class="days-tabs__item<?php if ($day == $data->getDay()) : ?> days-tabs__item--active days-tabs__item--<?php echo $data->getLevelData()->levelStyle ?><?php endif ?>">
                        <form class="days-tabs__form display--none" method="GET" action="<?php echo home_url('day') ?>"><input type="hidden" name="lesson" value="<?php echo $data->getLevelData()->term_id ?>"><input type="hidden" name="day-lesson" value="<?php echo $day ?>"></form>
                        <div class="days-tabs__text">Day</div>
                        <div class="days-tabs__number"><?php echo $day ?></div>
                    </div>
                <?php endforeach ?>
            </div>
        </nav>
    </div>
</div>
<div class="general__block">
    <?php Pupuga\Libs\Files\Files::getTemplate('day', true, ['data' => $data->getDayData(), 'style' => $data->getLevelData()->levelStyle, 'day' => $data->getDay(), 'level' => $data->getLevelData(), 'breadcrumb' => $data->getBreadcrumbDay()], __DIR__ . '/'); ?>
</div>
<div class="general__block">
    <div class="controls-prev-next">
        <?php Pupuga\Libs\Files\Files::getTemplate('days-tabs', true, ['data' => $data], __DIR__ . '/'); ?>
    </div>
</div>
<?php else : ?>
    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('denied', true); ?>
<?php endif ?>