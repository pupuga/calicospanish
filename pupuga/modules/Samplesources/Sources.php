<?php

namespace Pupuga\Modules\Samplesources;

use Pupuga\Libs\Curl\MailChimp;
use \Pupuga\Core\Base\Common;

final class Sources
{
    private static $instance;
    private $config;
    private $slug;
    private $queryParams;

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
        add_action('init', array( $this, 'hook'));
    }

    public function hook()
    {
        $urlParts = parse_url($_SERVER['REQUEST_URI']);
        $slugs = array_map('trim', explode(',', $this->config->pages));
        $this->slug = trim($urlParts['path'], "/");
        if (in_array($this->slug, $slugs)) {
            parse_str($urlParts['query'], $this->queryParams);
            if ($this->checkKey()) {
                $this->queryParams = array(
                    'name' => substr($this->queryParams['subscribername'], 0, 255),
                    'email' => $this->queryParams['subscriberemail']
                );
                $this->saveSubscriberIntoMailChimp();
            } else {
                wp_redirect(home_url($this->config->redirect));
                exit;
            }
        }
    }

    private function checkKey()
    {
        $hash = md5( $this->queryParams['subscriberemail'] . $this->config->privatekey);

        return $hash === $this->queryParams['secret'];
    }

    private function saveSubscriberIntoMailChimp()
    {
        $mailChimpKey = strval(Common::app()->common['configuration_parameters']->mailchimp->attributes()->key);
        $mailChimp = MailChimp::app($mailChimpKey);
        $mailChimp->addSubscriber($this->config->mailchimplists, $this->queryParams['email'], $this->queryParams['name'], '');
    }
}