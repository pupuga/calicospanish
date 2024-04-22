<?php if (count($params['tabs']) > 0) : ?>
    <ul class="source-tabs">
        <?php foreach ($params['tabs'] as $tab) :  $link = home_url("{$params['slug']}/?type={$tab->slug}")?>
            <li class="source-tabs__item<?php if($tab->slug == $params['type']) :?> source-tabs__item--active<?php endif ?>"><a class="source-tabs__link" href="<?php echo $link ?>"><span class="source-tabs__icon"><img src="<?php echo $tab->slug == $params['type'] ? $tab->iconColor : $tab->iconGray ?>"></span><span class="source-tabs__label"><?php echo str_replace(' (Resources)', '', $tab->name) ?></span></a></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
