<?php namespace IFBB;

final class Utilities {

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//
	// public
	//
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function after_setup_theme(){
        if(!defined('FL_THEME_VERSION')){
            return;
        }
        add_action('customize_register', [__CLASS__, 'customize_register'], 20);
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function customize_register($wp_customize){
		$wp_customize->remove_section('fl-presets');
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function fl_theme_builder_after_render_content(){
		global $wp_query;
		$wp_query->in_the_loop = false;
		remove_action('fl_theme_builder_after_render_content', [__CLASS__, 'fl_theme_builder_after_render_content']);
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function fl_theme_builder_before_render_content(){
		global $wp_query;
		if(!$wp_query->in_the_loop){
			$wp_query->in_the_loop = true;
			add_action('fl_theme_builder_after_render_content', [__CLASS__, 'fl_theme_builder_after_render_content']);
		}
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function load(){
		add_action('after_setup_theme', [__CLASS__, 'after_setup_theme']);
        add_action('plugins_loaded', [__CLASS__, 'plugins_loaded']);
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function plugins_loaded(){
        if(defined('FL_BUILDER_VERSION')){
            add_action('wp_head', [__CLASS__, 'wp_head']);
			add_filter('fl_inline_editing_enabled', '__return_false');
			add_filter('fl_row_resize_settings', [__CLASS__, 'fl_row_resize_settings']);
			add_filter('walker_nav_menu_start_el', [__CLASS__, 'walker_nav_menu_start_el'], 10, 4);
    	}
		if(defined('FL_THEME_BUILDER_VERSION')){
            add_action('fl_theme_builder_before_render_content', [__CLASS__, 'fl_theme_builder_before_render_content']);
    	}
    }

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function fl_row_resize_settings($settings){
		$settings['userCanResizeRows'] = false;
		return $settings;
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function walker_nav_menu_start_el($item_output, $item, $depth, $args){
		if($item->object == 'fl-builder-template'){
			$item_output = $args->before;
			$item_output .= do_shortcode('[fl_builder_insert_layout id="' . $item->object_id . '"]');
			$item_output .= $args->after;
		}
		return $item_output;
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function wp_head(){
		if(array_key_exists('fl_builder', $_GET)){ ?>
			<style>
				.fl-block-col-resize {
					display: none;
				}
			</style><?php
		}
	}

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

}
