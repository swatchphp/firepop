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
 *  This pus the function list of the
 *  entire purl.php script.
 * 
*/
interface pUser {

	// Validate incoming or outgoing address
	public function spoof_check();
	// Trace variable content
	public function trace($var);
	// Return closest addresses for analysis
	public function return_relatives($addr);
	// Dissolves duplicate calls, and 
	// sends to patching if count($this->users) > 2000
	// in the queue
	public function delay_connection();
	// Create action to disperse earliest
	// user connected to their desired destination
	public function send_request();
	// Checks spoofing, adds user to queue
	// runs patch_connection
	public function patch_connection();
	// Check for valid incoming $host
	public function match_server($host);
	// Turn SSL flag on and off
	public function option_ssl($bool);
	// pass query string and return &server=value
	public function get_servers($request);
	// pass query string and return &session=value
	public function get_sessions($request);
	// count($this->users)
	public function user_count();
	// Add user to the queue
	public function update_queue();
	// Make pufo count of who has been
	// going through the system. Images taken by IP block
	public function disassemble_IP($host);
	// Find out if a new ABC block has come in to the
	// network.
	public function make_relationships();
	// Checks for new refering site
	public function add_referer();
	// Checks refer history for max size
	public function remove_referer();
	// Returns users who have come from same ABC blocks
	public function relative_count();

}