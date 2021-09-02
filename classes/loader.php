<?php namespace IFBB;

final class Loader {

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//
	// private
	//
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    private static $file = '';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	//
	// public
	//
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function add_inline_script($handle = '', $data = '', $position = 'after'){
		if(0 !== strpos($handle, 'ifbb_')){
			$handle = 'ifbb_' . $handle;
		}
		return wp_add_inline_script($handle, $data, $position);
	}
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	public static function enqueue_asset($handle = '', $src = '', $deps = []){
		if(0 !== strpos($handle, 'ifbb_')){
			$handle = 'ifbb_' . $handle;
		}
		$filename = basename($src);
		$file = plugin_dir_path(self::$file) . 'assets/' . $filename;
		if(!file_exists($file)){
			return;
		}
		$src = plugin_dir_url(self::$file) . 'assets/' . $filename;
		$ver = filemtime($file);
		$mimes = [
			'css' => 'text/css',
			'js' => 'application/javascript',
		];
		$filetype = wp_check_filetype($filename, $mimes);
		switch($filetype['type']){
			case 'application/javascript':
				wp_enqueue_script($handle, $src, $deps, $ver, true);
				break;
			case 'text/css':
				wp_enqueue_style($handle, $src, $deps, $ver);
				break;
		}
	}
	
	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function get_file(){
    	return self::$file;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    public static function load($file = ''){
    	self::$file = $file;
		foreach(glob(plugin_dir_path(self::$file) . 'classes/*.php') as $file){
			$class = basename($file, '.php');
			if('loader' === $class){
				continue;
			}
			$class = __NAMESPACE__ . '\\' . str_replace('-', '_', $class);
			require_once($file);
			if(is_callable([$class, 'load'])){
				call_user_func([$class, 'load']);
			}
		}	
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

}
