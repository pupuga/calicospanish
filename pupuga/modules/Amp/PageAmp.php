<?php

namespace Pupuga\Modules\Amp;

use Pupuga\Libs\Files;

class PageAmp extends Page
{
    /**
     * @param Init $object
     *
     * @return $this
     */
    public static function app(Init $object = null)
    {
        if (self::$instance == null) {
            self::$instance = new self($object);
        }

        return self::$instance;
    }

    public function init()
    {
        $url = $this->clearAmpUrl();
        $id = url_to_postid(home_url() . $url);
        if (!$id) {
            wp_redirect(home_url());
            exit();
        }
        $this->setItemObject($id);
    }

    protected function action()
    {
        $this->getTemplate();
    }

    protected function getTemplate()
    {
        status_header('200');
        $this->post->lang = 'en';
        $this->post->timeZone = $this->initObject->getTimeZone();
        $this->post->twitter = $this->initObject->getTwitter();
        $this->post->googleAccount = $this->initObject->getGoogleAccount();
        $this->post->googlePageview = $this->initObject->getGooglePageview();
        $this->post->template = $this->template;
        $class = __NAMESPACE__ . '\get' . ucfirst($this->template) . 'Params';
        $params = new $class($this->post);
        Files\Files::getTemplate('index', true, $params, __DIR__ . '/templates/' . $this->template . '/');
    }
}