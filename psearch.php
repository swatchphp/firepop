<?php
require_once("abssearch.php");
require_once("pfiles.php");
require_once("traitsetup.php");

class user_search extends Redist implements search {


    function __construct() {
        $this->files = new filemngr();
    }

	public function detail_scrape() {
		$search = [];
		foreach ($this->users as $value) {
			if (!file_exists($this->path_user.$value) || filesize($this->path_user.$value) == 0 || $value == "." || $value == "..")
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
    
	// look for an email address amongst the
	// files that are in $this->path_user
	public function find_user_first($token) {
		$search = [];
		$search = $this->detail_scrape();
		krsort($search);
		if ($search[0] != null)
			return $search[0];
		return false;
	}

	// look for an email address amongst the
	// files that are in $this->path_user
	public function find_user_last($token) {
		$search = [];
		$search = $this->detail_scrape();
		ksort($search);
		if ($search[0] != null)
			return $search[0];
		return false;
	}

	// look for an email address amongst the
	// files that are in $this->path_user
	public function find_user_range($token) {
		$search = [];
		$search = $this->detail_scrape();
		krsort($search);
		if ($search != null)
			return $search;
		return false;
	}

	// look for an email address amongst the
	// files that are in "users.conf"
	public function find_user_queue($token) {
		$search = [];
		$y = sizeof($this->request);
		$search = $this->detail_scrape();
		if ($search != null)
			return $search;
		return false;
	}
}