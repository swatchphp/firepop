<?php
include_once("abscurl.php");
include_once("pcurl.php");

class static_curls extends curl implements pCurl {

	public function execute_multiple_curl_handles($handles) {
        return parent::execute_multiple_curl_handles($handles);
    }
    
	public function perform_curl_close($curl_multi_handler, $handles) {
        return parent::perform_curl_close($curl_multi_handler, $handles);
    }

	public function perform_multi_exec($curl_multi_handler) {
        return parent::perform_multi_exec($curl_multi_handler);
    }

	public function add_handles($curl_multi_handler, $handles) {
        return parent::add_handles($curl_multi_handler, $handles);
    }
	// This is where we translate our user files into the curl call
	public function prepare_curl_handle($server_url, $fields, $token) {
        return parent::prepare_curl_handle($server_url, $fields, $token);
    }
	public function prepare_curl_handles($server, $fields, $token) {
        return parent::prepare_curl_handles($server, $fields, $token);
    }
    public function run() {
        return parent::run();
    }
    
	// For curl operations
	public function set_content_type($type) {
		return parent::set_content_type($type);
    }
    
	public function create_multi_handler() {
		return parent::create_multi_handler();
	}
}