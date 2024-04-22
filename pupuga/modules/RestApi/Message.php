<?php

namespace Pupuga\Modules\RestApi;

class Message
{
    public static $instance;
    private $error = array(
        'default' => 'Something went wrong',
        'authorization' => "Your haven't access",
        'request' => "Request is bad"
    );

    static public function app()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function getMessage($type, $code)
    {
        $type = $this->$type;
        if (empty($code) || !isset($type[$code])) {
            $code = 'default';
        }

        return $type[$code];
    }

    public function getMessageError($code, $exit = true)
    {
        $error = $this->getMessage('error', $code);

        if ($exit) {
            echo $error;
            exit;
        }

        return $error;
    }
}