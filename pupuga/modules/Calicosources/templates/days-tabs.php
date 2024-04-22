<?php
/**
 * @var Pupuga\Modules\Calicosources\Init $params
 * @var Pupuga\Modules\Calicosources\Days $data
 */
?>

<?php $data = $params['data'] ?>

<nav class="controls-prev-next__prev-next">
    <?php if ($data->getDayPosition() != 'first') : ?>
        <div class="controls-prev-next__control controls-prev-next__control--prev">
            <form class="days-tabs__form display--none" method="GET" action="<?php echo home_url('day') ?>"><input type="hidden" name="lesson" value="<?php echo $data->getLevelData()->term_id ?>"><input type="hidden" name="day-lesson" value="<?php echo $data->getDay() - 1  ?>"></form>
            <div class="controls-prev-next__link"><i class="fa fa-arrow-circle-left controls-prev-next__icon controls-prev-next__icon--prev" aria-hidden="true"></i> <span class="controls-prev-next__text">Previous</span></div>
        </div>
    <?php endif ?>
    <?php if ($data->getDayPosition() != 'last' && count($data->getDays()) > 1) : ?>
        <div class="controls-prev-next__control controls-prev-next__control--next">
            <form class="days-tabs__form display--none" method="GET" action="<?php echo home_url('day') ?>"><input type="hidden" name="lesson" value="<?php echo $data->getLevelData()->term_id ?>"><input type="hidden" name="day-lesson" value="<?php echo $data->getDay() + 1 ?>"></form>
            <div class="controls-prev-next__link"><span class="controls-prev-next__text">Next</span> <i class="fa fa-arrow-circle-right controls-prev-next__icon controls-prev-next__icon--next" aria-hidden="true"></i></div>
        </div>
    <?php endif ?>
</nav>