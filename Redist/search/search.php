<?php

namespace Redist\search;

require_once 'search_ab.php';

class search implements search_ab {
    
	public static function find_user_first($token) {
        return parent::find_user_first($token);
    }
    
	public static function find_user_last($token) {
        return parent::find_user_last($token);
    }

	public static function find_user_range($token) {
        return parent::find_user_range($token);
    }

	public static function find_user_queue($token) {
        return parent::find_user_queue($token);
    }
}