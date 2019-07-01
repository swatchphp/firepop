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
trait pCurl {

	abstract public function run();
	abstract public function create_multi_handler();
	abstract public function prepare_curl_handles($server, $fields, $token);
	abstract public function prepare_curl_handle($server_url, $fields, $token);
	abstract public function add_handles($curl_multi_handler, $handles);
	abstract public function perform_multiexec($curl_multi_handler);
	abstract public function perform_curl_close($curl_multi_handler, $handles);
	abstract public function execute_multiple_curl_handles($handles);
	abstract public function trace($var);

}