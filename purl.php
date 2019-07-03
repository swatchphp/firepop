<?php

// Function Requirements
require_once("static_url.php");
require_once("pcurl.php");
require_once("pfiles.php");
require_once("psearch.php");
require_once("abssetup.php");

class pURL extends Redist implements pUser {

	public $ch;
	public $user;
	public $users;
	// Required in REQUEST	//
	public $server;		//
	public $fields;
	// Required in REQUEST	//
	public $session;	//
	public $handles;
	// DO NOT PUT IN REQUEST//
	public $refer_by;	//
	public $relative;	//
	public $from_addr;	//
	// DO NOT PUT IN REQUEST//
	public $path_user;
	public $path_server;
	public $opt_ssl;
	public $page_contents;
	public $percent_diff;
	// Set for MAX delay in microseconds
	public $delay;
	// Set for MAX of history length of users
	public $max_history;
	public $content_type;
	public $timer;

	public function create() {
		global $request;
	
	// The functions for the search object
	// are in abssearch.php
		$this->search = new user_search();
	// The functions for the file_class object
	// are in absfiles.php
		$this->files = new filemngr();
	// The functions for the cURL object
	// are in abscurl.php
		$this->curl = new curl();
	// Get query string in either GET or POST
		$request = ($_SERVER['REQUEST_METHOD'] == "GET") ? ($_GET) : ($_POST);
	// Get incoming address for relations to other IP class visitors
		$request['host'] = $_SERVER['REMOTE_ADDR'];
	// There are a couple things we use in pUrl to look at our users //
		$request['refer_by'] = [];		//
		$request['relative'] = [];	//
		$request['from_addr'] = [];	//
		$this->add_referer();			//
	// This is for listing all users in the queue
		$this->users = [];
	// Default is to turn off HTTPS:// but the program figures it out itself
	// for the most part, but if you do run into trouble, just run this function
		$this->option_ssl(false);
	// Percent of equal critical data points before return in $this->users
	// Change at any time
		$this->percent_diff = 0.75;
	// microsecond delay in wave function
		$this->delay = 1175;
		$this->max_history = 10;
		$this->timer = time();
		$this->content_type = 'application/x-www-form-urlencoded';
	}

	public function trace($var) {
		echo '<pre>';
		print_r($var);
	}

	// input the query string
	public function get_servers($request) {
		global $request;
		if (!isset($request['server']))
			return null;
		$this->servers = $request['server'];
		return $request['server'];
	}

	// input the query string
	public function get_sessions($request){
		global $request;
		if (!isset($request['session']))
			return null;
		return $request['session'];
	}

	// return the number of users present
	// and committed to sending info of.
	public function user_count() {
		if (is_array($this->users))
			return sizeof($this->users);
		$this->users = [];
		return 0;
	}

	// make sure there was a request
	public function validate_request() {
		global $request;
		if ($request != null && sizeof($request) != 1)
			return true;
		return false;
	}

	public function send_request() {
		if ($this->files->find_user_queue($this->users[0]) == false)
			return false;
		$req = [];
		$this->files->get_user_log($this->users[0]);
		$options = array(
		  'http' => array(
			'header'  => array("Content-type: $this->content_type"),
		        'method'  => 'POST',
		        'content' => http_build_query((array)$this->user)
		        )
		);
		array_shift($this->users);
		
		file_put_contents("users.conf", json_encode($this->users));
		$context = stream_context_create($options);
		$url = $this->opt_ssl . $this->user->server;
		$this->page_contents = file_get_contents($url, false, $context);
		return true;
	}

	public function update_queue() {
		global $request;
		$this->update_user($request['session']);
		file_put_contents("users.conf", json_encode($this->users));
	}

	public function disassemble_IP($host) {
		global $request;
		if ($host == "::1")
			return;
		preg_match("/.\//", $trim, $output);
		if (is_array($output))
			echo json_encode($output);
		if ($output == null)
			return;
		$ipv4 = gethostbyname($output);
		preg_match_all("/(\d{1,3}|\.{0})/", $ipv4, $ip_pieces);
		$ip_pieces = $ip_pieces[0];
		$request['from_addr'] = [];
		$request['from_addr']['A'] = $ip_pieces[0];
		$request['from_addr']['B'] = $ip_pieces[1];
		$request['from_addr']['C'] = $ip_pieces[2];
		$request['from_addr']['D'] = $ip_pieces[3];
		$this->make_relationships();
	}

