<?php

namespace Pupuga\Core\Base;

use Pupuga;
use Pupuga\Libs\Files;

class RequireFiles extends Pupuga\Files
{
    public function __construct()
    {
    	parent::__construct();

        $this->loadFiles($this->requireFiles);
    }

    /**
     * require files
     */
    private function loadFiles($requireFiles = array())
    {
        if (count($requireFiles)) {
            foreach ($requireFiles as $dir => $templates) {
                $dir = __DIRFRAMEWORK__ . $dir . '/';
                if (count($templates)) {
                    foreach ($templates as $template) {
                        Files\Files::getTemplate($template, true, array(), $dir);
                    };
                }
            }
        }
    }

}