<?php

namespace Pupuga\Modules\Button;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
    protected function boot()
    {
        $data['class'] = $this->atts['color'] ? ' button--' . $this->atts['color'] : '';
        $data['class'] .= $this->atts['size'] ? ' button--' . $this->atts['size'] : '';
        $iconColor = (isset($this->atts['icon-color']) && !empty($this->atts['icon-color'])) ? "color:{$this->atts['icon-color']}" : '';
        $iconTitle = (isset($this->atts['icon-title']) && !empty($this->atts['icon-title'])) ? "<span style='{$iconColor}'>{$this->atts['icon-title']}</span>" : '';
        $data['title'] = $this->replaceTemplate($this->atts['title'], $iconColor, $iconTitle);
        $data['width'] = $this->atts['width'] ? 'min-width:' . $this->atts['width'] . '%' : '';
        return $data;
    }

    protected function replaceTemplate($title, $iconColor = '', $iconTitle = '')
    {
        $regex = '/%%(.*?)%%/';
        preg_match_all($regex, $title, $matches);
        if (count($matches[1])) {
            foreach ($matches[1] as $match) {
                $search = '%%' . $match . '%%';
                $replace = '<i class="fa fa-' . $match . '" style="margin-right:0;' . $iconColor . '" aria-hidden="true"></i>' . $iconTitle;
                $title = str_replace($search, $replace, $title);
            }
        }

        return $title;
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Button')
            ->setDescription('Shortcode get Button')
            ->setDocumentation(__DIR__ . '/doc.html');
    }
}
