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
		$isSubmitted = request()->post("isSubmitted");
		if ($isSubmitted) {
			$memNm = request()->post("memNm");
			$email = request()->post("email");
			$cellPhone = request()->post("cellPhone");
			
			$member = App::load(\Component\Member\Member::class);
			$member->findMemId($memNm, $email, $cellPhone);
		}
		
		App::render("Member/findId");
	}
}