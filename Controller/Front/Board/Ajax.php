<?php

namespace Controller\Front\Board;

use App;
use Component\Exception\Board\BoardFrontException;
/**
* 게시판 Ajax 처리 
*
*/
class AjaxController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->layoutBlank = true;
		header("Content-Type: application/json;charset=utf-8");
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$board = App::load(\Component\Board\Board::class);
			
			switch($in['mode']) {
				/** 댓글 내용 추출 */
				case "get_comment" : 
					if (!$in['idx']) {
						throw new BoardFrontException("잘못된 접근입니다.");
					}
					
					$data = $board->getComment($in['idx']);
					
					break;
			}
			
		} catch (BoardFrontException $e) {
			$data = [
				'error' => 1,
				'message' => $e->getMessage(),
			];
			
			echo json_encode($data);
		}
	}
}