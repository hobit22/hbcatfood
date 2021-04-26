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
}