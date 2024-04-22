<?php if (is_array($params->data) && count($params->data) > 0) : ?>
    <div class="pupuga-list-block pupuga-list-block--categories">
        <h3>Categories</h3>
        <ul class="pupuga-list-tree pupuga-list-tree--categories">
            <?php foreach ($params->data as $category) : ?>
                <li><a href="<?php echo get_term_link($category->term_id) ?>"><?php echo $category->name ?></a><span>(<?php echo $category->count ?>)</span></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>
