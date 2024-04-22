<?php
/**
 * @var Pupuga\Modules\Calicosources\Init $params
 * @var Pupuga\Modules\Calicosources\Resources $data
 */
?>

<?php $data = $params->data ?>

<nav class="general__block general__block--level-header">
    <?php Pupuga\Libs\Files\Files::getTemplate('breadcrumb', true, ['breadcrumb' => $data->getBreadcrumb()], __DIR__ . '/'); ?>
</nav>
<div class="general__block">
    <div class="block-present">
        <h1 class="block-present__title">Resources</h1>
    </div>
</div>
<div class="general__block">
    <div class="resources-data">
        <nav class="resources-data__tabs">
            <?php Pupuga\Libs\Files\Files::getTemplate('resources-tabs-types', true, ['tabs' => $data->getTypes(), 'slug' => $data->getSlug(), 'type' => $data->getRequestParams('type')], __DIR__ . '/'); ?>
        </nav>
        <div class="resources-data__header">
            <h3 class="resources-data__title"><?php echo $data->getCurrentType() ?></h3>
            <div class="resources-data__filter">
                <div class="resources-data__filter-title">FILTER BY LEVEL</div>
                <nav class="resources-data__filter-menu">
                    <?php Pupuga\Libs\Files\Files::getTemplate('resources-tabs-levels', true, ['tabs' => $data->getLevels(), 'slug' => $data->getSlug(), 'type' => $data->getRequestParams('type'), 'level' => $data->getRequestParams('level')], __DIR__ . '/'); ?>
                </nav>
            </div>
        </div>
        <?php if ($data->getAccess()) : ?>
            <?php $content = $data->getContent() ?>
            <?php if (!empty($content)) : ?>
                <div class="resources-data__additional-content"><?php echo $content ?></div><?php endif ?>
            <div class="resources-data__content">
                <?php Pupuga\Libs\Files\Files::getTemplate('resources-list', true, ['resources' => $data->getResources(), 'params' => $data->getParams()], __DIR__ . '/'); ?>
            </div>
        <?php else : ?>
            <?php Pupuga\Libs\Files\Files::getTemplatePupuga('denied', true); ?>
        <?php endif ?>
    </div>
</div>