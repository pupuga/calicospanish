<?php

namespace Pupuga;

abstract class Files
{
    protected $requireFiles;

    function __construct()
    {
        $this->requireFiles = array(
            'core' => array(
                'Init/Init',
	            'Carbon/Init'
            ),
            'custom' => array(
                //'ThemeMethods/Hooks',
                'ThemeMethods/GetFile',
                'Shop/Init'
            )
        );
    }
}