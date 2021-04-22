<?php

namespace Component\Core;

/**
* GET, POST, FILE 조회 가능한 클래스 
*
*/
class Request
{
	private $get = []; // GET 데이터 
	private $post = []; // POST 데이터 
	private $files = []; // FILES 데이터 
	
	/**
	* $_GET, $_POST, $_FILES -> 직접 접근이 불가 
	*
	*/
	public function __construct()
	{
		$this->get = $_GET;
		$this->post = $_POST;
		$this->files = $_FILES;
		
		unset($_GET, $_POST, $_FILES);
	}
	
	public function get()
	{
		
	}
}