<?php

namespace Pupuga\Modules\Amp;

use Pupuga\Libs\Files\Files;
use Pupuga\Core\Posts\GetPosts;

abstract class getParams
{
    protected $object;
    protected $pathTemplate;
    protected $pathStyles;
    protected $urlModules;

    /**
     * @param \WP_Post $object
     *
     * @return $this
     */
    public function __construct(\WP_Post $object)
    {
        $this->object = $object;
        $this->pathTemplate = __DIR__ . '/templates/' . $this->getTemplate() . '/';
        $this->pathStyles = __DIR__ . '/assets/' . $this->getTemplate() . '/dist/css/';
        $this->urlModules = __URLMODULES__ . 'Amp/assets/' . $this->getTemplate() . '/_src/modules/';

        return $this;
    }

    public function getUrlModules()
    {
        return $this->urlModules;
    }

    public function getTemplate()
    {
        if (!isset($this->template)) {
            $this->template = $this->object->template;
        }

        return $this->template;
    }

    public function getTimeZone()
    {
        if (!isset($this->timeZone)) {
            $this->timeZone = $this->object->timeZone;
        }

        return $this->timeZone;
    }

    public function getLang()
    {
        if (!isset($this->lang)) {
            $this->lang = $this->object->lang;
        }

        return $this->lang;
    }

    public function getAmpType()
    {
        if (!isset($this->ampType)) {
            $this->ampType = ($this->object->post_type == 'page') ? 'WebPage' : 'NewsArticle';
        }

        return $this->ampType;
    }

    public function getAmpUrl()
    {
        if (!isset($this->ampUrl)) {
            $this->ampUrl = rtrim($this->getCanonicalUrl(), '/') . '/amp/';
        }

        return $this->ampUrl;
    }

    public function getLogo()
    {
        $logoArray = $this->getLogoArray();
        $img = '<amp-img src="' . $logoArray[0] . '"
                 width="' . $logoArray[1] . '"
                 height="' . $logoArray[2] . '"
                 alt="' . $this->getName() . '"
                 class="amp-image amp-image--logo">';

        return $img;
    }

    public function getLogoArray()
    {
        if (!isset($this->logoArray)) {
            $id = get_theme_mod('custom_logo');
            if (trim($id) == '' || trim($id) == 0) {
                $id = get_theme_mod('header_image_data')->attachment_id;
            }
            if (!isset($this->logoId)) {
                $this->logoId = $id;
            }
            $this->logoArray = wp_get_attachment_image_src($id, 'full');
        }

        return $this->logoArray;
    }

    public function getLogoSrc()
    {
        if (!isset($this->logoSrc)) {
            $this->logoSrc = $this->getLogoArray()[0];
        }

        return $this->logoSrc;
    }

    public function getLogoWidth()
    {
        if (!isset($this->logoWidth)) {
            $this->logoWidth = $this->getLogoArray()[1];
        }

        return $this->logoWidth;
    }

    public function getLogoHeight()
    {
        if (!isset($this->logoHeight)) {
            $this->logoHeight = ($this->getLogoArray()[2] == 0 || $this->getLogoArray()[2] == '') ? '50'  : $this->getLogoArray()[2];
        }

        return $this->logoHeight;
    }

    public function getTwitter()
    {
        if (!isset($this->twitter)) {
            $this->twitter = $this->object->twitter;
        }

        return $this->twitter;
    }

    public function getName()
    {
        if (!isset($this->name)) {
            $this->name = (explode('://', rtrim(trim(home_url()), '/'))[1]);
        }

        return $this->name;
    }

    public function getId()
    {
        if (!isset($this->id)) {
            $this->id = $this->object->ID;
        }

        return $this->id;
    }

    public function getCanonicalUrl()
    {
        if (!isset($this->canonicalUrl)) {
            $this->canonicalUrl = get_permalink($this->object->ID);
        }

        return $this->canonicalUrl;
    }

    public function getTitle()
    {
        if (!isset($this->title)) {
            $this->title = $this->object->post_title;
        }

        return $this->title;
    }

    public function getDescription()
    {
        if (!isset($this->description)) {
            $this->description = get_the_excerpt($this->object->ID);
            if (empty($this->description)) {
                $this->description = wp_trim_words($this->object->post_content, 50, '...');
            }
        }

        return $this->description;
    }

    public function getCreateDate()
    {
        if (!isset($this->createDate)) {
            $this->createDate = $this->transformToAmpDate($this->object->post_date);
        }

        return $this->createDate;
    }

    public function getModifiedDate()
    {
        if (!isset($this->modifiedDate)) {
            $this->modifiedDate = $this->transformToAmpDate($this->object->post_modified);
        }

        return $this->modifiedDate;
    }

