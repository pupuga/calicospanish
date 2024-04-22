<main class="general__main">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post() ?>
            <?php $content = trim(Pupuga\Libs\Data\Html::transformHtml(apply_filters('the_content', get_the_content()))) ?>
            <?php if (!empty($content)) :?>
                <article class="general__section general__section--post-content"><?php echo $content ?></article>
            <?php endif ?>
        <?php endwhile ?>
    <?php endif ?>
    <?php echo Pupuga\Core\Load\Sections::app()->getSections('sections_loop') ?>
</main>