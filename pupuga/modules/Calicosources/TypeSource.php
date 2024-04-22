<?php

namespace Pupuga\Modules\Calicosources;

use  Pupuga\Libs\Files\Files;

class TypeSource
{
    protected $params;
    protected $html = '';
    protected $template;

    public function __construct($params = array())
    {
        $this->params = $params;
        $this->getSourceModules();
    }

    protected function getSourceModules()
    {
        if ((isset($this->params['_type']) && !empty($this->params['_type']))) {
            $type = $this->params['_type'];
            unset($this->params['_type']);
        } elseif (isset($this->params['type']) && !empty($this->params['type'])) {
            $type = $this->params['type'];
            unset($this->params['type']);
        }

        if (!empty($type)) {
            $this->template = strtolower(str_replace(array('_', '-'), '', $type));
            $method = 'get' . ucfirst($this->template);
            $this->$method()->getTemplate();
        }
    }

    protected function getRedactor()
    {
        return $this;
    }

    protected function getVideohosting()
    {
        if (isset($this->params['video_hosting_url']) && !empty($this->params['video_hosting_url'])) {
            $this->params['video_hosting_url'] = rtrim($this->params['video_hosting_url'], '/');
            $urlArray = explode('://', $this->params['video_hosting_url']);
            $uriArray = explode('/', $urlArray[1]);
            $videoServer = $uriArray[0];
            $videoId = ltrim(array_pop($uriArray), 'www');
            switch ($videoServer) {
                case ('player.vimeo.com') :
                case ('vimeo.com') :
                    $this->params['correct_url'] = 'https://player.vimeo.com/video/' . $videoId;
                    $this->template .= '-vimeo';
                    break;
                case ('youtu.be') :
                case ('youtube.com') :
                    $this->params['correct_url'] = 'https://www.youtube.com/embed/' . $videoId;
                    $this->template .= '-youtube';
                    break;
            }
        }

        return $this;
    }

    protected function getAudio()
    {
        $id = $this->params['source_audio'];
        $this->params['correct_url'] = wp_get_attachment_url($id);

        return $this;
    }

    protected function getGallery()
    {
        $ids = $this->params['source_media'];
        if (count($ids) > 0) {
            $this->params['images'] = array();
            //if it need reverse
            //$ids = array_reverse($ids);
            foreach ($ids as $id) {
                $this->params['images'][$id]['size'] = wp_get_attachment_metadata($id);
                $this->params['images'][$id]['folder'] = home_url('/wp-content/uploads/') . dirname($this->params['images'][$id]['size']['file']) . '/';
                $this->params['images'][$id]['full'] =  home_url('/wp-content/uploads/') . $this->params['images'][$id]['size']['file'];
            }
        }

        return $this;
    }

    protected function getTemplate($template = null)
    {
        if ($template === null) {
            $template = $this->template;
        }
        $this->html = Files::getTemplate($template, false, $this->params, __DIR__ . '/templates/sources/');
    }

    public function getModuleContent()
    {
        return $this->html;
    }

    public function getModuleType()
    {
        return $this->template;
    }
}