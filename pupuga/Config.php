<?php

namespace Pupuga;

abstract class Config
{
    protected $config;

    protected function __construct()
    {
        $this->config = array(
            // theme | modules | restapi | array('Correct', 'Media', 'SetConfig', 'PageMain', 'PageLogin', 'PageAdmin', 'Modules')
            'mode' => 'theme',

            /**
             * Register block
             */
            'registerCarbonFields' => array(
                // slug must start with common_pupuga_
                //    'common' => array(
                //        'Configuration' => array(
                //            'Parameters' => 'config',
                //            'Test edit' => 'textarea',
                //            'Loop edit' => array(
                //                'type' => 'complex',
                //                'set_layout' => 'tabbed-horizontal',
                //                'add_fields' => array(
                //                    array('text', 'title', 'Title'),
                //                    array('color', 'title_color', 'Title Color'),
                //                    array('image', 'image', 'Image')
                //                ),
                //            )
                //        )
                //    )
                'common' => array(
                    'Configuration' => array(
                        'Parameters' => 'config',
                        'Purchase Order Form' => 'file',
                        'GDPR Text' => 'rich_text'
                    )
                ),
                // false | array
                'sections' => array('page'),
                // false | array
                'sidebar' => array('page', 'post')
            ),

            // Example - add postType & taxonomy
            //
            // 'Single post type' => array(
            //      'many' => 'Many post types',
            //      'icon' => 'dashicons-calendar-alt',
            //      'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            //      'taxonomies' => array('post_tag', 'category'),
            //      'addTaxonomies' => array(array('single' => 'Single taxonomy', 'many' => 'Many taxonomies'))
            //      'parameters' => array()
            // )
            'registerPostTypesTaxonomies' => array(
                'Block' => array(
                    'many' => 'Blocks',
                    'icon' => 'dashicons-schedule',
                    'supports' => array('title'),
                    'taxonomies' => array(),
                    'addTaxonomies' => array(),
                    'parameters' => array('publicly_queryable' => false)
                ),
                'Source' => array(
                    'many' => 'Sources',
                    'icon' => 'dashicons-shield',
                    'supports' => array('title', 'page-attributes', 'editor', 'thumbnail'),
                    'taxonomies' => array(),
                    'addTaxonomies' => array(
                        array('single' => 'Type', 'many' => 'Types', 'params' => ['public' => false]),
                        array('single' => 'Level', 'many' => 'Levels', 'params' => ['public' => false]),
                        array('single' => 'Day', 'many' => 'Days', 'params' => ['public' => false])
                    ),
                    'parameters' => array('publicly_queryable' => false)
                ),
            ),

            // array
            'registerThumbnails' => array(
                '400x400' => true,
                '740x376' => true
            ),

            // boolean | array
            'registerWidgets' => true,

            // boolean
            'registerHeaderImage' => false,

            /**
             * Remove block
             */
            'removeRestApi' => false,
            'removeAdminMenuItems' => array(
                //'edit.php',
                //'edit-comments.php',
            ),
            'removeAdminPluginItems' => array(),

            /**
             * Add modules
             */
            'modules' => array(
                'Blocks',
                'Link',
                'Button',
                'Menu',
                //'Items',
                //'RestApi',
                //'Amp',
                'Movie',
                'Calicosources',
                'Plans',
                'Blog',
                'Sitemap',
                'Samplesources',
                'Doc'
            )
        );
    }
}