	public function make_relationships() {
		global $request;
		$new_relations = [];
		foreach ($this->users as $k => $v1) {
			if ($v1 != "from_addr" || $v1->session == $request['session'])
				continue;
			if ($request['from_addr']['A'] == $v1->A && $request['from_addr']['B'] == $v1->B &&
				$request['from_addr']['C'] == $v1->C)
				$new_relations[] = $v->session;
		}
		$unique = array_unique($new_relations);
		$request['relative'] = $new_relations;
	}

	public function add_referer () {
		global $request;
		if (isset($_SERVER['HTTP_REFERER']))
			$request['refer_by'][] = $_SERVER['HTTP_REFERER'];
		else
			$request['refer_by'][] = "local";
		$this->remove_referer();
		return true;
	}

	public function remove_referer() {
		global $request;
		if (sizeof($request['refer_by']) == $this->max_history)
			array_shift($request['refer_by']);
		return sizeof($request['refer_by']);
	}

	//***
	public function relative_count() {
		if ($this->users == null)
			$this->users = [];
		foreach ($this->users as $key => $val) {
			$x = $this->return_relatives($val);
			if ($x > 50) {
				$this->delay_connection();
				return true;
			}
		}
		return false;
	}

	// This is the only call you need
	// ***
	public function parse_call() {
		global $request;
		$this->spoof_check();
		if (count($request) == 4)
			exit();
		if (!$this->match_server($request['host'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!$this->match_server($request['server'])) {
			echo "Fatal Error: Target address unknown";
			exit();
		}
		
		$host = $request['host'];
		$this->disassemble_IP($host);
		$this->files->get_user_queue();
		$this->users[] = $request['session'];
		$this->patch_connection();
	}

	// ***
	public function spoof_check() {
		global $request;
		if (file_exists("spoof_list"))
			$pre_spoof_filter = file_get_contents("spoof_list");
		else
			return true;
		$spoof_list = json_decode($pre_spoof_filter);
		if ($spoof_list == null)
			return true;
		if (in_array($request['host'],$spoof_list))
			exit();
	}

	//***
	public function match_server($host) {
		global $request;
		$trim = "";
		if ($host == "::1" || str_replace("localhost","",$host) == true)
			return true;
		if (($trim = str_replace("http://","",$host) == true))
			$this->option_ssl(false);
		else if (($trim = str_replace("https://","",$host) == true))
			$this->option_ssl(true);
		if (filter_var($host, FILTER_VALIDATE_URL) == false
			&& ($check_addr_list = gethostbynamel($host)) == false) {
			$spoof_list[] = $request['host'];
			$spoof_list = array_unique($spoof_list);
			file_put_contents("spoof_list", $spoof_list);
			return false;
		}
		return true;
	}

	// ***
	public function return_relatives($addr) {
		global $request;
		$this->files->get_user_log($addr);
		$x = [];
		foreach ($this->user as $key) {
			if ($key != 'from_addr' || json_decode($key) == null)
				continue;
			if ($key->A == $request['from_addr']['A']
				&& $key->B == $request['from_addr']['B']
				&& $key->C == $request['from_addr']['C'])
				$x[] = $relationships;
		}
		return $x;
	}

	// ***
	public function delay_connection() {
		global $request;
		$x = [];
		if (sizeof($this->users) > 2000) {
			if ($this->relative_count() > 50) {
				$this->files->save_user_log($request['session']);
				array_unique($this->users);
				file_put_contents("users.conf", json_encode($this->users));
				exit();
			}
		}
		array_unique($this->users);
		if ($this->users[0] != $request['session']) {
			$y = file_get_contents("users.conf");
			$x = json_decode($y);
			while ($x[0] != $request['session'] && time() - $this->timer < 3000) {
				$y = file_get_contents("users.conf");
				$x = json_decode($y);	
			}
			$this->patch_connection();
		}
		array_splice($this->users, array_search($request['session'], $this->users), 1);
		$this->update_queue();
		return true;
	}

	//***
	public function patch_connection() {
		global $request;
		if (sizeof($this->users) > 0) {
			$this->run_queue();
			$this->files->save_user_log($request['session']);
			$this->update_queue();
		}
		else {
			$this->files->save_user_log($request['session']);
			if ($this->users == null)
				$this->users = [];
			file_put_contents("users.conf", json_encode($this->users));		
		}
	}

	//***
	public function run_queue() {
		global $request;
		if ($this->files->find_user_queue($request['session']) != false)
			$this->send_request();
	}

	public function option_ssl($bool) {
		$this->opt_ssl = "https://";
		if ($bool == false)
			$this->opt_ssl = "http://";
		return $bool;
	}

	public function print_page() {
		echo $this->page_contents;
	}

}