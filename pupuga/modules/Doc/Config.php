<?php

namespace Pupuga\Modules\Doc;

/**
 *  Example of using
 *
 *  create file doc.html in main directory
 *  you have to add method doc and put into code like bellow
 *
 *  (new \Pupuga\Modules\Doc\TemplateProperty)
 *      ->setTitle('Module name')
 *      ->setDescription('Module descripton')
 *      ->setDocumentation(__DIR__ . '/doc.html')
 *
 */

class Config
{
    public static $instance;

    /**
     *  array(
     *      'title' => 'Title',
     *      'description' => 'Description',
     *      'file' => 'file'
     *  )
     */
    private $config = array(
/*        array(
            'title' => 'Title',
            'description' => 'Description',
            'file' => 'file name'
        )*/
    );

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConfig()
    {
        return $this->config;
    }
}