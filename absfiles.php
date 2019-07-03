<?php

interface files {
	
	// same as $this->save_user_log()
	public function update_user($token);
	// Save $this to file as JSON
	public function save_server_log($filename = "server.conf");
	// Return false if fil does not exist
	// Create $this-> from file is it does
	public function get_server_log($filename);
	// This saves a user's cookies and routes
	public function save_user_log($filename);
	// This retrieves the JSON of users in the
	// queue [users waiting to be given their request]
	public function get_user_queue($filename = "users.conf");
	// This retrieves a user's cookies
	public function get_user_log($filename);
}