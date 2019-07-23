<?php

namespace Redist\files;
require_once("pfiles.php");
require_once("absfiles.php");

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