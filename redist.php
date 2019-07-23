<?php

namespace Redist;

require_once("static_url.php");
require_once("static_curl.php");
//require_once("purl.php");
require_once("static_search.php");
require_once("static_file.php");
require_once("pcurl.php");
require_once("abssetup.php");

class Redist {

	static $files;
	static $curl;
	static $search;
	static $user;
	static $request;
	use url;
// Create an instance with this function
    function instance() {
		// The static functions for the search object
		// are in abssearch.php
			self::$search = new url\user_search();
		// The static functions for the file_class object
		// are in absfiles.php
			self::$files = new files\filemngr();
		// The static functions for the cURL object
		// are in abscurl.php
			self::$curl = new curl();
		url\static_url::create();
		self::parse_call();
    }

	// Everything Begins Here
	// ***
	public static function parse_call() {
		url\static_url::spoof_check();
		url\static_url::add_referer();
		url\static_url::get_servers(self::$request);
		if (count(self::$request) == 4)
			exit();
		if (!url\static_url::match_server(self::$request['cookie_sheet']['user_addr'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!url\static_url::match_server(url\static_url::$servers)) {
			echo "Fatal Error: Target address unknown";
			exit();
		}

		$host = self::$request['cookie_sheet']['user_addr'];
		url\static_url::disassemble_IP($host);
		files\static_files::get_user_queue();
		url\static_url::get_sessions(self::$request);
		url\static_url::patch_connection();

	}

	// This scrapes for information from all users at once
	// If self::$percent_diff == 0.75 && a user is that close
	// to the user being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to self::$percent_diff
	public static function detail_scrape() {
		$search = [];
		foreach (url\static_url::$users->cookie_sheet as $value) {
			if (!file_exists(files\static_files::$path_user.$value) || filesize(files\static_files::$path_user.$value) == 0 || $value == "." || $value == "..")
				continue;
			files\static_files::get_user_log($value);
			$x = 0;
			$y = sizeof((array)url\static_url::$user) + sizeof((array)url\static_url::$user->cookie_sheet->refer_by) + sizeof((array)url\static_url::$user->cookie_sheet->from_addr);
			foreach (parent::$request as $k=>$v) {
                if($k == 'from_addr') {
					if (sizeof(array_intersect($k, (array)url\static_url::$user->cookie_sheet->$k)) > 2)
                        $x += 1;
                }
				else if (is_array($k) || is_object($k))
					$x += sizeof(array_intersect($v, (array)url\static_url::$user->cookie_sheet->$k));
				else if (parent::$request['cookie_sheet'][$k] == url\static_url::$user->cookie_sheet->$k && $x++)
					continue;
			}
			if ($x/$y > url\static_url::$percent_diff)
				$search[] = array($x => url\static_url::$user->cookie_sheet->session);
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