<?php

namespace Controller\Front\Member;

use App;

/**
* 로그아웃 처리 
*
*/
class LogoutController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$member = App::load(\Component\Member\Member::class);
		$member->logout();
		go("member/login");
	}
}