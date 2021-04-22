<?php

namespace Controller\Front\Error;

use App;

/**
* 없는 페이지 Controller 
* 상태코드 404 
* http_response_code 
*/
class E404Controller extends \Controller\Front\Controller
{
	public function __construct()
	{
		http_response_code(404);
		$this->setHeader("error")
			   ->setFooter('error');
	}
	
	public function index()
	{
		App::render("Error/404", $_SESSION);
	}
}