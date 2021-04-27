<?php

namespace Controller\Admin\Board\Traits;

/**
* 게시판 관리 서브 메뉴
*
*/
trait SubMenu
{
	public function subMenu()
	{
		$menu = $this->subCode?$this->subCode:"";
		App::render("Board/Menus/sub", ["menu" => $menu]);
	}
}