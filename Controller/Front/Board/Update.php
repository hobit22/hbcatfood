<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 수정 
*
*/
class UpdateController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->addCss(["board"])
			  ->addScript(["board"]);
	}
	
	public function index()
	{
		$idx = request()->get("idx");
		if (!$idx) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		$data = $board->get($idx);
		$conf = $board->getBoard($data['id']);
		$data = array_merge($data, $conf);
		if (!$data) {
			return msg("게시글이 존재하지 않습니다.", -1);
		}
				
		App::render("Board/form", $data);
	}
}