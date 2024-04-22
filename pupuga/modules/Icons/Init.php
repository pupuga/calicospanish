<?php

namespace Pupuga\Modules\Icons;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{
	protected function boot()
	{
		if (isset($this->atts['link'])) {
			$data['link'] = (strpos($this->atts['link'], '@') === false) ? $this->atts['link'] : 'mailto:' . $this->atts['link'];
		} else {
			$data['link'] = '';
		}

		return $data;
	}

	protected function doc()
	{
		return (new Doc\TemplateProperty)
			->setTitle('Icons')
			->setDescription('Shortcode get Font Awesome Icons')
			->setDocumentation(__DIR__ . '/doc.html');
	}
}
