<?php

namespace Controller\Front\Board;

use App;

/**
* 게시판 DB 처리 
*
*/
class IndbController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		$in = request()->all();
		$board = App::load(\Component\Board\Board::class);
		switch ($in['mode']) {
			/** 게시글 등록 */
			case "register" :
			
				break;
		}
	}
}