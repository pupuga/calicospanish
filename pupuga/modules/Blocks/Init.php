<?php

namespace Pupuga\Modules\Blocks;

use Pupuga\Core\Base;
use Pupuga\Core\Carbon;
use Pupuga\Modules\Doc;

class Init extends Base\Controller
{

    protected function hook()
    {
        parent::hook();

        Carbon\Helper::hook(new CarbonFields);
    }

	protected function boot()
	{
	    $data = (new Data($this))->getData();

		return $data;
	}

	protected function doc()
	{
		return (new Doc\TemplateProperty)
			->setTitle('Blocks')
			->setDescription('Shortcode get blocks')
			->setDocumentation(__DIR__ . '/doc.html');
	}
}
