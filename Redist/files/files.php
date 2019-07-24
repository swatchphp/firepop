<?php
namespace Redist\files;

interface files {
	
	// same as self::save_user_log()
	public static function update_user($token);
	// Save $this to file as JSON
	public static function save_server_log($filename = "server.conf");
	// Return false if fil does not exist
	// Create self:: from file is it does
	public static function get_server_log($filename);
	// This retrieves the JSON of users in the
	// queue [users waiting to be given their request]
	public static function get_user_queue($filename = "users.conf");
	// This retrieves a user's cookies
	public static function get_user_log($filename);
}