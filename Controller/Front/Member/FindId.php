<?php

namespace Controller\Front\Member;

use App;

/**
* 아이디 찾기 
*
*/
class FindIdController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Member/findId");
	}
}