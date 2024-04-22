<?php

namespace Pupuga\Modules\Samplesources;

use Pupuga\Libs\Send;

final class Subscribers
{
    private static $instance;
    private $subscriber = array();
    private $config;
    private $url;

    public static function app($config = array())
    {
        if (self::$instance == null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function __construct($config)
    {
        $this->config = $config;
        $this->hook();
    }

    private function checkSubscriber()
    {
        $result = filter_var($this->subscriber['email'], FILTER_VALIDATE_EMAIL);

        return $result;
    }

    private function hook()
    {
        add_action('wp_ajax_setSubscriber', array($this, 'setSubscriber'));
        add_action('wp_ajax_nopriv_setSubscriber', array($this, 'setSubscriber'));
    }

    public function setSubscriber()
    {
        if (is_object($this->config) && count($this->config)
            && isset($_POST['fields']['email']) && is_string($_POST['fields']['email']) && !empty($_POST['fields']['email'])
            && is_string($_POST['fields']['name'])) {
            $this->subscriber  = array(
                'email' => substr($_POST['fields']['email'],0, 255),
                'name' => substr($_POST['fields']['name'],0, 255),
                'page' => substr($_POST['page'],0, 255)
            );
            if ($this->checkSubscriber()) {
                $this
                    ->generateUrl()
                    ->prepareTemplateText()
                    ->sendMail();
            }
        }
    }

    private function generateUrl()
    {
        $args = [
            'secret' => md5( $this->subscriber['email']. $this->config->privatekey),
            'subscribername' => $this->subscriber['name'],
            'subscriberemail' => $this->subscriber['email']
        ];

        $this->url = add_query_arg($args, home_url('/' . $this->subscriber['page'] . '/'));

        return $this;
    }

    private function prepareTemplateText()
    {
        $args = array(
            'link' => "<a href='{$this->url}'>Click the link</a>"
        );
        foreach ($args as $key => $value) {
            $this->config->mailtext = str_replace("%%{$key}%%", "{$value}", $this->config->mailtext);
        }

        return $this;
    }

    private function sendMail()
    {
        Send\Send::app(array($this->subscriber['email']), $this->config->mailsubject, $this->config->mailtext)->mail();
        echo 'success';
        exit;
    }
}