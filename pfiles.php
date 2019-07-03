<?php

require_once("absfiles.php");
require_once("abssetup.php");

class filemngr extends files {
	
	// duplicate of save_user_log
	public function update_user($token) {
		$this->save_user_log($token);
	}

	// For curl operations
	public function set_content_type($type) {
		return $this->content_type = $type;
    }
    
	//save $this
	public function save_server_log($filename = "server.conf") {
		file_put_contents($this->path_server.$filename, json_encode($this));
	}

	// save everything but ['server']
	public function save_user_log($filename) {
		file_put_contents($this->path_user.$filename, json_encode($this->request));			
	}

	// load everything
	public function get_server_log($filename = "server.log") {
		$fp = "";
		if (!file_exists($this->path_server.$filename))
			return false;
		$dim = file_get_contents($this->path_user.$filename);
		$decoded = json_decode($dim);
		foreach ($decoded as $k=>$v)
			$this->$k = $v;
	}

	// load users in queue
	public function get_user_queue($filename = "users.conf") {
		$fp = "";
		if (!file_exists($filename))
			return false;
		$dim = file_get_contents($filename);
		$users = json_decode($dim);
		$files = scandir($this->path_user);
		if (sizeof((array)$files) > 0)
			$this->users = array_intersect($users, (array)$files);
	}

	// you'll find that in this file, we look
	// for SESSID a lot. It's called ['session']
	// to our script. It should be sent with the
	// incoming request.
	public function get_user_log($filename) {
		//$filename = $_COOKIE['PHPSESSID'];
		$dim = file_get_contents($this->path_user.$filename);
		$this->user = json_decode($dim);
	}

}