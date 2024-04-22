<?php

namespace Pupuga\Core\Load;

class StylesScripts
{
    public static $instance;
    protected $enqueues;
    protected $dir = __DIRASSETS__;
    protected $url = __URLASSETSDIST__;

    /**
     * @return $this
     */
    static function app()
    {
        self::$instance = new self();
        return self::$instance;
    }

    /**
     * @return $this
     */
    public function setDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }


    public function requireFiles()
    {
        $enqueues = $this->enqueues;
        $dir = $this->dir;
        $url = $this->url;
        if (is_array($enqueues) && count($enqueues) > 0) {
            foreach ($enqueues as $type => $enqueue) {
                foreach ($enqueue as $name => $file) {
                    if (is_file($dir . $file)) {
                        switch ($type) {
                            case 'styles':
                                wp_enqueue_style($name, $url . $file, array(), VERSION);
                                break;
                            case 'scripts':
                                wp_enqueue_script($name, $url . $file, array(), VERSION, true);
                                break;
                        }
                    }
                }
            }
        }
    }

    public function requireStylesScripts($enqueues)
    {
        $this->enqueues = $enqueues;
        $this->requireFiles();
    }

    public function requireStylesScriptsIntoFooter($enqueues)
    {
        $this->enqueues = $enqueues;
        $priority = array();
        if (isset($enqueues['priority'])) {
            $priority['priority'] = $enqueues['priority'][0];
            $priority['accepted'] = $enqueues['priority'][1];
            unset($enqueues['priority']);
        } else {
            $priority['priority'] = 10;
            $priority['accepted'] = 1;
        }
        add_action('get_footer', array($this, 'requireFiles'), $priority['priority'], $priority['accepted']);
    }
}