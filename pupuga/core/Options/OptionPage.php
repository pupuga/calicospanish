<?php

namespace Pupuga\Core\Options;

use Pupuga\Libs\Files;

class OptionPage
{
    public $atts;
    protected $optionsPage;
    protected $template;
    protected $params;

    /**
     * @param array $attsCustom [title, position]
     * @param string $template
     * @param array $params
     *
     * FOR SUBMENU
     * index.php - Dashboard
     * edit.php - Posts
     * upload.php - Media
     * link-manager.php - Links
     * edit.php?post_type=page - Pages
     * edit.php?post_type=your_post_type
     * edit-comments.php - Comments
     * themes.php - Appearance
     * plugins.php - Plugins
     * users.php - Users
     * tools.php - Tools
     * options-general.php - Settings
     * settings.php - Settings
     *
     * FOR MENU
     * 2 – Dashboard
     * 4 – Separator
     * 5 – Posts
     * 10 – Media
     * 15 – Links
     * 20 – Pages
     * 25 – Comments
     * 59 – Separator
     * 60 – Appearance
     * 65 – Plugins
     * 70 – Users
     * 75 – Tools
     * 80 – Settings
     * 99 – Separator
     *
     */
    public function __construct($attsCustom = array(), $template, $params = array())
    {
        $attsDefault = array(
            'title' => 'Options',
            'type' => 'options'
        );
        $atts = array_merge($attsDefault, $attsCustom);
        $this->atts['title'] = $atts['title'];
        $this->atts['parent'] = $atts['parent'];
        $this->atts['type'] = $atts['type'];
        $this->atts['key'] = $atts['type'] . '-' . strtolower(str_replace(' ', '', $atts['title']));
        $this->template = $template;
        $this->params = $params;
        $this->hooks();
    }

    /**
     * Initiate our hooks
     */
    protected function hooks()
    {
        add_action('admin_init', array($this, 'init'));
        $methodAddItem = 'add' . ucfirst($this->atts['type']) . 'Item';
        add_action('admin_menu', array($this, $methodAddItem));
    }

    /**
     * Register our setting to WP
     */
    public function init()
    {
        register_setting($this->atts['key'], $this->atts['key']);
    }

    public function addMenuItem()
    {
        $functionAdd = 'add_' . $this->atts['type'] . '_page';
        $functionAdd($this->atts['parent'], $this->atts['title'], $this->atts['title'], 'manage_options', $this->atts['key'], array($this, 'getItemPage'));
    }

    public function addSubmenuItem()
    {
        $functionAdd = 'add_' . $this->atts['type'] . '_page';
        $functionAdd($this->atts['parent'], $this->atts['title'], $this->atts['title'], 'manage_options', $this->atts['key'], array($this, 'getItemPage'));
    }

    /**
     * Admin page markup.
     */
    public function getItemPage()
    {
        Files\Files::getTemplate($this->template, true, $this->params , '');
    }


}