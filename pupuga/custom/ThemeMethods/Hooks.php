<?php

namespace Pupuga\Custom\ThemeMethods;

class Hooks
{

    public function __construct()
    {
	    //add_action('carbon_fields_register_fields', array($this, 'registerCarbonFields'));
    }

    public function registerCarbonFields()
    {
	}

}

new Hooks;