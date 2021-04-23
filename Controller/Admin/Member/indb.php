<?php

namespace Controller\Admin\Member;

use App;
use Component\Exception\AlertException;

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
		try {
			switch($in['mode']) {
				// 회원 가입
				case "register" :
					
					break;
			}
		} catch (AlertException $e) {
			echo $e;
			exit;
		}
	}
}