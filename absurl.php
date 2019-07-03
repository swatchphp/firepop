<?php
/*
 *  Redist is a distributional redirect
 *  system for servers to convert clicks
 *  into information at a central node.
 *  These cookies are saved at the root
 *  node. Each user is connected to the
 *  system with a redirect to this script.
 *  Then it is verified, to authenticate
 *  its source, and where it's going. 
 *  Many things, including SaaS can be
 *  done through this script. It is low
 *  in difficulty for server time to manage.
 *  Also, there is a DoS flood attack
 *  protection scheme in it. A queue is
 *  available to hold onto bandwidth until
 *  the server is readied to handle a new
 *  set of users to be distributed to the
 *  site they are waiting for. This all
 *  happens in microseconds. There is more
 *  as well. Read through the files and
 *  there will be an explanation on everything.
 *  
 *  This abstract has the function list of the
 *  entire purl.php script.
 * 
*/
abstract class pUser {

	// Validate incoming or outgoing address
	abstract public function spoof_check();
	// Trace variable content
	abstract public function trace($var);
	// Return closest addresses for analysis
	abstract public function return_relatives($addr);
	// The only function completely necessary.
	// Begins all transactions except for the
	// cURL ones.
	abstract public function parse_call();
	// Dissolves duplicate calls, and 
	// sends to patching if count($this->users) > 2000
	// in the queue
	abstract public function delay_connection();
	// Validate their is a REQUEST in the query
	// string
	abstract public function validate_request();
	// Create action to disperse earliest
	// user connected to their desired destination
	abstract public function send_request();
	// Checks spoofing, adds user to queue
	// runs patch_connection
	abstract public function patch_connection();
	// Check for valid incoming $host
	abstract public function match_server($host);
	// Turn SSL flag on and off
	abstract public function option_ssl($bool);
	// pass query string and return &server=value
	abstract public function get_servers($request);
	// pass query string and return &session=value
	abstract public function get_sessions($request);
	// count($this->users)
	abstract public function user_count();
	// Add user to the queue
	abstract public function update_queue();
	// Make abstract info count of who has been
	// going through the system. Images taken by IP block
	abstract public function disassemble_IP($host);
	// Find out if a new ABC block has come in to the
	// network.
	abstract public function make_relationships();
	// Checks for new refering site
	abstract public function add_referer();
	// Checks refer history for max size
	abstract public function remove_referer();
	// Returns users who have come from same ABC blocks
	abstract public function relative_count();

}