<?php

namespace Pupuga\Modules\Menu;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
    public function boot()
    {
        $data = array();

        $this->atts['enable'] = (isset($this->atts['type']) && !empty($this->atts['type']) && !empty($this->atts['name'])) ? $this->typeAction() : true;

        return $data;
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Menu')
            ->setDescription('Shortcode get Menu.')
            ->setDocumentation(__DIR__ . '/doc.html');
    }

    private function typeAction() : bool
    {
        $method = 'action' . ucfirst($this->atts['type']);
        if (method_exists($this, 'actionDependency')) {
            return $this->$method();
        } else {
            return false;
        }
    }

    private function actionDependency() : bool
    {
        global $post;
        $currentItem = $post->post_name;
        $menuItems = wp_get_nav_menu_items($this->atts['name']);
        $result = false;
        foreach ($menuItems as $menuItem) {
            if (sanitize_title($menuItem->title) == $currentItem) {
                $result = true;
                break;
            }
        }

        return $result;
    }

}
