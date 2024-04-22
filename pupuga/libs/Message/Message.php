<?php

namespace Pupuga\Libs\Message;

use Pupuga\Libs\Files\Files;

class Message {

    protected $message = array(
        'warning-trial' => array(
          'type' => 'error',
          'text' => '<p><strong>Your free trial has expired. Please purchase your subscription <a href="/pricing/">here</a>.</strong></p><p><small>Do you need more time to review Stories Online? Please contact customer <a href="mailto:support@calicospanish.com">support</a>.</small></p>'
        ),
        'warning-is-trial-period' => array(
          'type' => 'error',
          'text' => '<p><strong>Your have free trial period. Please purchase your subscription <a href="/pricing/">here</a>.</strong></p><p><small>Do you need more time to review Stories Online? Please contact customer <a href="mailto:support@calicospanish.com">support</a>.</small></p>'
        ),
        'warning-have-subscription' => array(
          'type' => 'error',
          'text' => '<p><strong>When you purchase a new subscription plan, your new plan begins immediately and your old subscription plan is cancelled</strong></p><p><small>If you need assistance managing your subscription, please contact customer <a href="mailto:support@calicospanish.com">support</a>.</small></p>'
        ),
        'warning-subscription-expired' => array(
          'type' => 'error',
          'text' => '<p><strong>Your period of plan has expired. Purchase one of our subscriptions to keep learning!</strong></p><p>Your Stories Online subscription will give you access to <b>ALL</b> of the videos, activities, lesson plans, posters, flash cards, and downloads. Teach unlimited students with your Stories Online subscription.</p><p><small>If you need assistance managing your subscription, please contact customer <a href="mailto:support@calicospanish.com">support</a>.</small></p>'
        )
    );

    public static $instance;

    private function __construct()
    {
    }

    /**
     * @return $this
     */
    static function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getMessage($type = null)
    {
        if (is_null($type) && (isset($_GET['message']) && isset($this->message[$_GET['message']]))) {
            $type = $_GET['message'];
        }

        if (!is_null($type) && isset($this->message[$type])) {
            Files::getTemplatePupuga('message', true, $this->message[$type]);
        }
    }
}