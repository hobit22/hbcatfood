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
		// 게시글 수정 권한이 없는 경우 
		if (!$data['updatePossible']) {
			msg("수정 권한이 없습니다.", -1);
		}
		
		$conf = $board->getBoard($data['id']);
		$data = array_merge($data, $conf);
		if (!$data) {
			return msg("게시글이 존재하지 않습니다.", -1);
		}
		
		// $_SESSION에 guest_board_게시글번호가 없으면 - 아직 비회원 비밀번호 체크 X 
		if (!$data['memNo'] && (!isset($_SESSION['guest_board_'.$idx]) || !$_SESSION['guest_board_'.$idx])) { // 비회원 - 글 수정 비밀번호 체크 필요 
			$skinPath = "Board/password";
		} else {
			$skinPath = "Board/form";
		}
		
		App::render($skinPath, $data);
	}
}