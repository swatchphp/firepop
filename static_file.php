<?php

require_once("pfiles.php");
require_once("absfiles.php");

class static_file extends filemngr implements files {
    
	public function update_user($token) {
        return parent::update_user($token);
    }
    
	public function get_user_log($filename) {
        return parent::get_user_log($filename);
    }
    
	public function get_user_queue($token) {
        return parent::get_user_queue($token);
    }
    
	public function save_user_log($token) {
        return parent::save_user_log($token);
    }
    
	public function get_server_log($token) {
        return parent::get_server_log($token);
    }
    
	public function save_server_log($token) {
        return parent::save_server_log($token);
    }
    
	public function set_content_type($token) {
        return parent::set_content_type($token);
    }
}