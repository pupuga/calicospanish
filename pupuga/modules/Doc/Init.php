<?php

namespace Pupuga\Modules\Doc;

use Pupuga\Core\Options;
use Pupuga\Core\Load;

class Init
{
    public $name = 'doc';

    function __construct()
    {
        $this->getConfig();
        $this->setConstants();
        $this->createPage();
        $this->requireStylesScripts();
    }

    private function getConfig()
    {
        $config = Config::app()->getConfig();
        if (is_array($config) && count($config) > 0) {
            foreach ($config as $row) {
                Template::app()->setDocModule(
                    (new TemplateProperty)
                        ->setTitle($row['title'])
                        ->setDescription($row['description'])
                        ->setDocumentation(__DIR__ . '/documentation/' . $row['file'] . '.html')
                );
            }
        }
    }

    private function setConstants()
    {
        define('__DIR_MOD_DOC__', __DIRMODULES__ . ucfirst($this->name) . '/');
        define('__URL_MOD_DOC__', __URLMODULES__ . $this->name . '/');
        define('__DIR_MOD_DOC_TEMPLATES__', __DIR_MOD_DOC__ . 'templates/');
    }

    private function createPage()
    {
        new Options\OptionPage(
            array(
                'type' => 'submenu',
                'parent' => 'tools.php',
                'title' => 'Modules doc'
            ),
            __DIR_MOD_DOC_TEMPLATES__ . 'page',
            Template::app()->getDocModules()
        );
    }

    private function requireStylesScripts()
    {
        if (is_admin()) {
            $enqueues = array(
                'styles' => array(
                    'style-admin-' . $this->name => 'admin' . $this->name . '.css'
                ),
                'scripts' => array(
                    'script-admin-' . $this->name => 'admin' . $this->name . '.js'
                )
            );
            Load\StylesScripts::app()->requireStylesScripts($enqueues);
        }
    }
}