<div class="pupuga-admin-page pupuga-admin-page--sitemap">
    <div class="pupuga-waiting display-none-force"><div class="pupuga-veil"></div><div class="pupuga-spinner"><img src="<?php echo get_admin_url() ?>/images/spinner-2x.gif" alt="" title=""></div></div>
    <h1 class="pupuga-admin-page__title"><?php echo $params->content['title'] ?></h1>
    <div class="pupuga-admin-page__messages"><?php Pupuga\Libs\Files\Files::getTemplate('admin-messages', true, [], __DIR__.'/') ?></div>
    <div class="pupuga-admin-page__color-edit"><?php Pupuga\Libs\Files\Files::getTemplate('admin-color-edit', true, [], __DIR__.'/') ?></div>
    <div class="pupuga-admin-page__manage"><?php Pupuga\Libs\Files\Files::getTemplate('admin-buttons', true, [],__DIR__.'/') ?></div>
    <div class="pupuga-admin-page__filter"><?php Pupuga\Libs\Files\Files::getTemplate('admin-filter', true, array('types' => $params->types), __DIR__.'/') ?></div>
    <div class="pupuga-admin-page__table display-none-force"><?php Pupuga\Libs\Files\Files::getTemplate('admin-table', true, array('columns' => $params->columns, 'list' => $params->list, 'options' => $params->options), __DIR__.'/') ?></div>
    <div class="pupuga-admin-page__manage"><?php Pupuga\Libs\Files\Files::getTemplate('admin-buttons', true, [],__DIR__.'/') ?></div>
</div>