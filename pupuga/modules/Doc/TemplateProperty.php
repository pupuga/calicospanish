<?php

namespace Pupuga\Modules\Doc;

use Pupuga\Libs\Files\Files;

class templateProperty
{
    public function __construct()
    {
    }

    public function setTitle($value)
    {
        $this->title = $value;

        return $this;
    }

    public function setDescription($value)
    {
        $this->description = $value;

        return $this;
    }

    public function setDocumentation($file)
    {
        $this->documentation = Files::getFile($file, false);

        return $this;
    }
}