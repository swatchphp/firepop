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
 *  This trait of Redist is to create the SaaS
 *  functionality in the full file, purl.php
 * 
*/
abstract class pCurl {

	// Set content type of redirects
	abstract public function set_content_type($content_type);
	// Singularly call instances of prepare_curl_handle()
	abstract public function prepare_curl_handles($server_url, $fields, $token);
	// This is where we translate our user files into the curl call
	abstract public function prepare_curl_handle($server_url, $fields, $token);
	// Instantiate multi-cURL
	abstract public function perform_multi_exec($curl_multi_handler);
	// Close off all cURL requests
	abstract public function perform_curl_close($curl_multi_handler, $handles);
	// Disperse SaaS function
	abstract public function execute_multiple_curl_handles($handles);
	// Begin cURL actions
	abstract public function run();
	// Returns curl_multi_init() object
	abstract public function create_multi_handler();
	// Create multi cURL 
	abstract public function add_handles($curl_multi_handler, $handles);

}