<?php

namespace Controller\Admin\Member;

use App;
use Controller\Admin\Member\Traits\SubMenu;

/**
* 회원 등록 
*
*/
class RegisterController extends \Controller\Admin\Controller 
{
	use SubMenu; // 서브 메뉴
	
	protected $mainCode = "member"; // 메인 메뉴 코드 
	private $subCode = "register"; // 서브 메뉴 코드 
	
	public function index()
	{
		App::render("Member/form");
	}
}