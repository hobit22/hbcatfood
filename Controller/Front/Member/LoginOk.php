<?php

namespace Controller\Front\Member;

use App;
use Component\Exception\Member\LoginException;

/**
* 로그인 처리 
*
*/
class LoginOkController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$member = App::load(\Component\Member\Member::class);
			
			if (!$in['memId'])
				throw new LoginException("아이디를 입력해 주세요.");
			
			if (!$in['memPw'])
				throw new LoginException("비밀번호를 입력해 주세요.");
			
			$result = $member->login($in['memId'], $in['memPw']);
			if ($result === false) { // 로그인 실패 
				throw new LoginException($member->errMessage);
			}
			
			// 로그인 성공시 메인페이지로 이동 
			go("main/index", "parent");
			
		} catch (LoginException $e) {
			echo $e;
		}
	}
}