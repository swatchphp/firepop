<?php

require_once("static_url.php");
require_once("static_curl.php");
//require_once("purl.php");
require_once("static_search.php");
require_once("static_file.php");
require_once("pcurl.php");
require_once("abssetup.php");
$request = [];
class Redist {

	static $files;
	static $curl;
	static $search;
	static $user;
	function __construct() {
		$temp = new pCon();
	}

    function instance() {
		/*
        self::url = new static_url();
        self::search = new static_search();
        self::files = new static_file();
		self::curl = new static_curls();
		*/
		static_url::create();
		self::parse_call();
    }

	// This is the only call you need
	// ***
	public static function parse_call() {
		global $request;
		static_url::spoof_check();
		static_url::add_referer();
		static_url::get_servers($request);
		if (count($request) == 4)
			exit();
		if (!static_url::match_server($request['host'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!static_url::match_server(static_url::servers)) {
			echo "Fatal Error: Target address unknown";
			exit();
		}

		$host = $request['host'];
		//static_url::disassemble_IP($host);
		static_url::disassemble_IP($host);
		static_file::get_user_queue();
		static_url::get_sessions($request);
	//	static_url::users[] = $request['session'];
		static_url::patch_connection();

	}

	// This scrapes for information from all users at once
	// If self::$percent_diff == 0.75 && a user is that close
	// to the user being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to self::$percent_diff
	public static function detail_scrape() {
		global $request;
		$search = [];
		foreach (static_url::$users as $value) {
			if (!file_exists(static_file::$path_user.$value) || filesize(static_file::$path_user.$value) == 0 || $value == "." || $value == "..")
				continue;
			static_file::get_user_log($value);
			$x = 0;
			$y = sizeof((array)static_url::$user) + sizeof((array)static_url::$user->refer_by) + sizeof((array)static_url::$user->from_addr);
			foreach ($request as $k=>$v) {
                if($k == 'from_addr') {
					if (sizeof(array_intersect($k, (array)static_url::$user->$k)) > 2)
                        $x += 1;
                }
				else if (is_array($k) || is_object($k))
					$x += sizeof(array_intersect($v, (array)static_url::$user->$k));
				else if ($request[$k] == static_url::$user->$k && $x++)
					continue;
			}
			if ($x/$y > static_url::$percent_diff)
				$search[] = array($x => static_url::$user->session);
		}
		return $search;
	}
    
}

if (!isset($_SESSION))
	session_start();
//if (!isset($_COOKIE['token']) || $_COOKIE['PHPSESSID'] != $_COOKIE['token'])
//    setcookie("token", null, time() - 3600);
//setcookie("token", $_COOKIE['PHPSESSID'], time() + (86400 * 365), "/");

$handler = new Redist();
$handler->instance();
/**
*	To run the curl type;
*
*	$handler->files->update_queue();
*	if ($handler->url->user_count() > $x)
*		$handler->curl->run();
*
*/

/**
*	To run with single calls
*	
*	$handler->url->parse_call();
*	$handler->url->print_page();
*	echo '<script type="text/javascript">self.location = "' . $handler->url->opt_ssl . $handler->url->request["server"] . '"</script>';
*
*/