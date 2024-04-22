<div class="wrap pupuga-wrapper">
    <h1 class="wp-heading-inline pupuga-title--module-doc">Modules and etc. documentation</h1>
    <i class="button expand__link-all fa fa-long-arrow-down" aria-hidden="true"></i>
    <?php if (count($params)) : ?>
        <div class="module-doc">
            <?php foreach ($params as $module) : ?>
                <div class="module-doc__item">
                    <div class="module-doc__header">
                        <?php if ($module->title) : ?>
                            <h3 class="module-doc__title"><?php echo $module->title ?></h3>
                        <?php endif ?>
                        <?php if ($module->description) : ?>
                            <div class="module-doc__description"><?php echo $module->description ?></div>
                        <?php endif ?>
                    </div>
                    <div class="module-doc__body expand__block display-none">
                        <div class="module-doc__documentation">
                            <?php echo $module->documentation ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php else : ?>
        <h3>We don`t have documentation</h3>
    <?php endif ?>
</div>