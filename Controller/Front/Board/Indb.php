<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\Board\BoardFrontException;

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
		try {
			$in = request()->all();
			$board = App::load(\Component\Board\Board::class);
			switch ($in['mode']) {
				/** 게시글 등록 */
				case "register" :
					$idx = $board->data($in)
									   ->validator() // 유효성 검사 
									   ->register(); // 작성 
					break;
			}
		} catch (BoardFrontException $e) {
			echo $e;
		}
	}
}