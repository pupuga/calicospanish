<?php

namespace Pupuga\Modules\Link;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
    protected function boot()
    {
        if (isset($this->atts['link'])) {
             if (strpos($this->atts['link'], '@') == true) {
                 $data['link'] = 'mailto:' . $this->atts['link'];
             } else {
                 $data['link'] = $this->atts['link'];
                 $data['target'] = $this->atts['target'] ?: '_blank';
             }
        } else {
            $data['link'] = '';
        }

        return $data;
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Link')
            ->setDescription('Shortcode get Link. You can use Font Awesome Icons')
            ->setDocumentation(__DIR__ . '/doc.html');
    }
}
