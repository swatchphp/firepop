<?php

// static Function Requirements
require_once("static_url.php");
require_once("pcurl.php");
require_once("pfiles.php");
require_once("psearch.php");
require_once("abssetup.php");

class pURL extends Redist implements pUser {

	static $ch;
	static $user;
	static $users;
	// Required in REQUEST	//
	static $server;		//
	static $fields;
	// Required in REQUEST	//
	static $session;	//
	static $handles;
	// DO NOT PUT IN REQUEST//
	static $refer_by;	//
	static $relative;	//
	static $from_addr;	//
	// DO NOT PUT IN REQUEST//
	static $path_user;
	static $path_server;
	static $opt_ssl;
	static $page_contents;
	static $percent_diff;
	// Set for MAX delay in microseconds
	static $delay;
	// Set for MAX of history length of users
	static $max_history;
	static $content_type;
	static $timer;

	public static function create() {
		global $request;
	
	// The static functions for the search object
	// are in abssearch.php
		self::$search = new user_search();
	// The static functions for the file_class object
	// are in absfiles.php
		self::$files = new filemngr();
	// The static functions for the cURL object
	// are in abscurl.php
		self::$curl = new curl();
	// Get query string in either GET or POST
		$request = ($_SERVER['REQUEST_METHOD'] == "GET") ? ($_GET) : ($_POST);
	// Get incoming address for relations to other IP class visitors
		$request['host'] = $_SERVER['REMOTE_ADDR'];
	// There are a couple things we use in pUrl to look at our users //
		$request['refer_by'] = [];		//
		$request['relative'] = [];	//
		$request['from_addr'] = [];	//
		self::add_referer();			//
	// This is for listing all users in the queue
		self::$users = [];
	// Default is to turn off HTTPS:// but the program figures it out itself
	// for the most part, but if you do run into trouble, just run this static function
		self::option_ssl(false);
	// Percent of equal critical data points before return in self::$users
	// Change at any time
		self::$percent_diff = 0.75;
	// microsecond delay in wave static function
		self::$delay = 1175;
		self::$max_history = 10;
		self::$timer = time();
		self::$content_type = 'application/x-www-form-urlencoded';
	}

	public static function trace($var) {
		echo '<pre>';
		print_r($var);
	}

	// input the query string
	public static function get_servers($request) {
		global $request;
		if (!isset($request['server']))
			return null;
		self::$servers = $request['server'];
		return $request['server'];
	}

	// input the query string
	public static function get_sessions($request){
		global $request;
		if (!isset($request['session']))
			return null;
		return $request['session'];
	}

	// return the number of users present
	// and committed to sending info of.
	public static function user_count() {
		if (is_array(self::$users))
			return sizeof(self::$users);
		self::$users = [];
		return 0;
	}

	// make sure there was a request
	public static function validate_request() {
		global $request;
		if ($request != null && sizeof($request) != 1)
			return true;
		return false;
	}

	public static function send_request() {
		if (static_file::find_user_queue(self::$users[0]) == false)
			return false;
		$req = [];
		static_file::get_user_log(self::$users[0]);
		$options = array(
		  'http' => array(
			'header'  => array("Content-type: self::content_type"),
		        'method'  => 'POST',
		        'content' => http_build_query((array)self::$user)
		        )
		);
		array_shift(self::$users);
		
		file_put_contents("users.conf", json_encode(self::$users));
		$context = stream_context_create($options);
		$url = self::opt_ssl . self::$user->server;
		self::$page_contents = file_get_contents($url, false, $context);
		return true;
	}

	public static function update_queue() {
		global $request;
		self::update_user($request['session']);
		file_put_contents("users.conf", json_encode(self::$users));
	}

	public static function disassemble_IP($host) {
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
		self::make_relationships();
	}

	public static function make_relationships() {
		global $request;
		$new_relations = [];
		foreach (self::$users as $k => $v1) {
			if ($v1 != "from_addr" || $v1->session == $request['session'])
				continue;
			if ($request['from_addr']['A'] == $v1->A && $request['from_addr']['B'] == $v1->B &&
				$request['from_addr']['C'] == $v1->C)
				$new_relations[] = $v->session;
		}
		$unique = array_unique($new_relations);
		$request['relative'] = $new_relations;
	}

