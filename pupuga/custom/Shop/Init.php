<?php

namespace Pupuga\Custom\Shop;

use Pupuga\Libs\Files\Files;

class Init {

    const SHOP_TEMPLATE_DIR = __DIR__ . '/templates/';
    private $classes = ['Subscription', 'Memberships', 'Cart', 'Page', 'Account'];

    public function __construct()
    {
        $this->requireClasses();
    }

    private function requireClasses()
    {
        foreach ($this->classes as $class) {
            $class = __NAMESPACE__ . '\\' . $class;
            new $class($this);
        }
    }

    public function getTemplate($template, $params = [], $echo = false)
    {
        $template = Files::getTemplate($template, $echo, $params, self::SHOP_TEMPLATE_DIR);

        return $template;
    }
}

new Init();