<?php

namespace Controller\Front\Member;

use App;

/**
* 로그인 페이지 
*
*/
class LoginController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Member/login");
	}
}