<?php

namespace Controller\Front\Member;

use App;

/**
* 회원 가입 
*
*/
class JoinController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Member/form");
	}
}