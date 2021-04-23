<?php

namespace Controller\Admin\Member\Traits;

use App;

/**
* 회원 관리 서브 메뉴 
*
*/
trait SubMenu
{
	public function subMenu()
	{
		$menu = $this->subCode?$this->subCode:"";
		App::render("Member/Menus/sub", ["menu" => $menu]);
	}
}