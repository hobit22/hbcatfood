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
				/** 회원 목록 수정 */
				case "update_list" : 
					if (!isset($in['memNo'] || count($in['memNo']) == 0) {
						throw new AlertException("수정할 회원을 선택하세요.");
					}
					
					foreach ($in['memNo'] as $memNo) {
						$level = $in['level'][$memNo];
						$member->changeLevel($memNo, $level);
					}
					
					break;
				/** 회원목록 삭제 */
				case "delete_list" : 
				
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