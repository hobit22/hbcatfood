<?php

namespace Controller\Admin\Goods\Traits;

use App;

/**
* 게시판 관리 서브 메뉴
*
*/
trait SubMenu
{
	public function subMenu()
	{
		$menu = $this->subCode?$this->subCode:"";
		App::render("Goods/Menus/sub", ["menu" => $menu]);
	}
}