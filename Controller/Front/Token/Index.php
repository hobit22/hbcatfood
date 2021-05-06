<?php

namespace Controller\Front\Token;

use App;

/**
* 토큰 체크 페이지 
*
*/
class IndexController extends \Controller\Front\Controller
{
	public function __construct() 
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$tk = request()->get("token");
		$token = App::load(\Component\Token::class);
		$data = $token->get($tk);
		if ($data) { // 토큰이 유효한 경우 
			$_SESSION['token'] = $tk; // 토큰을 세션에 저장 
			header("Location: {$data['url']}"); // 페이지 이동 
		}
	}
}