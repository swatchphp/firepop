<?php

require_once("absurl.php");
require_once("purl.php");

class static_url extends purl implements pUser {

    public function create() {
        return parent::create();
    }

	public function trace($var) {
        return parent::trace($var);
    }

	public function get_servers($request) {
		global $request;
        return parent::get_servers($request);
    }

	public function get_sessions($request) {
		global $request;
        return parent::get_sessions($request);
    }

	public function user_count() {
        return parent::user_count();
    }

	public function validate_request() {
        return parent::validate_request();
    }
    
	public function send_request() {
        return parent::send_request();
    }

	public function update_queue() {
        return parent::update_queue();
    }
    
	public function disassemble_IP($host) {
        return parent::disassemble_IP($host);
    }

	public function make_relationships() {
        return parent::make_relationships();
    }

	public function add_referer () {
        return parent::add_referer();
    }

	public function remove_referer() {
        return parent::remove_referer();
    }
    
	public function relative_count() {
        return parent::relative_count();
    }

	public function parse_call() {
        return parent::parse_call();
    }
    
	public function spoof_check() {
        return parent::spoof_check();
    }
    
	public function match_server($host) {
        return parent::match_server($host);
    } 
    
	public function return_relatives($addr) {
        return parent::return_relatives($addr);
    }
    
	public function delay_connection() {
        return parent::delay_connection();
    }
    
	public function patch_connection() {
        return parent::patch_connection();
    }
    
	public function run_queue() {
        return parent::run_queue();
    }
    
	public function option_ssl($bool) {
        return parent::option_ssl($bool);
    }
    
	public function print_page() {
        return parent::print_page();
    }
}