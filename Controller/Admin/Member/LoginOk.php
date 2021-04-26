<?php

namespace Controller\Admin\Member;

use App;
use Component\Exception\Member\LoginException;

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
		try {
			$in = request()->all();
			$member = App::load(\Component\Member\Member::class);
			
			if (!$in['memId'])
				throw new LoginException("아이디를 입력해 주세요.");
			
			if (!$in['memPw'])
				throw new LoginException("비밀번호를 입력해 주세요.");
			
			$member->login($in['memId'], $in['memPw']);
		} catch (LoginException $e) {
			echo $e;
		}
		
	}
}