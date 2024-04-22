<?php

namespace Pupuga\Modules\Calicosources;

class TypeResource
{
    protected $resources;
    protected $params;
    protected $html = '';
    protected $template;

    public function __construct($data = array())
    {
        $this->resources = $data['resources'];
        $this->params = $data['params'];
        $this->setResources();
    }

    protected function setResources()
    {
        if (count($this->resources) > 0) {
            foreach ($this->resources as $key => $resource) {
                $this
                    ->setLevelLesson($key, $resource)
                    ->setDay($key, $resource)
                    ->setThumbnail($key, $resource)
                    ->setMetaFields($key, $resource);
                if (!is_null($this->params['kind'])) {
                    $method = 'setResources' . ucfirst($this->params['kind']);
                    if (method_exists($this, $method)) {
                        $this->$method($key, $resource);
                    }
                }
            }
        }
    }

    protected function setLevelLesson($key, $resource)
    {
        $nameParts = explode(' ', $resource->name, 2);
        $this->resources[$key]->lesson = intval($nameParts[0]);
        $this->resources[$key]->level = $nameParts[1];
        $this->resources[$key]->levelSlug = sanitize_title($nameParts[1]);
        $this->resources[$key]->levelStep = explode(' ', $resource->level, 2)[1];

        return $this;
    }

    protected function setDay($key, $resource)
    {
        $this->resources[$key]->day = intval(wp_get_post_terms($resource->object_id, 'day')[0]->slug);

        return $this;
    }

    protected function setThumbnail($key, $resource)
    {
        $this->resources[$key]->thumbnail = get_the_post_thumbnail_url($resource->object_id, 'full');

        return $this;
    }

    protected function setMetaFields($key, $resource)
    {
        $this->resources[$key]->addidtionalTitle = carbon_get_post_meta($resource->object_id, 'additional_data_title');
        $this->resources[$key]->addidtionalSubtitle = carbon_get_post_meta($resource->object_id, 'additional_data_subtitle');
        $this->resources[$key]->addidtionalDescription = carbon_get_post_meta($resource->object_id, 'additional_data_description');

        $this->resources[$key]->link = carbon_get_post_meta($resource->object_id, 'source_link');
        if (!empty($this->resources[$key]->link)) {
            $linkTypes = carbon_get_post_meta($resource->object_id, 'link_buttons_buttons');
            if (is_array($linkTypes) && count($linkTypes)) {
                foreach ($linkTypes as $linkType) {
                    $this->resources[$key]->$linkType = 1;
                }
            }
        }

        return $this;
    }

    protected function setResourcesVideo($key, $resource)
    {
        if (isset($resource->meta_value) && !empty($resource->meta_value)) {
            $resource->meta_value = rtrim($resource->meta_value, '/');
            $urlArray = explode('://', $resource->meta_value);
            $uriArray = explode('/', $urlArray[1]);
            $videoServer = $uriArray[0];
            $videoId = ltrim(array_pop($uriArray), 'www');
            switch ($videoServer) {
                case ('player.vimeo.com') :
                case ('vimeo.com') :
                    $this->resources[$key]->url = 'https://player.vimeo.com/video/' . $videoId;
                    $this->resources[$key]->template = 'vimeo';
                    break;
                case ('youtu.be') :
                case ('youtube.com') :
                    $this->resources[$key]->url = 'https://www.youtube.com/embed/' . $videoId;
                    $this->resources[$key]->template = 'youtube';
                    break;
            }
        } else {
            $this->resources[$key]->error = 'VIDEO URL IS EMPTY!!!!!!!!!!!!!';
            //unset($this->resources[$key]);
        }

        $this->setDownloadFile($key, $resource);

        return $this;
    }

    protected function setResourcesAudio($key, $resource)
    {
        if (isset($resource->meta_value) && !empty($resource->meta_value)) {
            $this->resources[$key]->downloadFileId = $resource->meta_value;
            $this->resources[$key]->downloadFile = wp_get_attachment_url($this->resources[$key]->downloadFileId);
        }

        return $this;
    }

    protected function setResourcesGallery($key, $resource)
    {
        $this->resources[$key]->images_ids = explode(',', $this->resources[$key]->images_ids);
        $this->resources[$key]->images_order = explode(',', $this->resources[$key]->images_order);
        if (count($this->resources[$key]->images_ids) > 0 && count($this->resources[$key]->images_order) > 0) {
            foreach ($resource->images_ids as $keyPos => $id) {
                $pos = intval(explode('|', $this->resources[$key]->images_order[$keyPos])[3]);
                $this->resources[$key]->galleryImages[$pos] = wp_get_attachment_metadata($id);
                $this->resources[$key]->galleryImages[$pos]['id'] = $id;
                $this->resources[$key]->galleryImages[$pos]['folder'] = home_url('/wp-content/uploads/') . dirname($this->resources[$key]->galleryImages[$pos]['file']) . '/';
                $this->resources[$key]->galleryImages[$pos]['full'] = home_url('/wp-content/uploads/') . $this->resources[$key]->galleryImages[$pos]['file'];
            }
            unset($this->resources[$key]->images_ids);
            unset($this->resources[$key]->images_order);
            //if it need reverse
            //$this->resources[$key]->galleryImages = array_reverse($this->resources[$key]->galleryImages);
        }

        $this->setDownloadFile($key, $resource);

        return $this;
    }

    protected function setResourcesFile($key, $resource)
    {
        if (isset($resource->meta_value) && !empty($resource->meta_value)) {
            $this->setDownloadFile($key, $resource, $resource->meta_value);
        }

        return $this;
    }

    protected function setDownloadFile($key, $resource, $fileId = null)
    {
        $this->resources[$key]->downloadFileId = (is_null($fileId) || empty($fileId)) ? carbon_get_post_meta($resource->object_id, 'source_pdf') : $fileId;
        $this->resources[$key]->downloadFile = wp_get_attachment_url($this->resources[$key]->downloadFileId);
        $this->resources[$key]->downloadFileLink = (!empty($this->resources[$key]->downloadFileId)) ? home_url('/filesource/' . $this->resources[$key]->downloadFileId . '/') : '';
        $this->resources[$key]->viewFileLink = (!empty($this->resources[$key]->downloadFileId)) ? home_url('/filesource-view/' . $this->resources[$key]->downloadFileId . '/') : '';
        return $this;
    }

    public function getResources()
    {
        return $this->resources;
    }
}