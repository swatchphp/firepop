<?php

abstract class files {
	
	// same as $this->save_user_log()
	abstract public function update_user($token);
	// Save $this to file as JSON
	abstract public function save_server_log($filename = "server.conf");
	// Return false if fil does not exist
	// Create $this-> from file is it does
	abstract public function get_server_log($filename);
	// This saves a user's cookies and routes
	abstract public function save_user_log($filename);
	// This retrieves the JSON of users in the
	// queue [users waiting to be given their request]
	abstract public function get_user_queue($filename = "users.conf");
	// This retrieves a user's cookies
	abstract public function get_user_log($filename);
}