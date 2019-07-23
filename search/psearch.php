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

class user_search extends Redist implements search {

	// look for an email address amongst the
	// files that are in self::path_user
	public static function find_user_first($token) {
		$search = [];
		$search = parent::detail_scrape();
		krsort($search);
		if ($search[0] != null)
			return $search[0];
		return false;
	}

	// look for an email address amongst the
	// files that are in self::path_user
	public static function find_user_last($token) {
		$search = [];
		$search = parent::detail_scrape();
		ksort($search);
		if ($search[0] != null)
			return $search[0];
		return false;
	}

	// look for an email address amongst the
	// files that are in self::path_user
	public static function find_user_range($token) {
		$search = [];
		$search = parent::detail_scrape();
		krsort($search);
		if ($search != null)
			return $search;
		return false;
	}

	// look for an email address amongst the
	// files that are in "users.conf"
	public static function find_user_queue($token) {
		$search = [];
		$y = sizeof(parent::$request);
		$search = parent::detail_scrape();
		if ($search != null)
			return $search;
		return false;
	}

}