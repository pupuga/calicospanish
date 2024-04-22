<?php

namespace Pupuga\Modules\Calicosources;

use Pupuga\Core\Base;
use Pupuga\Core\Carbon;
use Pupuga\Modules\Doc;
use Pupuga\Core\Load;

class Init extends Base\Controller
{
    protected $dataObject = null;

    public function __construct($pathTemplates = null)
    {
        if (is_user_logged_in() && !current_user_can('administrator')) {
            $session = Base\Common::app()->common['configuration_parameters']->sessions->attributes();
            $limit = strval($session->limit);
            Session::app()->numberSession($limit);
        }
        if (is_admin()) {
            (new LessonsFilterAdminTable)
                ->setPlaceholder('All Lessons')
                ->setPostType('sources')
                ->setIdentifierSelect('lessons')
                ->action();
            (new DaysFilterAdminTable)
                ->setPlaceholder('All Days')
                ->setPostType('sources')
                ->setIdentifierSelect('days')
                ->setNamePlus(' Day')
                ->action();
            new FilterGridAdminTable();
        } elseif (User::app()->isMember() && $GLOBALS['pagenow'] != 'wp-login.php') {
            Load\StylesScripts::app()->requireStylesScriptsIntoFooter([
                'styles' => array(
                    'style-calico-lessons' => 'main-calico-lessons.css',
                ),
                'scripts' => [
                    'script-calico-lessons' => 'main-calico-lessons.js',
                    'script-plugin-audiojs' => 'plugins/audiojs/audio.min.js'
                ],
                'priority' => [9, 1]
            ]);
        }
        parent::__construct($pathTemplates);
    }

    protected function hook()
    {
        parent::hook();
        Carbon\Helper::hook(new CarbonFields);
    }

    protected function boot()
    {
        $this->getClass();

        return $this->dataObject;
    }

    public function shortCode($atts, $content = null)
    {

        $html = $this->getHtml($atts, $content);
        /*if (User::app()->isMember()) {
            $html = $this->getHtml($atts, $content);
        } else {
            $html = User::app()->notMember();
        }*/
        return $html;
    }

    protected function getClass()
    {
        if (isset($this->atts['template']) && !empty($this->atts['template'])) {
            $class = __NAMESPACE__ . '\\' . ucfirst($this->atts['template']);
            $this->dataObject = new $class($this->atts);
        }
    }

    protected function doc()
    {
        return (new Doc\TemplateProperty)
            ->setTitle('Calico Sources')
            ->setDescription('Module for Calico Spanish')
            ->setDocumentation(__DIR__ . '/doc.html');
    }
}
