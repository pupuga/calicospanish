<div class="block-present block-present--<?php echo $params['data']->levelStyle ?>">
    <h1 class="block-present__title block-present__title--<?php echo $params['data']->levelStyle ?>"><?php echo $params['data']->title ?><?php if(!empty($params['data']->title_plus)) :?> <span class="block-present__title-plus">(<?php echo $params['data']->title_plus ?>)</span><?php endif ?></h1>
    <?php if(!empty($params['data']->description)) :?>
        <div class="block-present__text block-present__text--<?php echo $params['data']->levelStyle ?>"><p><?php echo $params['data']->description ?></p></div>
    <?php endif ?>
</div>