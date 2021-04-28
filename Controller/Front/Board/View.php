<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 보기
*
*/
class ViewController extends \Controller\Front\Controller
{
	public function index()
	{
		$idx = request()->get("idx");
		if (!$idx) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		$data = $board->get($idx);
	
		App::render("Board/view", ["boardSkin" => "Default"]);
	}
}