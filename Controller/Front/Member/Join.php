<?php

namespace Controller\Front\Member;

use App;

/**
* 회원 가입 
*
*/
class JoinController extends \Controller\Front\Controller
{
	public function index()
	{
		$member = App::load(\Component\Member\Member::class);
		$config = $member->getConfig();
		App::render("Member/form", $config);
	}
}