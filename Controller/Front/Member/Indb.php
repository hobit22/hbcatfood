<?php

namespace Controller\Front\Member;

use App;
use Component\Exception\Member\MemberRegisterException;
use Component\Exception\Member\MemberUpdateException;

/**
* 회원 관련 DB 처리 
*
*/
class IndbController extends \Controller\Front\Controller
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
			switch ($in['mode']) {
				/** 회원 가입 */
				case "register" :
					/** 약관 동의 체크 */
					if (!isset($in['agree'])) {
						throw new MemberRegisterException("약관에 동의해 주세요!");
					}
					
					$result = $member->data($in)
											->validator("register")
											->register();
											
					if ($result === false) { // 회원가입 실패
						throw new MemberRegisterException("회원가입 실패!");
					}
					
					// 회원 가입 성공 -> 로그인 페이지로 이동 
					go("member/login", "parent");
					break;
				/** 회원 정보 수정 */
				case "update" :
					
					break;
			}
			
		} catch (MemberRegisterException $e) {
			echo $e;
		} catch (MemberUpdateException $e) {
			echo $e;
		}
	}
}