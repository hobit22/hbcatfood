<?php

namespace Controller\Admin\Member;

use App;
use Controller\Admin\Member\Traits\SubMenu;

/**
* 회원정보 수정 
*
*/
class UpdateController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "member"; // 메인 메뉴 코드 
	private $subCode = "update"; // 서브 메뉴 코드 
	
	public function index()
	{
		$member = App::load(\Component\Member\Member::class);
		$memNo = request()->get("memNo");
		$info = $member->get($memNo);
		debug($info);
		App::render("Member/form");
	}
}