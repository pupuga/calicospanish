<?php

namespace Pupuga\Modules\Sitemap;

final class Actions
{
    private $action;
    private $xml;
    private $list;
    private $columns;

    public function __construct()
    {
        add_action('wp_ajax_map', array($this, 'tasks'));
    }

    public function tasks()
    {
        $this->list = Data::app()->getList();
        $this->columns = Data::app()->getColumns();
        $options = $this->saveCustomChanges();
        $this->xml = (new XmlTemplates($this->list, $this->columns, $options))->getXml();
        $this->action();

    }

    private function saveCustomChanges()
    {
        $options = array();
        $options['excluded'] =(isset($_POST['excluded']) && !empty($_POST['excluded'])) ? json_decode($_POST['excluded']) : '';
        $options['changed'] = (isset($_POST['changed']) && !empty($_POST['changed'])) ? json_decode(str_replace('\\', '', $_POST['changed'])) : '';

        update_option('pupuga_sitemap', $options);

        return $options;
    }

    private function action()
    {
        $method = $this->action = strtolower($_POST['type']);
        if (method_exists($this, $method)) {
            $this->$method();
        }

        exit;
    }

    private function generate()
    {
        echo $this->xml;
    }

    private function save()
    {
        $path = get_home_path();
        $file = $path . '/sitemap.xml';
        $result = file_put_contents($file, $this->xml);
        $result = ($result === false) ? 'error' : 'save';

        echo $result;
    }
}