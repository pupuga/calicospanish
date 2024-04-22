<?php

namespace Pupuga\Modules\Calicosources;

class Session {

    private $userInfo;
    private $userMeta;
    private $timeSessions;
    private $sessionTokens;
    private $limit;
    private static $instance;

    private function __construct()
    {
        $this->userInfo = get_currentuserinfo();
        $this->userMeta = get_user_meta($this->userInfo->ID);
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

    public function numberSession(int $limit)
    {
        $this->limit = $limit;
        $this->getSessionTokens();
        if (count($this->sessionTokens) > $this->limit) {
            $this->setTimeSession();
        }
    }

    public function getSessionTokens()
    {
        $this->sessionTokens = unserialize($this->userMeta['session_tokens'][0]);
    }

    public function setSessionTokens($sessionTokens)
    {
        update_user_meta($this->userInfo->ID, 'session_tokens', $sessionTokens);
    }

    private function setTimeSession()
    {
        $this->getSessionTokens();
        foreach ($this->sessionTokens as $key => $sessionTokens) {
            $this->timeSessions[intval($sessionTokens['login'])] = $key;
        }
        ksort($this->timeSessions);
        $this->timeSessions = array_slice($this->timeSessions,count($this->timeSessions) - $this->limit, $this->limit);
        $workSessions = array_filter($this->sessionTokens, function ($key){
            return  in_array($key, $this->timeSessions);
        }, ARRAY_FILTER_USE_KEY);
        $this->setSessionTokens($workSessions);
    }
}