    public function getHeadTemplate()
    {
        if (!isset($this->headTemplate)) {
            $this->headTemplate = Files::getTemplate('head', false, $this, $this->pathTemplate);
        }

        return $this->headTemplate;
    }

    public function getHeadSeoTemplate()
    {
        if (!isset($this->headSeoTemplate)) {
            $this->headSeoTemplate = Files::getTemplate('head-seo', false, $this, $this->pathTemplate);
        }

        return $this->headSeoTemplate;
    }

    public function getHeadAmpTemplate()
    {
        if (!isset($this->headAmpTemplate)) {
            $this->headAmpTemplate = Files::getTemplate('head-amp', false, $this, $this->pathTemplate);
        }

        return $this->headAmpTemplate;
    }

    public function getCustomStyles()
    {
        if (!isset($this->customStyle)) {
            $this->customStyle = Files::getFile('main.css', false, $this, $this->pathStyles);
            $this->customStyle = str_replace('../../modules/', $this->getUrlModules(), $this->customStyle);
        }

        return $this->customStyle;
    }

    public function getBodyTemplate()
    {
        if (!isset($this->bodyTemplate)) {
            $this->bodyTemplate = Files::getTemplate('body', false, $this, $this->pathTemplate);
        }

        return $this->bodyTemplate;
    }

    public function getThumbnail($size = 'full')
    {
        if (!isset($this->thumbnail)) {
            $id = get_post_thumbnail_id($this->object->ID);
            $this->thumbnail = wp_get_attachment_image_src($id, $size);
            $this->thumbnail['alt'] = $this->getImageAlt($id);
        }

        return $this->thumbnail;
    }

    public function getThumbnailSrc()
    {
        if (!isset($this->thumbnailSrc)) {
            $this->thumbnailSrc = $this->getThumbnail()[0];
        }

        return $this->thumbnailSrc;
    }

    public function getThumbnailWidth()
    {
        if (!isset($this->thumbnailWidth)) {
            $this->thumbnailWidth = $this->getThumbnail()[1];
        }

        return $this->thumbnailWidth;
    }

    public function getThumbnailHeight()
    {
        if (!isset($this->thumbnailHeight)) {
            $this->thumbnailHeight = $this->getThumbnail()[2];
        }

        return $this->thumbnailHeight;
    }

    public function getThumbnailAlt()
    {
        if (!isset($this->thumbnailAlt)) {
            $this->thumbnailAlt = $this->getThumbnail()['alt'];
        }

        return $this->thumbnailAlt;
    }

    public function getContent()
    {
        if (!isset($this->content)) {
            $this->content = $this->transformTagToAmpTag(wpautop(do_shortcode($this->object->post_content)));
        }

        return $this->content;
    }

    public function getDateCopyright($startDate = null)
    {
        $nowDate = date('Y');
        if (is_null($startDate) || $nowDate == $startDate) {
            $date = $nowDate;
        } else {
            $date = $startDate . ' - ' . $nowDate;
        }

        return $date;
    }

    public function getPosts($number = 3, $template = 'post')
    {
        $html = GetPosts::app()
            ->postType($this->object->post_type)
            ->postStatus('publish')
            ->orderBy('modified date')
            ->order('desc')
            ->numberPosts($number)
            ->exclude($this->object->ID)
            ->postsTemplate(null, $template, false, array('getParams' => $this), $this->pathTemplate);

        return $html;
    }

    public function transformImageToAmpImage($postId)
    {
        $html = $this->transformTagToAmpTag(get_the_post_thumbnail($postId));

        return $html;
    }

    protected function transformTagToAmpTag($html = '')
    {
        $html = str_ireplace(
            ['<img', '<video', '/video>', '<audio', '/audio>'],
            ['<amp-img', '<amp-video', '/amp-video>', '<amp-audio', '/amp-audio>'],
            $html
        );
        $html = preg_replace('#<amp-img(.*?)/>#', '<amp-img layout="responsive"$1></amp-img>', $html);
        $html = strip_tags($html, '<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');

        return $html;
    }

    protected function getImageAlt($id)
    {
        $alt = trim(strip_tags(get_post_meta($id, '_wp_attachment_image_alt', true)));

        return $alt;
    }

    protected function transformToAmpDate($date)
    {
        $date = str_replace(' ', 'T', trim($date));
        $timeZone = $this->getTimeZone();
        if (!empty($timeZone)) {
            $date .= $timeZone;
        }

        return $date;
    }

    public function getGooglePageview()
    {
        if ($this->object->googlePageview === true) {
            $template = Files::getTemplate('google-pageview', false, $this->object->googleAccount, $this->pathTemplate);
        } else {
            $template = '';
        }

        return $template;
    }
}