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
		
		// 게시판 설정 
		$conf = $board->getBoard($data['id']);
		
		// 댓글 사용 처리 S 
		if ($conf['useReply']) {
			ob_start();
			App::render("Board/comment", $conf); 
			$data['commentContents'] = ob_get_clean();
		}
		// 댓글 사용 처리 E
		
		// 보기 하단에 게시글 목록 S 
		if ($conf['useViewList']) { 
			ob_start();
			$result = $board->getList($data['id']);
			$result = array_merge($result, $conf);
			$result['isViewList'] = true;
			App::render("Board/list", $result);
			
			$listContents = ob_get_clean();
			$data['listContents'] = $listContents;
		}
		// 보기 하단에 게시글 목록 E
		
		App::render("Board/view", $data);
	}
}