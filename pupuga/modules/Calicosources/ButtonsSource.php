<?php

namespace Pupuga\Modules\Calicosources;

use  Pupuga\Libs\Files\Files;

class ButtonsSource
{
    protected $id;
    protected $label;
    protected $html = '';
    protected $template;
    protected $link;
    protected $view;
    protected $download;

    public function __construct($id, $label)
    {
        $this->id = $id;
        $this->label = $label;
        $this->getSource()->getTemplate();
        $this->getLink();
    }

    protected function getSource()
    {
        $attachmentId = carbon_get_post_meta($this->id, 'source_pdf');
        $file = wp_get_attachment_url($attachmentId);
        if (!empty($file)) {
            $this->template = 'source';
            //$this->link = $file;
            $this->view = home_url('/filesource-view/' . $attachmentId . '/');
            $this->link = $this->download = home_url('/filesource/' . $attachmentId . '/');
        } else {
            $this->template = '';
        }

        return $this;
    }

    protected function getLink()
    {
        $this->link = trim(carbon_get_post_meta($this->id, 'source_link'));
        if (!empty($this->link)) {
            $buttons = carbon_get_post_meta($this->id, 'link_buttons_buttons');
            if (is_array($buttons) && count($buttons) > 0) {
                $this->template = '';
                foreach ($buttons as $template) {
                    $this->template = $template;
                    $this->getTemplate();
                }
            }
        }

        return $this;
    }

    protected function getTemplate()
    {
        if (!empty($this->template)) {
            $params = [
                'link' => $this->link,
                'view' => $this->view,
                'download' => $this->download,
                'label' => $this->label
            ];
            $this->html .= Files::getTemplate($this->template, false, $params, __DIR__ . '/templates/buttons/');
        }

        return $this;
    }

    public function getButtons()
    {
        return $this->html;
    }
}