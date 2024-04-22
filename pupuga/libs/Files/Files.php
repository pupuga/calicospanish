<?php

namespace Pupuga\Libs\Files;

class Files
{
    public static function getFile($file, $echo = false, $params = array(), $dir = __DIRMAIN__)
    {

        $html = '';
        if (self::getExt($file) == 'html') {
            $dir = '';
        }
        $file = $dir . $file;
        if (is_file($file)) {
            if ($echo) {
                require $file;
            } else {
                ob_start();
                require($file);
                $html = preg_replace('/<!--(.*?)-->/', '', ob_get_clean());
            }
        }

        return $html;
    }

    public static function getExt($file)
    {
        $fileInfo = new \SplFileInfo($file);
        $ext = explode('.', $fileInfo->getFilename())[1];

        return $ext;
    }

    public static function addPhpExt($file)
    {
        if (self::getExt($file) != 'php') {
            $file = $file . '.php';
        }

        return $file;
    }

    public static function getTemplate($template, $echo = false, $params = array(), $dir = __DIRMAIN__)
    {
        $file = self::addPhpExt($template);
        $html = self::getFile($file, $echo, $params, $dir);

        return $html;
    }

    public static function getTemplatePupuga($template, $echo = false, $params = array())
    {
        $dir = (defined('__DIRTEMPLATES__')) ? __DIRTEMPLATES__ : '';
        if (isset($params['slug']) && is_array($params['slug'])) {
            $params['slug'] = (is_user_logged_in()) ? $params['slug']['user'] : $params['slug']['guest'];
        }
        $html = self::getTemplate($template, $echo, $params, $dir);

        return $html;
    }

	public static function getFileWithWrapper($file, $echo, $wrappers)
	{
		$data = self::getFile($file, false, array(), '');
		$data = $wrappers[0] . $data . $wrappers[1];
		if ($echo) {
			echo $data;
		} else {
			return $data;
		}
	}

	public static function getCss($file, $echo = false)
	{
		$wrappers = array('<style type="text/css" media="screen">', '</style>');
		self::getFileWithWrapper($file, $echo, $wrappers);
	}

}