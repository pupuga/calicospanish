<?php
/**
 * @var Pupuga\Modules\Calicosources\Init $params
 * @var Pupuga\Modules\Calicosources\Sources $data
 */
?>
<?php $breadcrumb = $params['breadcrumb'] ?>

<ul class="breadcrumb">
    <?php for ($i = 0; $i < count($breadcrumb); $i++) : ?>
        <li class="breadcrumb__item">
            <?php if ($i == 0) : ?>
                <a href="<?php echo home_url($breadcrumb[$i]['link']) ?>" class="breadcrumb__title breadcrumb__title--link <?php echo $breadcrumb[$i]['class'] ?: '' ?>"><?php echo $breadcrumb[$i]['name'] ?></a>
            <?php elseif (isset($breadcrumb[$i]['link'])) : ?>
                <span class="breadcrumb__arrow">></span><a href="<?php echo home_url($breadcrumb[$i]['link']) ?>" class="breadcrumb__title breadcrumb__title--link <?php echo $breadcrumb[$i]['class'] ?: '' ?>"><?php echo $breadcrumb[$i]['name'] ?></a>
            <?php else : ?>
                <span class="breadcrumb__arrow">></span><span class="breadcrumb__title"><?php echo $breadcrumb[$i]['name'] ?></span>
            <?php endif ?>
        </li>
    <?php endfor ?>
</ul>