<?php

namespace Redist\files;

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

class static_file extends filemngr implements files {
    
	public static function update_user($token) {
        return parent::update_user($token);
    }
    
	public static function get_user_log($filename) {
        return parent::get_user_log($filename);
    }
    
	public static function get_user_queue($filename = "users.conf") {
        return parent::get_user_queue($filename);
    }
    
	public static function save_user_log($filename) {
        return parent::save_user_log($filename);
    }
    
	public static function get_server_log($filename = "server.conf") {
        return parent::get_server_log($filename);
    }
    
	public static function save_server_log($filename = "users.conf") {
        return parent::save_server_log($filename);
    }
    
	public static function set_content_type($type) {
        return parent::set_content_type($type);
    }
}