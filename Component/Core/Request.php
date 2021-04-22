<?php

namespace Component\Core;

/**
* GET, POST, FILE 조회 가능한 클래스 
*
*/
class Request
{
	private $_get = []; // GET 데이터 
	private $_post = []; // POST 데이터 
	private $_files = []; // FILES 데이터 
	
	/**
	* $_GET, $_POST, $_FILES -> 직접 접근이 불가 
	*
	*/
	public function __construct()
	{
		$this->_get = $_GET;
		$this->_post = $_POST;
		$this->_files = $_FILES;
		
		unset($_GET, $_POST, $_FILES);
		
		// 접속자 IP
		App::log("접속자 IP : " .$_SERVER['REMOTE_ADDR']);
		
		// GET 데이터 
		if ($this->_get) {
			App::log("REQUEST - GET : " . json_encode($this->_get));
		}
		
		// POST 데이터 
		if ($this->_post) {
			App::log("REQUEST - POST : " . json_encode($this->_post));
		}
		
		// FILES 데이터 
		if ($this->_files) {
			App::log("REQUEST - FILES : " . json_encode($this->_files));
		}
	}
	
	/**
	* GET 데이터 조회 
	*
	* @param String $key 해당 키값에 해당되는 GET 데이터, 없으면 전체 
	* @return Array|String
	*/
	public function get($key = null)
	{
		if ($key) {
			$this->_get[$key] = $this->_get[$key] ?? "";
			return $this->_get[$key];
		} else { // 없는 경우는 전체 get 값 반환 
			return $this->_get;
		}
	}
	
	/**
	* POST 데이터 조회 
	*
	* @param String $key 해당 키값에 해당되는 POST 데이터, 없으면 전체 
	* @return Array|String
	*/
	public function post($key = null)
	{
		if ($key) {
			$this->_post[$key] = $this->_post[$key] ?? "";
			return $this->_post[$key];
		} else {
			return $this->_post;
		}
	}
	
	/**
	* 업로드된 파일 정보($_FILES)
	*
	* @return Array
	*/
	public function files()
	{
		return $this->_files;
	}
	
	/**
	* GET, POST 데이터 통합 
	*
	* @return Array
	*/
	public function all()
	{
		return array_merge($this->_get, $this->_post);
	}
}