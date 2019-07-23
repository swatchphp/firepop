<?php

namespace Redist\url;

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

class static_url extends purl implements pUser {

    public static function create() {
        return parent::create();
    }

	public static function trace($var) {
        return parent::trace($var);
    }

	public static function get_servers() {
        return parent::get_servers();
    }

	public static function get_sessions() {

        return parent::get_sessions();
    }

	public static function user_count() {
        return parent::user_count();
    }

	public static function validate_request() {
        return parent::validate_request();
    }
    
	public static function send_request() {
        return parent::send_request();
    }

	public static function update_queue() {
        return parent::update_queue();
    }
    
	public static function disassemble_IP($host) {
        return parent::disassemble_IP($host);
    }

	public static function make_relationships() {
        return parent::make_relationships();
    }

	public static function add_referer () {
        return parent::add_referer();
    }

	public static function remove_referer() {
        return parent::remove_referer();
    }
    
	public static function relative_count() {
        return parent::relative_count();
    }

	public static function parse_call() {
        return parent::parse_call();
    }
    
	public static function spoof_check() {
        return parent::spoof_check();
    }
    
	public static function match_server($host) {
        return parent::match_server($host);
    } 
    
	public static function return_relatives($addr) {
        return parent::return_relatives($addr);
    }
    
	public static function delay_connection() {
        return parent::delay_connection();
    }
    
	public static function patch_connection() {
        return parent::patch_connection();
    }
    
	public static function run_queue() {
        return parent::run_queue();
    }
    
	public static function option_ssl($bool) {
        return parent::option_ssl($bool);
    }
    
	public static function print_page() {
        return parent::print_page();
    }
}