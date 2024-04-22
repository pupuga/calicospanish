<?php

namespace Pupuga\Modules\Calicosources;

class Account {

    protected $userInfo;
    protected $user = array();
    protected $method;
    protected $atts;

    public function __construct($atts)
    {
        $this->atts = $atts;
        $this->userInfo = get_currentuserinfo();
        $this->setName();
        $this->setMethod();
    }

    protected function setName()
    {
        $userInfo = $this->userInfo;
        $this->user['userName'] = trim(ucfirst(isset($userInfo->user_firstname) ? $userInfo->user_firstname : ucfirst($userInfo->user_lastname)));
    }

    protected function setMethod()
    {
        $this->method = (isset($this->atts['get']) && !empty($this->atts['get'])) ? ucfirst($this->atts['get']) : 'Name';
        $this->method = 'get' . $this->method;
    }

    public function getName()
    {
        return $this->user['userName'];
    }

    public function getMethod()
    {
        return $this->method;
    }

}