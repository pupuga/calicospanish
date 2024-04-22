<?php

namespace Pupuga\Modules\Blog;

class Hooks
{
    public static $instance;

    /**
     * @return $this
     */
    public static function app()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'addCommentJS'));
        add_filter('get_avatar', array($this, 'setAvatar'), 10, 5);
        add_filter('get_comment_date', array($this, 'setCommentDate'));
        add_filter('get_comment_time', array($this, 'setCommentTime'));
        add_filter('gettext', array($this, 'setBlockUserName'), 10, 4);
        add_filter('comment_form_fields', array($this, 'setCommentsFields'));
        add_filter('comment_form_logged_in', '__return_empty_string');
        add_action('pre_get_posts', array($this, 'correctSearchQuery'));
    }

    public function addCommentJS()
    {
        if ( is_singular() && comments_open() && get_option('thread_comments') ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }

    public function setAvatar($html, $commentObject, $size, $default, $alt)
    {
        if ($commentObject->user_id > 0 && !empty($commentObject->user_id)) {
            $userId = intval($commentObject->user_id);
            $imageId = carbon_get_user_meta($userId, 'pupuga_avatar');
            if (intval($imageId) > 0) {
                $html = wp_get_attachment_image($imageId, 'full');
            }
        };

        return $html;
    }

    public function setBlockUserName($translation, $text, $domain)
    {
        $translations = &get_translations_for_domain($domain);
        if (strpos($text, '<span class="says">says:</span>') > 0) {
            return $translations->translate('%s');
        } else {
            return $translation;
        }
    }

    public function setCommentDate($date)
    {
        $date = (new \DateTime($date))->format('d.m.Y');

        return $date;
    }

    public function setCommentTime($time)
    {
        $time = (new \DateTime($time))->format('H:i');

        return $time;
    }

    public function setCommentsFields($fields)
    {
        $commenter = wp_get_current_commenter();
        if(isset($fields['url'])) unset($fields['url']);
        if(isset($fields['comment'])) unset($fields['comment']);
        $fields['author'] = '<div class="pupuga-comment__form-field pupuga-comment__form-field--author"><input id="author" name="author" type="text" placeholder="Full Name" value="' . esc_attr($commenter['comment_author']) . '" size="30" required="required"></div>';
        $fields['email'] = '<div class="pupuga-comment__form-field pupuga-comment__form-field--email"><input id="email" name="email" type="text" placeholder="Email Address" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required="required"></div>';
        $fields['comment'] = '<div class="pupuga-comment__form-field pupuga-comment__form-field--text"><textarea id="comment" name="comment" cols="45" rows="8" placeholder="Message" required="required"></textarea></div>';

        return $fields;
    }

    public function correctSearchQuery($query) {
        if(is_admin()) {
            return;
        }

        if(is_search() && $query->is_main_query() ) {
            $query->set('post_type', 'post');
        }
    }

}