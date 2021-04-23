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
	
	public function index()
	{
		$data = [
			'menu' => 'member',
		];
		App::render("Member/list", $data);
	}
}