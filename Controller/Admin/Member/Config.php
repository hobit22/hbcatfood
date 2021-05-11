<?php

namespace Controller\Admin\Member;

use App;
use Controller\Admin\Member\Traits\SubMenu;

/**
* 회원 설정
*
*/
class ConfigController extends \Controller\Admin\Controller
{
	use SubMenu; // 서브 메뉴 추가
	
	protected $mainCode = "member";
	private $subCode = "config";
	
	public function index()
	{
		$member = App::load(\Component\Member\Member::class);
		$config = $member->getConfig();
		App::render("Member/config", $config);
	}
}