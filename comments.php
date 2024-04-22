<?php if (post_password_required()) return ?>

<h3 class="pupuga-comments__title"> <?php comments_number('No Comments', 'One comment', '% Comments') ?></h3>
<?php if (have_comments()) : ?>
    <ul class="pupuga-comments__list">
        <?php wp_list_comments(array(
            'avatar_size' => 69,
            'per_page' => 9999,
            'page' => 1
        )) ?>
    </ul>
<?php endif; ?>
<?php
comment_form(array(
    'comment_notes_before' => '',
    'title_reply' => 'Leave a Comment'
))
?>
