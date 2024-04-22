<?php if (is_array($params->data) && count($params->data) > 0) : ?>
    <div class="pupuga-list-block pupuga-list-block--tags">
        <h3>Popular Tags</h3>
        <ul class="pupuga-cloud">
            <?php foreach ($params->data as $item) : ?>
                <li class="pupuga-cloud__item"><a class="pupuga-cloud__link" href="<?php echo get_term_link($item->term_id) ?>"><?php echo $item->name ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
<?php endif ?>