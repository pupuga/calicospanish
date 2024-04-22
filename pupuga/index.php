<?php

namespace Pupuga;

use \Pupuga\Core\Base;

define('VERSION', '20190307');
define('__DIRFRAMEWORK__', __DIR__ . '/');
define('__DIRMAIN__', dirname(__DIRFRAMEWORK__) . '/');
define('__URLMAIN__', get_stylesheet_directory_uri() . '/');
define('__DIRASSETS__', __DIRFRAMEWORK__ . 'assets/dist/');
define('__URLASSETS__', __URLMAIN__ . 'pupuga/assets/');
define('__URLASSETSDIST__', __URLASSETS__ . 'dist/');
define('__DIRMODULES__', __DIRFRAMEWORK__ . 'modules/');
define('__URLMODULES__', __URLMAIN__ . 'pupuga/modules/');
define('__DIRTEMPLATES__', __DIRFRAMEWORK__ . 'templates/');

class Boot
{

    function __construct()
    {
        $this->autoload();
    }

    private function autoload()
    {
        spl_autoload_register( function ( $class ) {
            $class = str_replace( 'Pupuga\\', '', $class );
            if (count(explode('\\', $class)) > 1) {
                $class = lcfirst( $class );
            }
            $class = str_replace('\\', '/', $class);
            $file  = __DIRFRAMEWORK__ . $class . '.php';
            if ( is_file( $file ) ) {
                require $file;
            }
        });
    }

    public function requireFiles()
    {
	    new Base\RequireFiles();
    }

}

(new Boot())->requireFiles();