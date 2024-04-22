<?php

namespace Pupuga\Modules\RestApi;

use Pupuga\Core\Base\Common;
use Pupuga\Libs\Data\Url;

class Init
{
    /**
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function __construct()
    {
        if (!is_admin() && Url::getPath()[0] !== 'wp-login.php') {
            $this->setConfig()
                ->loadMode();
        }
    }

    private function setConfig()
    {

        $restApi = Common::app()->common['configuration_parameters']->restapi;
        $restApiServer = $restApi->server->attributes();
        if (strval($restApiServer->switch) === 'on') {
            Params::app()->server = true;
            Params::app()->serverMode = strval(trim($restApiServer->mode));
            Params::app()->serverKeys = (array)$restApi->server->key;
        } else {
            Params::app()->server = false;
        }

        return $this;
    }

    /**
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    private function loadMode()
    {
        if (Params::app()->getConfig()->server) {
            if ($this->isRestApiUrl()) {
                Server::app()->getRequest();
            } else {
                if (Params::app()->getConfig()->serverMode === 'alone') {
                    Server::app()->getRequest();
                }
            }
        }

        return $this;
    }

    /**
     * @return bool $result
     */
    private function isRestApiUrl()
    {
       $result = (Url::getPath()[0] === Params::app()->getConfig()->name);

       return $result;
    }
}
