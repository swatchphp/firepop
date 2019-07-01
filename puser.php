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
	// Save $this to file as JSON
	abstract public function save_server_log($filename = "server.conf");
	// Return closest addresses for analysis
	abstract public function return_relatives($addr);
	// Singularly call instances of prepare_curl_handle()
	abstract public function prepare_curl_handles($server_url, $fields, $token);
	// This is where we translate our user files into the curl call
	abstract public function prepare_curl_handle($server_url, $fields, $token);
	// Instantiate multi-cURL
	abstract public function perform_multi_exec($curl_multi_handler);
	// Close off all cURL requests
	abstract public function perform_curl_close($curl_multi_handler, $handles);
	// The only function completely necessary.
	// Begins all transactions except for the
	// cURL ones.
	abstract public function parse_call();
	// Return false if fil does not exist
	// Create $this-> from file is it does
	abstract public function get_server_log($filename);
	// Disperse SaaS function
	abstract public function execute_multiple_curl_handles($handles);
	// Dissolves duplicate calls, and 
	// sends to patching if count($this->users) > 2000
	// in the queue
	abstract public function delay_connection();
	// Returns curl_multi_init() object
	abstract public function create_multi_handler();
	// Create multi cURL 
	abstract public function add_handles($curl_multi_handler, $handles);
	// Set content type of redirects
	abstract public function set_content_type($content_type);
	// Validate their is a REQUEST in the query
	// string
	abstract public function validate_request();
	// Create action to disperse earliest
	// user connected to their desired destination
	abstract public function send_request();
	// Begin cURL actions
	abstract public function run();
	// Checks spoofing, adds user to queue
	// runs patch_connection
	abstract public function patch_connection();
	// Check for valid incoming $host
	abstract public function match_server($host);
	// Turn SSL flag on and off
	abstract public function option_ssl($bool);
	// This saves a user's cookies and routes
	abstract public function save_user_log($filename);
	// This retrieves the JSON of users in the
	// queue [users waiting to be given their request]
	abstract public function get_user_queue($filename = "users.conf");
	// This retrieves a user's cookies
	abstract public function get_user_log($filename);
	// This scrapes for information from all users at once
	// If $this->percent_diff == 0.75 && a user is that close
	// to the usre being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to $this->percent_diff
	abstract public function detail_scrape();
	// look for user first in, amongst the
	// files that are in $this->path_user (krsort[0])
	abstract public function find_user_first($token);
	// look for user last in, amongst the
	// files that are in $this->path_user (ksort[0])
	abstract public function find_user_last($token);
	// look for users amongst the
	// files that are in $this->path_user (krsort)
	abstract public function find_user_range($token);
	// return all user requests without sorting
	abstract public function find_user_queue($token);
	// same as $this->save_user_log()
	abstract public function update_user($token);
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