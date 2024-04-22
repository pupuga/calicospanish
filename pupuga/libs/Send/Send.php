<?php

namespace Pupuga\Libs\Send;

class Send
{
    private static $instance;
    public $parameters = array();

    private function __construct($to, $subject, $message, $from, $attachment)
    {
        $this
            ->setToMail($to)
            ->setSubjectMail($subject)
            ->setMessageMail($message)
            ->setHeadersMail($from);
    }

    public static function app($to, $subject = '', $message = '', $from = '', $attachment = '')
    {
        self::$instance = new self($to, $subject, $message, $from, $attachment);
        return self::$instance;
    }

    /**
     * @return $this
     */
    private function setToMail($to)
    {
        $this->parameters['to'] = $to;

        return $this;
    }

    /**
     * @return $this
     */
    private function setSubjectMail($subject)
    {
        $this->parameters['subject'] = $subject;

        return $this;
    }

    /**
     * @return $this
     */
    private function setMessageMail($message)
    {
        $this->parameters['message'] = $message;

        return $this;
    }

    /**
     * @return $this
     */
    private function setHeadersMail($from)
    {
        remove_all_filters( 'wp_mail_from' );
        remove_all_filters( 'wp_mail_from_name' );

        $headers = array();
        if ($from == '') {
            $from = get_bloginfo('admin_email');
        }
        $headers[] = 'From: ' . get_bloginfo('name') .' <' . $from . '>';
        $headers[] = 'content-type: text/html';
        $this->parameters['headers'] = $headers;

        return $this;
    }

    public function mail($copyTo = null)
    {
        $result = array();

        foreach ($this->parameters['to'] as $to) {
            $message = str_replace('$$email$$', $to, $this->parameters['message']);
            if (!is_null($copyTo) && trim($to)) {
                $to = $copyTo . ',' . $to;
            }
            $result[] = wp_mail( $to, $this->parameters['subject'], $message, $this->parameters['headers'], $this->parameters['attachments'] );
        }

        return $result;
    }

}