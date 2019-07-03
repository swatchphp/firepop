<?php

require_once("purl.php");
require_once("pcurl.php");
require_once("psearch.php");
require_once("pfiles.php");
require_once("psetup.php");

class Redist {

	function __construct() {
		$temp = new pCon();
    }
    
    function instance() {
        $this->url = new pURL();
        $this->search = new user_search();
        $this->files = new filemngr();
        $this->curl = new curl();
	    $this->url->create();
	    $this->parse_call();
    }

	// This is the only call you need
	// ***
	public function parse_call() {
		$this->url->spoof_check();
		$this->url->add_referer();
		if (count($this->url->request) == 4)
			exit();
		if (!$this->url->match_server($this->url->request['host'])) {
			echo "Fatal Error: Your address is unknown";
			exit();
		}
		else if (!$this->url->match_server($this->url->request['server'])) {
			echo "Fatal Error: Target address unknown";
			exit();
		}
		
		$host = $this->url->request['host'];
		$this->url->disassemble_IP($host);
		$this->files->get_user_queue();
		$this->url->users[] = $this->url->request['session'];
		$this->url->patch_connection();
	}

}

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