<?php

namespace Pupuga\Modules\Sitemap;

use Pupuga\Core\Options;

final class Init
{
    public $content;
    public $types;
    public $list;
    public $options;
    public $columns;

    public function __construct()
    {
        if (is_admin()) {
            $this->adminArea();
        }
    }

    private function adminArea()
    {
        $this->content = Data::app()->getContent();
        $this->columns = Data::app()->getColumns();
        $this->types = Data::app()->getTypes();
        $this->list = Data::app()->getList();
        $this->options = Data::app()->getOptions();
        $this->createPage();
        $this->actions();
    }

    private function createPage()
    {
        new Options\OptionPage(
            array(
                'type' => 'submenu',
                'parent' => 'tools.php',
                'title' => 'Sitemap'
            ),
            __DIR__.'/templates/admin',
            $this
        );
    }

    private function actions()
    {
        new Actions();
    }
}