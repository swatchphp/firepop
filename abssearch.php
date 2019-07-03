<?php

interface search {

	// look for user first in, amongst the
	// files that are in $this->path_user (krsort[0])
	public function find_user_first($token);
	// look for user last in, amongst the
	// files that are in $this->path_user (ksort[0])
	public function find_user_last($token);
	// look for users amongst the
	// files that are in $this->path_user (krsort)
	public function find_user_range($token);
	// return all user requests without sorting
    public function find_user_queue($token);
    

}