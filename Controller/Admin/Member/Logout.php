<?php

namespace Controller\Admin\Member;

use App;

/**
* 로그아웃 처리 
* 
*/
class LogoutController extends \Controller\Admin\Controller 
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$member = App::load(\Component\Member\Member::class);
		$member->logout();
		go("admin/member/login");
	}
}