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
		
		App::render("Member/form", $_SESSION['member']);
	}
}