<?php

namespace Redist\files;

require_once 'files.php';
require_once 'file_class.php';

class filemngr extends file_class implements files {
	
	static $omni;

	function __construct() {
		self::$omni = new file_class();
	}

	public static function update_user($token) {
        return self::$omni->update_user($token);
    }
    
	public static function get_user_log($filename) {
        return self::$omni->get_user_log($filename);
    }
    
	public static function get_user_queue($filename = "users.conf") {
        return self::$omni->get_user_queue($filename);
    }
    
	public static function save_user_log($filename = 'users.log') {
        return self::$omni->save_user_log($filename);
    }
    
	public static function get_server_log($filename = "server.conf") {
        return self::$omni->get_server_log($filename);
    }
    
	public static function save_server_log($filename = "users.conf") {
        return self::$omni->save_server_log($filename);
    }
    
	public static function set_content_type($type) {
        return self::$omni->set_content_type($type);
    }
}