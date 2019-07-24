<?php

namespace Redist\url;

require_once 'purl.php';
require_once 'puser.php';

class static_url implements pUser {

    public static function create() {
        return create();
    }

	public static function trace($var) {
        return trace($var);
    }

	public static function get_servers() {
        return get_servers();
    }

	public static function get_sessions() {

        return get_sessions();
    }

	public static function user_count() {
        return user_count();
    }

	public static function validate_request() {
        return validate_request();
    }
    
	public static function send_request() {
        return send_request();
    }

	public static function update_queue() {
        return update_queue();
    }
    
	public static function disassemble_IP($host) {
        return disassemble_IP($host);
    }

	public static function make_relationships() {
        return make_relationships();
    }

	public static function add_referer () {
        return add_referer();
    }

	public static function remove_referer() {
        return remove_referer();
    }
    
	public static function relative_count() {
        return relative_count();
    }

	public static function parse_call() {
        return parse_call();
    }
    
	public static function spoof_check() {
        return spoof_check();
    }
    
	public static function match_remote_server() {
        return match_remote_server();
    } 
    
	public static function match_target_server() {
        return match_target_server();
    } 
    
	public static function return_relatives($addr) {
        return return_relatives($addr);
    }
    
	public static function delay_connection() {
        return delay_connection();
    }
    
	public static function patch_connection() {
        return patch_connection();
    }
    
	public static function run_queue() {
        return run_queue();
    }
    
	public static function option_ssl($bool) {
        return option_ssl($bool);
    }
    
	public static function print_page() {
        return print_page();
    }
}