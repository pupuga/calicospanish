<?php

namespace Pupuga\Core\Init;

use Pupuga\Core\Load;

class PageAdmin
{
    public function __construct()
    {
        //denied dashboard access
        add_action('admin_init', array($this, 'denyDashboardAccess'));
        if (is_admin()) {
            // admin style & scripts
            $this->addStyles();
            add_action('admin_head', array($this, 'addScripts'));
            add_filter('mce_external_plugins', array($this, 'tinyMceAddScripts'));
            add_filter('mce_buttons_3', array($this, 'tinyMceAddButtons'));
        }
    }

    public function denyDashboardAccess()
    {
        if (is_admin() && (!is_user_logged_in() || current_user_can('subscriber')) && !(defined('DOING_AJAX') && DOING_AJAX)) {
            wp_redirect(site_url() . '/login/');
            exit;
        }
    }

    public function addStyles()
    {
        $enqueues = array(
            'styles' => array(
                'style-admin' => 'admin.css'
            )
        );
        Load\StylesScripts::app()->requireStylesScripts($enqueues);
    }

    public function addScripts()
    {
        $enqueues = array(
            'scripts' => array(
                'script-admin' => 'admin.js',
            )
        );
        Load\StylesScripts::app()->requireStylesScripts($enqueues);
    }

    /**
     * add scripts for editor
     */
    public function tinyMceAddScripts($plugins)
    {
        $plugins['table'] = __URLASSETSDIST__ . 'tinymce-table.js';

        return $plugins;
    }

    /**
     * add mce buttons into editor
     */
    public function tinyMceAddButtons($buttons)
    {
        $buttons[] = 'fontselect';
        $buttons[] = 'fontsizeselect';
        $buttons[] = 'styleselect';
        $buttons[] = 'backcolor';
        $buttons[] = 'newdocument';
        $buttons[] = 'cut';
        $buttons[] = 'copy';
        $buttons[] = 'charmap';
        $buttons[] = 'hr';
        $buttons[] = 'superscript';
        $buttons[] = 'subscript';
        $buttons[] = 'table';

        return $buttons;
    }

}