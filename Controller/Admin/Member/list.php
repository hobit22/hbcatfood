<?php

namespace Controller\Admin\Member;

use App;
use Controller\Admin\Member\Traits\SubMenu;

/**
* 회원 목록 
*
*/
class ListController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "member"; // 메인 메뉴 코드 
	private $subCode = "list"; // 서브 메뉴 코드 
	
	public function index()
	{
		$member = App::load(\Component\Member\MemberAdmin::class);
		$data = $member->getList();
		App::render("Member/list", $data);
	}
}