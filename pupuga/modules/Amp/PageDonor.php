<?php

namespace Pupuga\Modules\Amp;

class PageDonor extends Page
{
    /**
     * @param Init $object
     *
     * @return $this
     */
    public static function app(Init $object = null)
    {
        if (self::$instance == null) {
            self::$instance = new self($object);
        }

        return self::$instance;
    }

    public function init()
    {
        $this->setItemObject();
    }

    public function addAmpMetaToHead()
    {
        $metaAmp = '<link rel="amphtml" href="' . $this->createAmpUrl() . '">';
        echo $metaAmp;
    }

    protected function action()
    {
        $this->addAmpMetaToHead();
    }

}