<?php

namespace Redist;

spl_autoload_register(function ($class_name) {
	if (file_exists($class_name . '.php')) {
		include $class_name . '.php';
	}
	else {
		echo 'Strange, the file ' . $class_name . ' is gone..';
		exit();
	}
});

class Redist {

	static $files;
	static $curl;
	static $search;
	static $user;
	static $url;

// Create an instance with this function
    function instance() {
	// The static functions for the search object
	// are in abssearch.phpc
		self::$search = new \Redist\search\search();
	// The static functions for the file_class object
	// are in absfiles.php
		self::$files = new \Redist\files\filemngr();
	// The static functions for the cURL object
	// are in abscurl.php
		//self::$curl = new \Redist\curl\curl();
		self::$url = new \Redist\url\pURL();
		self::$url->create();
		self::parse_call();
    }

	// Everything Begins Here
	// ***
	public static function parse_call() {
		self::$url->spoof_check();
		echo "$ ";
	//	self::$url->add_referer();
		echo "$$ ";
		self::$url->get_servers();
		echo "$$$ ";
		if (isset($url->request) && sizeof(self::$url->request) == 4)
			exit();
		if (!self::$url->match_remote_server()) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (isset(self::$url->request->METHOD->target_pg) && !self::$url->match_target_server(self::$url->request->METHOD->target_pg)) {
			echo "Fatal Error: Target address unknown";
			exit();
		}
		else {
			echo 'No target address';
		}

		$host = $_SERVER['REMOTE_ADDR'];
		self::$url->disassemble_IP($host);
		echo "$ ";
		self::$files->get_user_queue();
		echo "$$ ";
		self::$url->get_sessions();
		echo "$$$ ";
		self::$url->patch_connection();
		echo "$$$$ ";

	}

	// This scrapes for information from all users at once
	// If self::$percent_diff == 0.75 && a user is that close
	// to the user being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to self::$percent_diff
	public static function detail_scrape() {
		$search = [];
		foreach (self::$url->$users->cookie_sheet as $value) {
			if (!file_exists(files\static_files::$path_user.$value) || filesize(files\static_files::$path_user.$value) == 0 || $value == "." || $value == "..")
				continue;
			files\static_files::get_user_log($value);
			$x = 0;
			$y = sizeof((array)self::$url->$user) + sizeof((array)self::$url->$user->cookie_sheet->refer_by) + sizeof((array)self::$url->$user->cookie_sheet->from_addr);
			foreach (parent::$request as $k=>$v) {
                if($k == 'from_addr') {
					if (sizeof(array_intersect($k, (array)self::$url->$user->cookie_sheet->$k)) > 2)
                        $x += 1;
                }
				else if (is_array($k) || is_object($k))
					$x += sizeof(array_intersect($v, (array)self::$url->$user->cookie_sheet->$k));
				else if (parent::$request['cookie_sheet'][$k] == self::$url->$user->cookie_sheet->$k && $x++)
					continue;
			}
			if ($x/$y > self::$url->$percent_diff)
				$search[] = array($x => self::$url->$user->cookie_sheet->session);
		}
		return $search;
	}
    
}

if (!isset($_SESSION))
	session_start();
//if (!isset($_COOKIE['token']) || $_COOKIE['PHPSESSID'] != $_COOKIE['token'])
//    setcookie("token", null, time() - 3600);
//setcookie("token", $_COOKIE['PHPSESSID'], time() + (86400 * 365), "/");

$handler = new \Redist\Redist();
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