<?php

namespace Pupuga\Modules\Gdpr;

use Pupuga\Libs\Files\Files;

final class Init
{
    private $content;

    public function __construct()
    {
        if (!$this->getCookie()) {
            $this->content = carbon_get_theme_option( 'common_pupuga_configuration_gdpr_text' );
            $this->echo();
        }
    }

    public function echo()
    {
        echo $this->getTemplate();
    }

    private function getTemplate()
    {
        $template = Files::getTemplate('gdpr', false, array('html' => $this->content), __DIR__. '/templates/');

        return $template;
    }

    private function getCookie()
    {
        $result = (isset($_COOKIE['gdpr']) && $_COOKIE['gdpr'] == '1');

        return $result;
    }

}