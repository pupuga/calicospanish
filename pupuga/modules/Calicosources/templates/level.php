<?php
/**
 * @var Pupuga\Modules\Calicosources\Init $params
 * @var Pupuga\Modules\Calicosources\Level $data
 */
?>
<?php $data = $params->data ?>
<nav class="general__block general__block--level-header">
    <?php Pupuga\Libs\Files\Files::getTemplate('breadcrumb', true, ['breadcrumb' => $data->getBreadcrumb()], __DIR__ . '/'); ?>
</nav>
<div class="general__block">
    <?php Pupuga\Libs\Files\Files::getTemplate('present', true, ['data' => $data->getLevelData()], __DIR__ . '/'); ?>
</div>
<div class="general__block general__block--level-list">
    <section class="lessons-list">
        <?php echo $params->getLoop($data->getLoopData()) ?>
    </section>
</div>
<?php if(\Pupuga\Modules\Calicosources\User::app()->isFreePlanUser()) : ?>
<div class="template template--free-trial-denied"><?php Pupuga\Libs\Files\Files::getTemplatePupuga('denied', true); ?></div>
<?php endif ?>