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

class filemngr extends Redist implements files {
	
	// duplicate of save_user_log
	public static function update_user($token) {
		self::save_user_log($token);
	}

	// For curl operations
	public static function set_content_type($type) {
		return self::$content_type = $type;
    }
    
	//save $this
	public static function save_server_log($filename = "server.conf") {
		file_put_contents(self::$path_server.$filename, json_encode(self));
	}

	// save everything but ['server']
	public static function save_user_log($filename) {
		file_put_contents(self::$path_user.$filename, json_encode(parent::$request));			
	}

	// load everything
	public static function get_server_log($filename = "server.conf") {
		$fp = "";
		if (!file_exists(self::$path_server.$filename))
			return false;
		$dim = file_get_contents(self::$path_user.$filename);
		$decoded = json_decode($dim);
		foreach ($decoded as $k=>$v)
			self::$k = $v;
	}

	// load users in queue
	public static function get_user_queue($filename = "users.conf") {
		$fp = "";
		if (!file_exists($filename))
			return false;
		$dim = file_get_contents($filename);
		$users = json_decode($dim);
		$files = scandir(self::$path_user);
		if (sizeof((array)$files) > 0)
			self::$users = array_intersect($users, (array)$files);
	}

	// you'll find that in this file, we look
	// for SESSID a lot. It's called ['session']
	// to our script. It should be sent with the
	// incoming request.
	public static function get_user_log($filename) {
		//$filename = $_COOKIE['PHPSESSID'];
		$dim = file_get_contents(self::$path_user.$filename);
		self::$user = json_decode($dim);
	}

}