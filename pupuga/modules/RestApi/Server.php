<?php

namespace Pupuga\Modules\RestApi;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Pupuga\Core\Posts\GetPosts;
use Pupuga\Libs\Data\Url;

/**
 * @property string $version
 * @property string $postType
 * @property App $app
 */
class Server
{
    public static $instance;
    public $app;

    public function __construct()
    {
        $this->app = new App();
    }

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @throws \Slim\Exception\MethodNotAllowedException
     * @throws \Slim\Exception\NotFoundException
     */
    public function getRequest()
    {
        $this->version = 'version';
        $this->postType = 'posttype';

        $app = $this->app;
        $app->get('/' . Params::app()->getConfig()->name . '/{' . $this->version . '}/{' . $this->postType . '}/',
            function (Request $request, Response $response) {
                if (in_array($request->getParam('token'), Params::app()->getConfig()->serverKeys)) {
                    Server::app()->getPostsData($request);
                } else {
                    Message::app()->getMessageError('authorization');
                };
            }
        );

        $app->run();
        exit;
    }

    private function getPostsData($request)
    {
        header("Content-Type: application/json");
        echo json_encode($this->getData($request), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    private function getData($request)
    {
        $data = array(
            'token' => $request->getParam('token'),
            'posts' => $this->getPosts($request->getAttribute($this->postType))
        );

        return $data;
    }

    private function getPosts($postType)
    {
        $getPost = GetPosts::app()->postType($postType);
        $getQuery = Url::getQuery();
        if (is_array($getQuery) && count($getQuery) > 0) {
            foreach ($getQuery as $key => $value) {
                $getPost->$key($value);
            }
            $result = $getPost->doAction();
        } else {
            Message::app()->getMessageError('request');
        }
        if (!isset($result) || count($result) === 0) {
            $result['result'] = false;
        } else {
            $result['result'] = true;
        }

        return $result;
    }
}
