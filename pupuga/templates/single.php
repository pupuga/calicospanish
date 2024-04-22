<div class="general__main">
    <?php if (have_posts()) : ?>
        <?php echo Pupuga\Core\Load\Sections::app()->getSections('sections_loop', 'blog') ?>
    <?php endif ?>
</div>
<div class="general__content general__content--sidebar">
    <main class="general__main general__main--sidebar general__main--single-sidebar">
        <article class="pupuga-single">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post() ?>
                    <?php $id = get_the_ID() ?>
                    <div class="pupuga-single__meta">
                        <div class="pupuga-single__taxonomies">
                            <?php echo Pupuga\Modules\Blog\Taxonomies::getCategories($id) . Pupuga\Modules\Blog\Taxonomies::getTags($id) ?>
                        </div>
                        <div class="pupuga-single__posted">
                            by <?php echo ucfirst(get_the_author_meta('display_name')) ?> on <?php echo (new DateTime(get_the_date()))->format("M j, Y") ?>
                        </div>
                    </div>
                    <div class="pupuga-single__title"><h1><?php the_title() ?></h1></div>
                    <div class="pupuga-single__content">
                        <?php the_content() ?>
                    </div>
                <?php endwhile ?>
            <?php endif ?>
        </article>
        <div class="pupuga-author-wrapper">
            <div class="pupuga-author">
                <div class="pupuga-author__media">
                    <div class="pupuga-author__image">
                        <?php
                        $imageId = carbon_get_user_meta(get_the_author_meta('ID'), 'pupuga_avatar');
                        if (intval($imageId) > 0) {
                            echo wp_get_attachment_image($imageId, 'full');
                        }
                        ?>
                    </div>
                </div>
                <div class="pupuga-author__description">
                    <div class="pupuga-author__name"><?php echo ucfirst(get_the_author_meta('display_name')) ?></div>
                    <div class="pupuga-author__about"><?php echo get_the_author_meta('description') ?></div>
                </div>
            </div>
        </div>
        <div class="pupuga-comments"><?php comments_template() ?></div>
    </main>
    <?php Pupuga\Libs\Files\Files::getTemplatePupuga('sidebar', true, array('sidebar' => 'blog-sidebar')) ?>
</div>
