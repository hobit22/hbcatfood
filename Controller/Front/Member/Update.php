<?php

namespace Controller\Front\Member;

use App;

/**
* 회원 정보 수정 
*
*/
class UpdateController extends \Controller\Front\Controller 
{
	public function index()
	{
		if (!isLogin()) {
			msg("회원만 접근이 가능합니다.", -1);
		}
		
		$member = App::load(\Component\Member\Member::class);
		$config = $member->getConfig();
		$data = array_merge($_SESSION['member'], $config);
		
		App::render("Member/form", $data);
	}
}