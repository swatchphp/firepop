<?php

require_once("static_url.php");
require_once("static_curl.php");
require_once("purl.php");
require_once("psearch.php");
require_once("pfiles.php");
require_once("pcurl.php");
require_once("abssetup.php");

class Redist {

	public $files;
	public $curl;
	public $search;
	public $user;
	function __construct() {
		$temp = new pCon();
	}

    function instance() {
        $this->url = new static_url();
        $this->search = new user_search();
        $this->files = new filemngr();
        $this->curl = new static_curls();
		$this->url->create();
		$this->parse_call();
    }

	// This is the only call you need
	// ***
	public function parse_call() {
		$this->url->spoof_check();
		$this->url->add_referer();
		$this->url->get_servers($this->url->request);
		if (count($this->url->request) == 4)
			exit();
		if (!$this->url->match_server($this->url->request['host'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!$this->url->match_server($this->url->servers)) {
			echo "Fatal Error: Target address unknown";
			exit();
		}

		$host = $this->url->request['host'];
		//$this->url->disassemble_IP($host);
		$this->url->disassemble_IP($host);
		$this->files->get_user_queue();
		$this->url->get_sessions($this->url->request);
	//	$this->url->users[] = $this->url->request['session'];
		$this->url->patch_connection();

	}

	// This scrapes for information from all users at once
	// If $this->percent_diff == 0.75 && a user is that close
	// to the user being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to $this->percent_diff
	public function detail_scrape() {
		$search = [];
		foreach ($this->url->users as $value) {
			if (!file_exists($this->files->path_user.$value) || filesize($this->files->path_user.$value) == 0 || $value == "." || $value == "..")
				continue;
			$this->files->get_user_log($value);
			$x = 0;
			$y = sizeof((array)$this->user) + sizeof((array)$this->user->refer_by) + sizeof((array)$this->user->from_addr);
			foreach ($this->request as $k=>$v) {
                if($k == 'from_addr') {
                    foreach ($v as $rel) {
                        if ($rel == $value->request->$k->$v->$rel)
                            $x += 1;
                    }
                }
				else if (is_array($k) || is_object($k))
					$x += sizeof(array_intersect($v, (array)$this->user->$k));
				else if ($this->request[$k] == $this->user->$k && $x++)
					continue;
			}
			if ($x/$y > $this->percent_diff)
				$search[] = array($x => $this->user->session);
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