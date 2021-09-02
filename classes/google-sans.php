<?php namespace IFBB;

final class Google_Sans {

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//
	// public
	//
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function add_google_sans($json){
        $json[] = [
            'Google Sans' => [
                'fallback' => 'sans-serif',
                'variants' => ['regular', 'italic', '500', '500italic', '700', '700italic'],
            ],
        ];
        return $json;
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function after_setup_theme(){
        if(!defined('FL_THEME_VERSION')){
            return;
        }
        add_filter('fl_theme_get_google_json', [__CLASS__, 'add_google_sans']);
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function load(){
		add_action('after_setup_theme', [__CLASS__, 'after_setup_theme']);
        add_action('plugins_loaded', [__CLASS__, 'plugins_loaded']);
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function plugins_loaded(){
        if(!defined('FL_BUILDER_VERSION')){
            return;
    	}
        add_filter('fl_builder_get_google_json', [__CLASS__, 'add_google_sans']);
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

}
