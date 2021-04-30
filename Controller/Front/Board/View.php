<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 보기
*
*/
class ViewController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->addCss(["board"]);
	}
	
	public function index()
	{
		$idx = request()->get("idx");
		if (!$idx) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		
		// 조회수 업데이트 
		$board->updateViewCount($idx);
		$data = $board->get($idx);
		if (!$data) {
			return msg("게시글이 존재하지 않습니다.", -1);
		}
	
		App::render("Board/view", $data);
	}
}