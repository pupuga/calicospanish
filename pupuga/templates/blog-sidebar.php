<div class="general__page-with-sidebar">
    <div class="general__main">
        <?php if (have_posts()) : ?>
            <?php echo Pupuga\Core\Load\Sections::app()->getSections('sections_loop', 'blog') ?>
        <?php endif ?>
    </div>
    <div class="general__content general__content--sidebar">
        <main class="general__main general__main--sidebar">
            <div class="pupuga-posts">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post() ?>
                        <?php $id = get_the_ID() ?>
                        <article class="pupuga-posts__article">
                            <div class="pupuga-posts__main">
                                <div class="pupuga-posts__media">
                                    <a href="<?php the_permalink() ?>" class="pupuga-posts__permalink pupuga-posts__permalink--media">
                                        <div class="pupuga-posts__date">
                                            <?php $date = new DateTime(get_the_date()) ?>
                                            <div class="pupuga-posts__date-format">
                                                <div class="pupuga-posts__day"><?php echo $date->format("d") ?></div>
                                                <div class="pupuga-posts__month-year"><?php echo $date->format("M'y") ?></div>
                                            </div>
                                        </div>
                                        <?php $thumbnail = get_the_post_thumbnail() ?>
                                        <div class="pupuga-posts__image<?php if (!empty($thumbnail)): ?> pupuga-posts__image--with<?php else: ?> pupuga-posts__image--without<?php endif ?>">
                                            <?php if (!empty($thumbnail)) : ?>
                                                <?php the_post_thumbnail('400x400') ?>
                                            <?php else : ?>
                                                <img src="<?php echo __URLASSETS__ . 'resources-thumbnail.png' ?>" title="" alt="">
                                            <?php endif ?>
                                        </div>
                                    </a>
                                </div>
                                <div class="pupuga-posts__content">
                                    <div class="pupuga-posts__title">
                                        <a href="<?php the_permalink() ?>" class="pupuga-posts__permalink">
                                            <h3><?php the_title() ?></h3>
                                        </a>
                                    </div>
                                    <div class="pupuga-posts__meta-helpers">
                                        <div class="pupuga-posts__author"><?php echo ucfirst(get_the_author_meta('display_name')) ?></div>
                                        <div class="pupuga-posts__comments-count">
                                            <?php $comments = wp_count_comments($id) ?>
                                            <?php echo $comments->approved ?>
                                            comment<?php if ($comments->approved !== 1) : ?>s<?php endif ?>
                                        </div>
                                    </div>
                                    <div class="pupuga-posts__excerpt"><?php the_excerpt() ?></div>
                                </div>
                            </div>
                            <div class="pupuga-posts__bottom">
                                <div class="pupuga-posts__taxonomies">
                                    <?php $html = Pupuga\Modules\Blog\Taxonomies::getCategories($id) ?>
                                    <?php if (!empty($html)) : ?>
                                        <div class="pupuga-posts__categories">
                                            <div class="pupuga-line-list">
                                                <div class="pupuga-line-list__title">Categories:</div>
                                                <div class="pupuga-line-list__items"><?php echo $html ?></div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                    <?php $html = Pupuga\Modules\Blog\Taxonomies::getTags($id) ?>
                                    <?php if (!empty($html)) : ?>
                                        <div class="pupuga-posts__tags">
                                            <div class="pupuga-line-list">
                                                <div class="pupuga-line-list__title">Tags:</div>
                                                <div class="pupuga-line-list__items"><?php echo $html ?></div>
                                            </div>
                                        </div>
                                    <?php endif ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile ?>
                <?php else : ?>
                    <h3>We don't have posts with parameters of request.</h3>
                <?php endif ?>
            </div>
            <div class="pupuga-pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __(''),
                    'next_text' => __('')
                ))
                ?>
            </div>
        </main>
        <?php Pupuga\Libs\Files\Files::getTemplatePupuga('sidebar', true, array('sidebar' => 'blog-sidebar')) ?>
    </div>
</div>