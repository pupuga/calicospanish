<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Base\Common;
use Pupuga\Libs\Files;

class Modules
{
    public function __construct()
    {
        $this->launchModules();
    }

    private function launchModules()
    {
        $namespace = explode('\\', __NAMESPACE__);
        Files\Classes::launchClasses(Common::app()->config['modules'], $namespace[0] . '\Modules', 'Init');
    }
}