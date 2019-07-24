<?php

namespace Redist\files;

require_once 'files.php';
require_once 'file_class.php';

class filemngr implements files {
	
	static $omni;
    static $setup;
	function __construct() {
        self::$setup = new \Redist\setup\pConfig();
	}

	public static function user_log_dir() {
		// Default User Directory for configuation in pUrl	//
		return \Redist\files\file_class::user_log_dir();			//
	}
		
	public static function server_log_dir() {
		// Default Server Directory for configuation in pUrl	//
		return \Redist\files\file_class::server_log_dir();			//
	}
	
	public static function update_user() {
		$hash = hash("sha256", utf8_encode($_SERVER['REMOTE_ADDR']));
        return \Redist\files\file_class::save_user_log($hash);
    }
    
	public static function get_user_log() {
		$hash = hash("sha256", utf8_encode($_SERVER['REMOTE_ADDR']));
        return \Redist\files\file_class::get_user_log($hash);
    }
    
	public static function get_user_queue($filename = "users.conf") {
        return \Redist\files\file_class::get_user_queue($filename);
    }
    
	public static function save_user_log() {
		$hash = hash("sha256", utf8_encode($_SERVER['REMOTE_ADDR']));
        return \Redist\files\file_class::save_user_log($hash);
    }
    
	public static function get_server_log($filename = "server.conf") {
        return \Redist\files\file_class::get_server_log($filename);
    }
    
	public static function save_server_log($filename = "users.conf") {
        return \Redist\files\file_class::save_server_log($filename);
    }
    
	public static function set_content_type($type) {
        return \Redist\files\file_class::set_content_type($type);
    }
}