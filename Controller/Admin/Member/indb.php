<?php

namespace Controller\Admin\Member;

use App;
use Component\Exception\AlertException;
use Component\Exception\Member\MemberRegisterException;

/**
* 회원 관리 DB 처리 
*
*/
class IndbController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true; // 헤더, 푸터 생략 
	}
	
	public function index()
	{
		$in = request()->all();
		$member = App::load(\Component\Member\Member::class);
		try {
			switch($in['mode']) {
				// 회원 가입
				case "register" :
					$result = $member->data($in)
											->validator("register")
											->register();
											
					if ($result === false) { // 회원가입 실패
						throw new MemberRegisterException("회원가입 실패!");
					}
					
					// 회원 가입 성공
					go("admin/member/list", "parent");
					
					break;
			}
		} catch (MemberRegisterException $e) {
			echo $e;
		} catch (AlertException $e) {
			echo $e;
			exit;
		}
	}
}