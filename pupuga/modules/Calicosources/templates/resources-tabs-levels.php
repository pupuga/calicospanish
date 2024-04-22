<?php if (count($params['tabs']) > 0) : ?>
    <ul class="source-levels">
        <?php foreach ($params['tabs'] as $tab) : $link = home_url("{$params['slug']}/?type={$params['type']}&level={$tab->slug}") ?>
            <li class="source-levels__item<?php if($tab->slug == $params['level']) :?> source-levels__item--active<?php endif ?>"><a class="source-levels__link<?php if($tab->slug == $params['level']) :?> source-levels__link--active<?php endif ?>" href="<?php echo $link ?>"><?php echo $tab->name ?></a></li>
        <?php endforeach ?>
    </ul>
<?php endif ?>