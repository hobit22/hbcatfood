<?php

namespace Controller\Admin\Member;

use App;

/**
* 회원 목록 
*
*/
class ListController extends \Controller\Admin\Controller
{
	public function index()
	{
		$data = [
			'menu' => 'member',
		];
		App::render("Member/list", $data);
	}
}