	public static function add_referer () {
		global $request;
		if (isset($_SERVER['HTTP_REFERER']))
			$request['refer_by'][] = $_SERVER['HTTP_REFERER'];
		else
			$request['refer_by'][] = "local";
		self::remove_referer();
		return true;
	}

	public static function remove_referer() {
		global $request;
		if (sizeof($request['refer_by']) == self::$max_history)
			array_shift($request['refer_by']);
		return sizeof($request['refer_by']);
	}

	//***
	public static function relative_count() {
		if (self::$users == null)
			self::$users = [];
		foreach (self::$users as $key => $val) {
			$x = self::$return_relatives($val);
			if ($x > 50) {
				self::$delay_connection();
				return true;
			}
		}
		return false;
	}

	// This is the only call you need
	// ***
	public static function parse_call() {
		global $request;
		self::spoof_check();
		if (count($request) == 4)
			exit();
		if (!self::match_server($request['host'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!self::match_server($request['server'])) {
			echo "Fatal Error: Target address unknown";
			exit();
		}
		
		$host = $request['host'];
		self::disassemble_IP($host);
		static_file::get_user_queue();
		self::$users[] = $request['session'];
		self::patch_connection();
	}

	// ***
	public static function spoof_check() {
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
	public static function match_server($host) {
		global $request;
		$trim = "";
		if ($host == "::1" || str_replace("localhost","",$host) == true)
			return true;
		if (($trim = str_replace("http://","",$host) == true))
			self::option_ssl(false);
		else if (($trim = str_replace("https://","",$host) == true))
			self::option_ssl(true);
		if (filter_var($host, FILTER_VALIDATE_URL) == false
			&& ($check_addr_list = gethostbynamel($host)) == false) {
			$spoof_list[] = parent::$request['host'];
			$spoof_list = array_unique($spoof_list);
			file_put_contents("spoof_list", $spoof_list);
			return false;
		}
		return true;
	}

	// ***
	public static function return_relatives($addr) {
	//	global $request;
		static_file::get_user_log($addr);
		$x = [];
		foreach (self::$user as $key) {
			if ($key != 'from_addr' || json_decode($key) == null)
				continue;
			if ($key->A == parent::$request['from_addr']['A']
				&& $key->B == parent::$request['from_addr']['B']
				&& $key->C == parent::$request['from_addr']['C'])
				$x[] = $relationships;
		}
		return $x;
	}

	// ***
	public static function delay_connection() {
		$x = [];
		if (sizeof(self::$users) > 2000) {
			if (self::relative_count() > 50) {
				static_file::save_user_log(parent::$request['session']);
				array_unique(self::$users);
				file_put_contents("users.conf", json_encode(self::$users));
				exit();
			}
		}
		array_unique(self::$users);
		if (self::$users[0] != parent::$request['session']) {
			$y = file_get_contents("users.conf");
			$x = json_decode($y);
			while ($x[0] != parent::$request['session'] && time() - self::$timer < 3000) {
				$y = file_get_contents("users.conf");
				$x = json_decode($y);	
			}
			self::$patch_connection();
		}
		array_splice(self::$users, array_search(parent::$request['session'], self::$users), 1);
		self::update_queue();
		return true;
	}

	//***
	public static function patch_connection() {
	//	global $request;
		if (sizeof(self::$users) > 0) {
			self::run_queue();
			static_file::save_user_log(parent::$request['session']);
			self::update_queue();
		}
		else {
			static_file::save_user_log(parent::$request['session']);
			if (self::$users == null)
				self::$users = [];
			file_put_contents("users.conf", json_encode(self::$users));		
		}
	}

	//***
	public static function run_queue() {
	//	global $request;
		if (static_file::find_user_queue(parent::$request['session']) != false)
			self::send_request();
	}

	public static function option_ssl($bool) {
		self::$opt_ssl = "https://";
		if ($bool == false)
			self::$opt_ssl = "http://";
		return $bool;
	}

	public static function print_page() {
		echo self::$page_contents;
	}

}