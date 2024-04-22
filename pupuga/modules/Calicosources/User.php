<?php

namespace Pupuga\Modules\Calicosources;

class User {

    protected $userId;
    private static $instance;

    public function __construct($userId = null)
    {
        if (is_null($userId)) {
            $userId = get_current_user_id();
        }
        $this->userId = $userId;
    }

    /**
     * @return $this
     */
    static function app($userId = null)
    {
        if (self::$instance === null) {
            self::$instance = new self($userId);
        }
        return self::$instance;
    }

    public function isMember()
    {
        $isMember = (function_exists('wc_memberships_is_user_active_member') && (wc_memberships_is_user_active_member() || is_super_admin())) ? true : false;

        return $isMember;
    }

    public function isFreePlanUser()
    {
        $isFreePlanUser = (wc_memberships_is_user_active_member($this->userId, 'free-trial') && !is_super_admin());

        return $isFreePlanUser;
    }

    public function notMember()
    {
        $content = "You are not a member";

        return $content;
    }
}