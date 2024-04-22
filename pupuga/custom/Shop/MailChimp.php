<?php

namespace Pupuga\Custom\Shop;

use \Pupuga\Libs\Curl\MailChimp as CurlMailChimp;
use \Pupuga\Core\Base\Common as Common;

final class MailChimp
{
    private $list;
    private $subscriber = array('email'=>'', 'firstName'=>'', 'lastName'=>'');
    private $mailChimp;
    private $lists = array();
    private $key;

    public function __construct($list, array $subscriber)
    {
        $this->list = strtolower($list);
        $this->setParameters();
        if (isset($this->lists[$this->list])) {
            $this->setSubscriber($subscriber);
            $this->saveToList();
        }
    }

    private function setSubscriber($subscriber)
    {
        $this->subscriber = array_merge($this->subscriber, $subscriber);
    }

    private function setParameters()
    {
        $this->mailChimp = Common::app()->common['configuration_parameters']->mailchimp;
        $this->key = strval($this->mailChimp->attributes()->key);
        $this->setLists();
    }

    private function setLists()
    {
        $lists = $this->mailChimp->lists->attributes();
        if (count($lists)) {
            foreach ($lists as $key => $list) {
                $this->lists[$key] = strval($list);
            }
        }
    }

    private function saveToList()
    {
        $mailChimp = CurlMailChimp::app($this->key);
        $mailChimp->removeSubscriberFromLists($this->lists, $this->subscriber['email']);
        $mailChimp->addSubscriber($this->lists[$this->list], $this->subscriber['email'], $this->subscriber['firstName'], $this->subscriber['lastName']);

        return $this;
    }

}