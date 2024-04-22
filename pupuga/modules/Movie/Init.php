<?php

namespace Pupuga\Modules\Movie;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
	private $settings = array(
		'width' => '560',
		'height' => '300',
		'full' => 0
	);

    public function boot()
    {
	    $data['settings'] = array_merge($this->settings, $this->atts);

	    return $data;
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Movie')
            ->setDescription('Shortcode get Movie.')
            ->setDocumentation(__DIR__ . '/doc.html');
    }
}
