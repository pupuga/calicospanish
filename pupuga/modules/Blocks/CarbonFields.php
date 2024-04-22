<?php

namespace Pupuga\Modules\Blocks;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class CarbonFields
{
    public function registerCarbonFields()
    {
        Container::make('post_meta', 'Block Data')
            ->where('post_type', '=', 'blocks')
            ->add_fields(array(
                Field::make('text', 'block_class', 'Block class')->set_classes('carbon-field--half'),
                Field::make('text', 'block_style', 'Block style')->set_classes('carbon-field--half'),
                Field::make('complex', 'rows', 'Rows')
                    ->add_fields(array(
                        Field::make('select', 'row_width', 'Row width')
                            ->add_options(array(
                                'full' => 'Full',
                                'half' => 'Half',
                            )),
                        Field::make('text', 'row_class', 'Row class')->set_classes('carbon-field--half'),
                        Field::make('text', 'row_style', 'Row style')->set_classes('carbon-field--half'),
                        Field::make('complex', 'modules')
                            ->set_layout('tabbed-horizontal')
                            ->add_fields('redactor', array(
                                    Field::make('text', 'module_class', 'Module class')->set_classes('carbon-field--half'),
                                    Field::make('text', 'module_style', 'Module style')->set_classes('carbon-field--half'),
                                    Field::make('rich_text', 'redactor'))
                            )
                            ->add_fields('items', array(Field::make('complex', 'item', '')->add_fields($this->setItemsFields())))
                            ->add_fields('tabs', array(
                                    Field::make('select', 'field_type', 'Type')
                                        ->add_options(array(
                                            'type_tabs' => 'Headers',
                                            'type_collapse' => 'Collapse',
                                            'type_timeline' => 'Time Line'
                                        )),
                                    Field::make('complex', 'tabs', '')->add_fields($this->setTabsFields()),
                                )
                            )
                            ->add_fields('audio', array(
                                    Field::make('select', 'audio_module__color_style', 'Audio color style')->add_options($this->setLevels())->set_classes('carbon-field--half'),
                                    Field::make('text', 'audio_module__title', 'Title')->set_classes('carbon-field--half'),
                                    Field::make('complex', 'audio_module__items', '')->add_fields($this->setAudioFields()),
                                )
                            )
                            ->add_fields('list', array(Field::make('complex', 'list', '')->add_fields($this->setListFields())))
                    )),
            ));
    }

    private function setItemsFields()
    {
        $fields = array(
            Field::make('image', 'item_image', 'Item image')->set_classes('carbon-field--one-fifth'),
            Field::make('rich_text', 'item_text', 'Item text')->set_classes('carbon-field--four-fifth')
        );

        return $fields;
    }

    private function setTabsFields()
    {
        $fields = array(
            Field::make('text', 'tab_title', 'Tab title')->set_classes('carbon-field--one-fifth'),
            Field::make('rich_text', 'tab_text', 'Tab text')->set_classes('carbon-field--four-fifth')
        );

        return $fields;
    }

    private function setAudioFields()
    {
        $fields = array(
            Field::make('text', 'audio_module__title', 'Title'),
            Field::make('file', 'audio_module__image', 'Image')->set_classes('carbon-field--half'),
            Field::make('file', 'audio_module__file', 'Audio file')->set_classes('carbon-field--half'),
        );

        return $fields;
    }

    private function setLevels()
    {
        $levels = array();
        $levelsObjects = get_terms(array(
            'taxonomy' => 'level',
            'hide_empty' => false,
            'parent' => 0
        ));
        if (is_array($levelsObjects) && count($levelsObjects) > 0) {
            foreach ($levelsObjects as $level) {
                $levels[$level->slug] = $level->name;
            }
        }

        return $levels;
    }

    private function setListFields()
    {
        $fields = array(
            Field::make('rich_text', 'list_items_editor', 'Item editor')->set_classes('carbon-field--half'),
            Field::make('complex', 'list_items_loop', 'List')->set_classes('carbon-field--half')
                ->add_fields(array(
                    Field::make('text', 'list_items_label', 'Label')->set_classes('carbon-field--one-fifth'),
                    Field::make('text', 'list_items_data', 'Data')->set_classes('carbon-field--four-fifth')
                ))
        );

        return $fields;
    }

}