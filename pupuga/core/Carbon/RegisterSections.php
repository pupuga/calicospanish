<?php

namespace Pupuga\Core\Carbon;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


class RegisterSections
{
    public function register($config)
    {
        Container::make('post_meta', __('Meta sections'))
            ->show_on_post_type($config)
            ->add_fields(
                array(
                    Field::make('complex', 'sections_loop', __('Sections loop'))
                        ->set_layout('tabbed-horizontal')
                        ->add_fields(array(
                            Field::make('complex', 'subsections_loop', __('Subsections loop'))
                                ->set_layout('tabbed-horizontal')
                                ->add_fields(array(
                                    Field::make('rich_text', 'subsections_content', __('Content')),
                                    Field::make('text', 'subsections_class', __('Class'))->set_classes('carbon-field--half'),
                                    Field::make('text', 'subsections_style', __('Style'))->set_classes('carbon-field--half')
                                )),
                            Field::make('text', 'sections_class', __('Class'))->set_classes('carbon-field--half'),
                            Field::make('text', 'sections_style', __('Style'))->set_classes('carbon-field--half')
                        ))
                )
            );
    }
}