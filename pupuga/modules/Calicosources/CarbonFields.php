<?php

namespace Pupuga\Modules\Calicosources;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class CarbonFields
{
    public function __construct()
    {
    }

    public function registerCarbonFields()
    {
        $this->registerTypesCarbonFields();
        $this->registerLevelsCarbonFields();
        $this->registerPostTypeCarbonFields();
        $this->registerUserFields();
    }

    private function registerTypesCarbonFields()
    {
        Container::make('term_meta', 'Types properties')
            ->where('term_taxonomy', '=', 'type')
            ->add_fields(array(
                Field::make('rich_text', 'sources_types_content_on_resources_page', 'Content on resources page'),
                Field::make('image', 'sources_types_passive_icon', 'Resource\'s tab icon')->set_help_text('If this icon not set, resources does not show'),
                Field::make('image', 'sources_types_active_icon', 'Resource\'s tab icon activated'),
                Field::make('image', 'sources_types_step_icon', 'Step Icon'),
                Field::make('text', 'sources_types_buttons_text', 'Buttons text')
            ));
    }

    private function registerLevelsCarbonFields()
    {
        Container::make('term_meta', 'Levels properties')
            ->where('term_taxonomy', '=', 'level')
            ->add_fields(array(
                Field::make('set', 'sources_levels_access', 'Access')
                    ->add_options( array(
                        'access_trial' => 'Trial',
                    ) ),
                Field::make('text', 'sources_levels_title', 'Title'),
                Field::make('text', 'sources_levels_title_plus', 'Title plus'),
                Field::make('text', 'sources_levels_counters', 'Counters'),
                Field::make('image', 'sources_levels_image', 'Image'),
                Field::make('rich_text', 'sources_levels_objectives', 'Objectives'),
                Field::make('rich_text', 'sources_levels_need', 'You will need')
            ));
    }

    private function registerPostTypeCarbonFields()
    {
        Container::make('post_meta', 'Source data')
            ->where('post_type', '=', 'sources')
            ->add_fields(array(
                Field::make('complex', 'modules')
                    ->set_layout('tabbed-horizontal')
                    ->add_fields('video_hosting', array(
                        Field::make('text', 'video_hosting_url')
                    ))
                    ->add_fields('audio', array(
                        Field::make('file', 'source_audio')->set_type(array('audio'))
                    ))
                    ->add_fields('gallery', array(
                        Field::make('media_gallery', 'source_media')->set_type(array('image', 'video'))
                    ))
                    ->add_fields('redactor', array(
                        Field::make('rich_text', 'source_redactor')
                    ))
            ));

        Container::make('post_meta', 'Additional data')
            ->where('post_type', '=', 'sources')
            ->add_fields(array(
                Field::make('text', 'additional_data_title', 'Title'),
                Field::make('text', 'additional_data_subtitle', 'Subtitle'),
                Field::make('textarea', 'additional_data_description', 'Description'),
            ));

        Container::make('post_meta', 'Source buttons')
            ->where('post_type', '=', 'sources')
            ->add_fields(array(
                Field::make('file', 'source_pdf', 'PDF')
            ));

        Container::make('post_meta', 'Link buttons')
            ->where('post_type', '=', 'sources')
            ->add_fields(array(
                Field::make('text', 'source_link', 'Link'),
                Field::make('set', 'link_buttons_buttons', 'Buttons')
                    ->add_options(array(
                        'buy' => 'Buy',
                        'play' => 'Play',
                    ))
            ));
    }

    private function registerUserFields()
    {
        Container::make('user_meta', 'Additional user data')
            ->add_fields( array(
                Field::make('image', 'pupuga_avatar', 'User avatar')
            ));
    }

}