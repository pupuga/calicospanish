<?php

namespace Pupuga\Modules\Blocks;

use Pupuga\Core\Carbon;
use Pupuga\Core\Posts\GetPosts;
use Pupuga\Libs\Files;

class Data
{
    private $data;
    private $block;

    public function __construct(Init $block)
    {
    	$this->block = $block;
	    $data = new \stdClass();
        $data->post = $this->getPost($block->atts['name']);
        $data->meta = $this->getPostMeta($data->post->ID);
        $data->modules = $this->getRow($data->meta->rows);
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    private function getPost($name)
    {
        $posts = get_page_by_title($name, 'OBJECT','blocks');

        if ($posts->post_status != 'publish') {
            $posts = null;
        };

        return $posts;
    }

    private function getPostMeta($id)
    {
        $meta = Carbon\Helper::getPostMeta(
            $id,
            array('block_class', 'block_style', 'rows')
        );

        return $meta;
    }

    private function getRow($objects)
    {
        $html = '';
        foreach ($objects as $object) {
            $object['modules'] = $this->getModules($object);
            $html .= Files\Files::getTemplate('row', false, $object, __DIR__ . '/templates/');
        }

        return $html;
    }

    private function getModules($object)
    {
        $html = '';
        foreach ($object['modules'] as $module) {
            if (isset($module['field_type']) && !empty($module['field_type'])) {
                $template = substr($module['field_type'],5);
            } else {
                $template = $module['_type'];
            }
            $html .= Files\Files::getTemplate($template, false, array('html' => $module[rtrim($module['_type'], 's')], 'module' => $module, 'block' => $this->block) , __DIR__ . '/templates/');
        }

        return $html;
    }

}