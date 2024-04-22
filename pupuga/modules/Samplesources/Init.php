<?php

namespace Pupuga\Modules\Samplesources;

use Pupuga\Core\Base;
use Pupuga\Libs\Files;

final class Init extends Base\Controller
{
    private $config;

    public function __construct($pathTemplates = null)
    {
        if (!is_admin() || wp_doing_ajax()) {
            parent::__construct($pathTemplates);
            $this->config = new \stdClass();
            $this->getConfig(Base\Common::app()->common['configuration_parameters']->samplesources);
            Subscribers::app($this->config);
            Sources::app($this->config);
        }
    }

    public function shortCode($atts, $content = null)
    {
        add_action('main_content_bottom', array($this, 'echoForm'));
        return parent::shortCode($atts, $content);
    }

    public function echoForm()
    {
        echo $this->getForm();
    }

    public function getImage()
    {
        return wp_get_attachment_image_src($this->config->img, 'full');
    }

    public function getHeader()
    {
        return $this->config->texthi;
    }

    public function getButtonText()
    {
        return $this->config->textbutton;
    }

    public function getThx()
    {
        return $this->config->textthx;
    }

    protected function getForm()
    {
        $html = Files\Files::getTemplate('form', false, $this, __DIR__ . '/templates/');

        return $html;
    }

    private function getConfig($nodes)
    {
        $attributes = $nodes->attributes();
        $children = $nodes->children();
        if (count($attributes)) {
            foreach ($attributes as $node) {
                $this->config->{strval($node->getName())} = strval($node);
            }
        }
        if (count($children)) {
            foreach ($children as $node) {
                $this->config->{strval($node->getName())} = strval($node);
            }
        }
    }

    protected function boot()
    {
        return;
    }

    protected function doc()
    {
    }
}