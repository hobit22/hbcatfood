<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 작성 
*
*/
class WriteController extends \Controller\Front\Controller
{
	public function __construct()
	{		
		$this->addCss(["board"])
				->addScript(["board"]);
	}
	
	public function index()
	{
		/**
			게시판 설정
			id - 게시판 아이디 
			1. 게시판이 존재하는지 
			2. 존재하면 -> 설정 -> Views
		*/
		
		$id = request()->get("id"); // 게시판 아이디 
		if (!$id) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		$conf = $board->getBoard($id);
		if (!$conf) {
			return msg("게시판이 존재하지 않습니다.", -1);
		}
		
		$conf['gid'] = gid(); // 그룹 ID
		App::render("Board/form", $conf);
	}
}