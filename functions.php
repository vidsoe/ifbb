<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('ifbb_module')){
    function ifbb_module($class_name = ''){
        return new IFBB\Module($class_name);
    }
}

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

if(!function_exists('ifbb_settings_form')){
    function ifbb_settings_form($id = '', $title = ''){
        return new IFBB\Settings_Form($id, $title);
    }
}
