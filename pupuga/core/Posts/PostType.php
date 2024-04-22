<?php

namespace Pupuga\Core\Posts;

class PostType
{
    public $labels = array();
    public $parameters = array();
    public $args = array();
    public $postType;
    public $action;
    public $postId;

    public static function add($labels, $parameters)
    {
        $selfObject = new self($labels, __METHOD__);
        $selfObject->setDefaultArgs($selfObject->labels($selfObject->labels), $parameters);
        return $selfObject;
    }

    public static function removeFields($labels)
    {
        $selfObject = new self($labels,  __METHOD__);
        return $selfObject;
    }

    public function __construct($labels, $action)
    {
        $action_array = explode('::', $action);
        $this->action = $action_array[1];
        $this->labels = $this->prepare($labels);
        $this->postType = str_replace(' ', '_', strtolower($this->labels['many']));
    }

    private function prepare($labels)
    {
        if (is_array($labels) && count($labels) == 1) {
            $label = $labels[0];
        } elseif (!is_array($labels) && count($labels) > 0) {
            $label = $labels;
        }
        if (isset($label)) {
            $labels['many'] = $labels['single'] = $label;
        }
        return $labels;
    }

    // methods for add post_type - begin
    public function labels($labels)
    {
        return array(
            'name' => __($labels['many']),
            'singular_name' => __($labels['single']),
            'menu_name' => __($labels['many']),
            'name_admin_bar' => __($labels['single']),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New ' . $labels['single']),
            'new_item' => __('New ' . $labels['single']),
            'edit_item' => __('Edit ' . $labels['single']),
            'view_item' => __('View ' . $labels['single']),
            'all_items' => __('All ' . $labels['many']),
            'search_items' => __('Search ' . $labels['many']),
            'parent_item_colon' => __('Parent ' . $labels['many'] . ':'),
            'not_found' => __('No ' . $labels['many'] . ' found.'),
            'not_found_in_trash' => __('No ' . $labels['many'] . ' found in Trash.')
        );
    }

    public function setTaxonomies($parameter = array())
    {
        $this->args['taxonomies'] = $parameter;
        return $this;
    }

    public function setMenuPosition($parameter = 10)
    {
        $this->args['menu_position'] = $parameter;
        return $this;
    }

    public function setSupports($parameters = array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats'))
    {
        if (is_array($parameters) && $parameters != 0) {
	        $this->args['supports'] = $parameters;
        }
        return $this;
    }

    public function setMenuIcon($parameter = 'dashicons-list-view')
    {
        $this->args['menu_icon'] = $parameter;
        return $this;
    }

    private function setDefaultArgs($labels, $parameters)
    {
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => $this->postType),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => true
        );

        $this->args = array_merge($args , $parameters);

    }

    public function removeTitle()
    {
        $this->args[] = 'title';
        return $this;
    }

    public function removeEditor()
    {
        $this->args[] = 'editor';
        return $this;
    }

    public function filterPostID($postId)
    {
        $this->postId = $postId;
        return $this;
    }

    public function action()
    {
        $this->hook();
    }

    private function hook()
    {
        add_action('init', array($this, $this->action . 'Action'));
    }

    public function addAction()
    {
        register_post_type($this->postType, $this->args);
    }

    public function removeFieldsAction()
    {
        if ($this->postId != null && $this->postId != 0 && trim($this->postId) != '' && isset($_GET['post']) && $_GET['post'] != 0 && trim($_GET['post']) != '' && $_GET['post'] == $this->postId) {
            foreach ($this->args as $field) {
                remove_post_type_support($this->postType, $field);
            }
        }
    }

}