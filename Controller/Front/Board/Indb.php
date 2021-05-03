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
									   
					if ($idx === false) {
						throw new BoardFrontException("게시글 작성 실패!");
					}
					
					// 게시글 작성 성공 -> board/view?idx=게시글
					go("board/view?idx={$idx}", "parent");
					break;
				/** 게시글 수정 */
				case "update" : 
					$result = $board->data($in)
											->validator() // 유효성검사 
											->update(); // 수정 
					
					if ($result === false) {
						throw new BoardFrontException("게시글 수정 실패!");
					}
					
					// 수정 성공 -> 게시글 보기 
					go("board/view?idx={$in['idx']}", "parent");
					break;
				/** 게시글 삭제 */
				case "delete" : 
					if (!isset($in['idx']) || !$in['idx']) {
						throw new BoardFrontException("잘못된 접근입니다.", -1);
					}
					
					$data = $board->get($in['idx']);
					if (!$data) {
						throw new BoardFrontException("존재하지 않는 게시글입니다.", -1);
					}
					
					$result = $board->delete($in['idx']);
					if ($result === false) {
						throw new BoardFrontException("삭제실패!", -1);
					}
					
					// 삭제 성공시 -> 게시글 목록
					go("board/list?id={$data['id']}");
					break;
				/** 댓글 등록 */
				case "register_comment" : 
					$idx = $board->data($in)
									->validator("comment")
									->commentRegister();
					break;
			}
		} catch (BoardFrontException $e) {
			echo $e;
		}
	}
}