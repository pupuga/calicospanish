<?php

namespace Pupuga\Core\Load;

use Pupuga\Libs\Files;
use Pupuga\Libs\Data\Html;

class Sections
{

    public static $instance;

    /**
     * @return $this
     */
    static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

    public function getSections($slug, $postSlug = null)
    {
        $html = '';
        if (!is_null($postSlug)) {
            $args = array(
                'name' => $postSlug,
                'post_type' => 'page',
                'post_status' => 'publish',
                'numberposts' => 1
            );
            $post = get_posts($args);
            $postSlug = isset($post[0]->ID) ? $post[0]->ID : null;
        }
        $sections = (is_null($postSlug)) ? carbon_get_the_post_meta($slug) : carbon_get_post_meta($postSlug, $slug);
        if (is_array($sections) && count($sections) > 0) {
            foreach ($sections as $section) {
                $htmlSubsections = '';
                $subsections = $section['subsections_loop'];
                if (is_array($subsections) && count($subsections) > 0) {
                    foreach ($subsections as $subsection) {
                        $htmlSubsections .= Files\Files::getTemplatePupuga('subsection', false, $subsection);
                    }
                }
                if ($htmlSubsections) {
                    $section['htmlSubsections'] = $htmlSubsections;
                    $html .= Files\Files::getTemplatePupuga('section', false, $section);
                }
            }
        }

        return $html;
    }
}