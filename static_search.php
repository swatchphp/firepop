<?php

class static_search extends user_search implements search {
    
	public function find_user_first($token) {
        return parent::find_user_first($token);
    }
    
	public function find_user_last($token) {
        return parent::find_user_last($token);
    }

	public function find_user_range($token) {
        return parent::find_user_range($token);
    }

	public function find_user_queue($token) {
        return parent::find_user_queue($token);
    }
}