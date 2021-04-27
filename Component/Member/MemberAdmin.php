<?php

namespace Component\Member;

include_once "member.php"; // 임시

use App;

/**
* 회원관리 Component
*
*/
class MemberAdmin extends \Component\Member\Member
{	
	/**
	* 회원목록
	*
	* @return Array
	*/
	public function getList($page = 1, $limit = 20)
	{
		/**
		$page - 현재 페이지
		$limit - 1페이지당 레코드수 
		$total - 전체 레코드그 수 
		*/
		
		$url = siteUrl("admin/member/list");
		$page = $page?$page:1;
		$limit = $limit?$limit:20;
		$offset = ($page - 1) * $limit; // 레코드 시작점
		$total = db()->table("member")->count();
		
		$list = db()->table("member")
						->limit($limit, $offset)
						->orderBy([["regDt", "desc"]])
						->rows();
		
		// 페이징 처리 S 
		$paginator = App::load(\Component\Pagination::class, $page, $limit, $total, $url);
		$pagination = $paginator->getPages();
		// 페이징 처리 E 
		
		return [
			'list' => $list,
			'pagination' => $pagination,
			'total' => $total,
		];
	}
	
	/**
	* 관리자페이지 접근 제한 처리
	*
	*/
	public function accessCheck()
	{
		$isAdmin = false; // 관리자 여부 체크 - false
		if (isLogin()) {
			if ($_SESSION['member']['level'] == 10) {
				$isAdmin = true;
			}
		} // endif
		
		if (!$isAdmin) { // 관리자가 아니면 관리자 로그인 페이지로 이동
			go("admin/member/login");
		}
		
	}
}