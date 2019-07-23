<?php

namespace Redist\curl;

spl_autoload_register(function ($class_name) {
	if (file_exists('/search/' . $class_name . 'php'))
    	include '/search/' . $class_name . '.php';
	if (file_exists('/url/' . $class_name . 'php'))
    	include '/url/' . $class_name . '.php';
	if (file_exists('/curl/' . $class_name . 'php'))
    	include '/curl/' . $class_name . '.php';
	if (file_exists('/files/' . $class_name . 'php'))
		include '/files/' . $class_name . '.php';
	else {
		echo 'Strange, the file is gone..';
		exit();
	}
});

class static_curls extends curl implements pCurl {

	public static function execute_multiple_curl_handles($handles) {
        return parent::execute_multiple_curl_handles($handles);
    }
    
	public static function perform_curl_close($curl_multi_handler, $handles) {
        return parent::perform_curl_close($curl_multi_handler, $handles);
    }

	public static function perform_multi_exec($curl_multi_handler) {
        return parent::perform_multi_exec($curl_multi_handler);
    }

	public static function add_handles($curl_multi_handler, $handles) {
        return parent::add_handles($curl_multi_handler, $handles);
    }
	// This is where we translate our user files into the curl call
	public static function prepare_curl_handle($server_url, $fields, $token) {
        return parent::prepare_curl_handle($server_url, $fields, $token);
    }
	public static function prepare_curl_handles($server, $fields, $token) {
        return parent::prepare_curl_handles($server, $fields, $token);
    }
    public static function run() {
        return parent::run();
    }
    
	// For curl operations
	public static function set_content_type($type) {
		return parent::set_content_type($type);
    }
    
	public static function create_multi_handler() {
		return parent::create_multi_handler();
	}
}