<?php

namespace Pupuga\Modules\Amp;

class Init
{
    public $version = 1.2;
    private $lang = 'no';
    private $timeZone = '+01:00';
    private $amp = array(
        'type' => array(
            'page' => 'default',
            'post' => 'default',
        ),
        'exchange' => array(
            //'kryptovaluta' => 'cryptocurrency'
        )
    );
    private $twitter;
    private $google = array(
        'account' => 'UA-114124643-2',
        'pageview' => true
    );

    function __construct()
    {
        $requestUri = urldecode($_SERVER['REQUEST_URI']);
        $request = explode('/', trim($requestUri, '/'));
        if ($request[count($request) - 1] === 'amp') {
            add_action('template_include', array(PageAmp::app($this), 'init'));
        } else {
            add_action('wp_head', array(PageDonor::app($this), 'init'));
        }
    }

    public function getAmp($name = null)
    {
        if (is_null($name) || !isset($this->amp[$name])) {
            $result = $this->amp;
        } else {
            $result = $this->amp[$name];
        }

        return $result;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function getTimeZone()
    {
        return $this->timeZone;
    }

    public function getTwitter()
    {
        return $this->twitter;
    }

    public function getExchange()
    {
        return $this->amp['exchange'];
    }

    public function getGoogleAccount()
    {
        return $this->google['account'];
    }

    public function getGooglePageview()
    {
        return $this->google['pageview'];
    }
}
