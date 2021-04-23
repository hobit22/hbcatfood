<?php

namespace Controller\Admin\Member;

/**
* 회원 관리 DB 처리 
*
*/
class IndbController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true; // 헤더, 푸터 생략 
	}
	
	public function index()
	{
		$in = request()->all();
		debug($in);
	}
}