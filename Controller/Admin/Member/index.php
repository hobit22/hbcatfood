<?php

namespace Controller\Admin\Member;

/**
* 회원 관리 메인
* -> /admin/member/list
*/
class IndexController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$url = siteUrl("admin/member/list");
		header("Location: {$url}");
		exit;
	}
}