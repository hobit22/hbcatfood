<?php

namespace Controller\Admin\Member;

use App;

/**
* 관리자 로그인 처리 
*
*/
class LoginOkController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$in = request()->all();
		$member = App::load(\Component\Member\Member::class);
		$member->login($in['memId'], $in['memPw']);
	}
}