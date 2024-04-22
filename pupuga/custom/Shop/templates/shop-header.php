<div class="shop-header">
    <div class="shop-header__title"><h1><?php echo $params['title'] ?></h1></div>
    <?php if(isset($params['categories']) && count($params['categories']) > 0) : ?>
    <div class="shop-header_categories">
        <ul class="categories-list">
            <li class="categories-list__item"><a class="categories-list__link<?php if(is_shop()) :?> categories-list__link--active<?php endif ?>" href="<?php the_permalink(wc_get_page_id('shop')) ?>">All Products</a></li>
            <?php foreach ($params['categories'] as $category) : ?>
            <li class="categories-list__item"><a class="categories-list__link<?php if($category->slug == $params['current-category']) :?> categories-list__link--active<?php endif ?>" href="<?php echo get_term_link($category->term_id, 'product_cat')?>"><?php echo $category->name ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
    <?php endif ?>
</div>