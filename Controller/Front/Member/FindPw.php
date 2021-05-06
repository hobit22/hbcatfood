<?php

namespace Controller\Front\Member;

use App;

/**
* 비밀번호 찾기
*
*/
class FindPwController extends \Controller\Front\Controller
{
	public function index()
	{
		App::render("Member/findPw");
	}
}