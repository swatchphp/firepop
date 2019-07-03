<?php

abstract class search {

    
	// look for user first in, amongst the
	// files that are in $this->path_user (krsort[0])
	abstract public function find_user_first($token);
	// look for user last in, amongst the
	// files that are in $this->path_user (ksort[0])
	abstract public function find_user_last($token);
	// look for users amongst the
	// files that are in $this->path_user (krsort)
	abstract public function find_user_range($token);
	// return all user requests without sorting
    abstract public function find_user_queue($token);
    
	// This scrapes for information from all users at once
	// If $this->percent_diff == 0.75 && a user is that close
	// to the usre being scraped for, then that user will
	// be used, along any others that meet the description
	// compared to $this->percent_diff
//	abstract public function detail_scrape();

}