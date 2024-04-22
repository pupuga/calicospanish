<?php

namespace Pupuga\Core\Init;

use Pupuga\Config;
use Pupuga\Core\Base\Common;
use Pupuga\Libs\Files;

class Init extends Config
{
    public function __construct()
    {
        parent::__construct();

        $this->vendorLoad();

        Common::app()->config = $this->config;
        Files\Classes::launchClasses(
            $this->getInitClasses(),
            __NAMESPACE__
        );

    }

    private function vendorLoad()
    {
        Files\Files::getFile('vendor/autoload.php', true, [], __DIRFRAMEWORK__);
    }

    private function getInitClasses()
    {
        switch ($this->config['mode']) {
            case 'theme':
                $classes = array('SetCommon', 'Correct', 'Media', 'SetConfig', 'PageMain', 'PageLogin', 'PageAdmin', 'Modules');
                break;
            case 'modules':
                $classes = array('SetCommon', 'Media', 'SetConfig', 'PageMain', 'PageAdmin', 'Modules');
                break;
            case 'restapi':
                $classes = array('SetCommon', 'Correct', 'Media', 'SetConfig', 'PageLogin', 'PageAdmin', 'Modules');
                break;
            default:
                $classes = $this->config['mode'];
                break;
        }

        return $classes;
    }
}

new Init();