<?php

namespace Controller\Admin\Member;

use App;

/**
* 관리자 로그인
*
*/
class LoginController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$this->addCss(["login"]); // assets/admin/css/login.css
	}
	
	public function mainMenu() {}
	
	public function index()
	{
		App::render("Member/login");
	}
}