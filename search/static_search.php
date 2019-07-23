<?php

namespace Redist\search;

spl_autoload_register(function ($class_name) {
	if (file_exists('/search/' . $class_name . 'php'))
    	include '/search/' . $class_name . '.php';
	if (file_exists('/url/' . $class_name . 'php'))
    	include '/url/' . $class_name . '.php';
	if (file_exists('/curl/' . $class_name . 'php'))
    	include '/curl/' . $class_name . '.php';
	if (file_exists('/files/' . $class_name . 'php'))
		include '/files/' . $class_name . '.php';
	else {
		echo 'Strange, the file is gone..';
		exit();
	}
});

class static_search extends user_search implements search {
    
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