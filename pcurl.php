<?php 

require_once("abscurl.php");
require_once("traitsetup.php");

class curl extends pCurl {

	use pCon;
	public function run() {

		// begin
		$this->ch = $this->create_multi_handler();

		// aggregate data
		$this->sessions = $this->get_sessions($this->request);
		foreach ($this->users as $value) {
			$user_vars = [];
			$servers = null;
			$token = null;
			foreach ($value as $k => $v) {
				if ($k == 'server')
					$servers = $v;
				else if ($k != 'server' && $k != 'session')
					$user_vars[] = $v;
				else if ($k == 'session')
					$token = $v;
			}
			$this->handles[] = $this->prepare_curl_handle($servers, $user_vars, $token);
		}

		// swarm!
		$this->execute_multiple_curl_handles($this->handles);
		file_put_contents("users.conf", "");
	}

	public function create_multi_handler() {
		return curl_multi_init();
	}

	public function prepare_curl_handles($server, $fields, $token) {
		   
		$h = [];
		if ($server == null)
			return $h;

		$h = $this->prepare_curl_handle($server, $fields, $token);
	   
		return $h;
	}

	// This is where we translate our user files into the curl call
	public function prepare_curl_handle($server_url, $fields, $token){

		$field = [];  
		foreach ($fields as $k => $v)
			$field = array_merge($field, array($k => $v));
		$field = array_merge($field, array("token" => $token));
		$handle = curl_init($server_url);
		$user_agent=$_SERVER['HTTP_USER_AGENT'];

		curl_setopt($handle, CURLOPT_TIMEOUT, 20);
		curl_setopt($handle, CURLOPT_URL, $server_url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($handle, CURLOPT_POST, 1);
		curl_setopt($handle, CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($field));
		curl_setopt($handle, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($handle, CURLOPT_ENCODING, "");
		curl_setopt($handle, CURLOPT_USERAGENT, $user_agent);

		$len = strlen(json_encode($field));
		curl_setopt($handle, CURLOPT_HTTPHEADER, array(														  
			'Content-Type' => $this->content_type,
			'Content-Length' => $len
			)
		);

		$this->page_contents = curl_exec($handle);
		return $handle;
	}

	public function add_handles($curl_multi_handler, $handles) {
		foreach($handles as $handle)
			curl_multi_add_handle($curl_multi_handler, $handle);
	}
   
	public function perform_multiexec($curl_multi_handler) {
   
		do {
			$mrc = curl_multi_exec($curl_multi_handler, $active);
		} while ($active > 0);
 
		while ($active && $mrc == CURLM_OK) {
			if (curl_multi_select($curl_multi_handler) != -1) {
				do {
					$mrc = curl_multi_exec($curl_multi_handler, $active);
				} while ($active > 0);
			}
		}
	}

	public function perform_curl_close($curl_multi_handler, $handles) {
	   
			  // is this necessary
		foreach($handles as $handle){
			curl_multi_remove_handle($curl_multi_handler, $handle);
		}
	 
		curl_multi_close($curl_multi_handler);
	}
   
	public function execute_multiple_curl_handles($handles) {
		$curl_multi_handler = $this->create_multi_handler();
		$this->add_handles($curl_multi_handler, $handles);
		$this->perform_multiexec($curl_multi_handler);
		$this->perform_curl_close($curl_multi_handler, $handles);
	}
  
}