<?php

namespace Pupuga\Modules\Blog;

use Pupuga\Core\Base;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{

    public function __construct($pathTemplates = null)
    {
        parent::__construct($pathTemplates);
        Hooks::app();
    }

    protected function boot()
	{
	    $data = (new Data($this))->getData();

		return $data;
	}

	protected function doc()
	{
		return (new Doc\TemplateProperty)
			->setTitle('Blog')
			->setDescription('Shortcode get blog')
			->setDocumentation(__DIR__ . '/doc.html');
	}
}
