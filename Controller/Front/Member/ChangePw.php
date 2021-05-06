<?php

namespace Controller\Front\Member;

use App;

/**
* 회원 비밀번호 변경 
*
*/
class ChangePwController extends \Controller\Front\Controller
{
	public function index()
	{
		$token = App::load(\Component\Token::class);
		$token->check(); // 토큰 만료 체크 
		
		if (!isset($_SESSION['changePw_memId']) || !$_SESSION['changePw_memId']) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		App::render("Member/change_pw", ["memId" => $_SESSION['changePw_memId']]);
	}
}