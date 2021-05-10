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
		$in = request()->all();
		if ($in['mode'] != 'delete') {
			$this->layoutBlank = true;
		}		
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
					// 수정 권한 체크 
					if (!$board->checkUpdatePossible($in['idx'])) {
						throw new BoardFrontException("수정 권한이 없습니다.");
					}
				
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
					
					// 삭제 권한이 없는 경우 
					if (!$data['deletePossible']) {
						throw new BoardFrontException("삭제권한이 없습니다.", -1);
					}
					
					// 비회원이고 삭제 비회원 비밀번호 체크가 안된 경우 
					if (!$data['memNo'] && (!isset($_SESSION['guest_board_'.$in['idx']]) || !$_SESSION['guest_board_'.$in['idx']])) {
						App::render("Board/password", $data);
					} else {  // 비회원 비밀번호가 체크 되었거나 또는 회원인 게시글 인경우 
						$result = $board->delete($in['idx']);
						if ($result === false) {
							throw new BoardFrontException("삭제실패!", -1);
						}
						
						// 삭제 성공시 -> 게시글 목록
						go("board/list?id={$data['id']}");
					} // endif 
					break;
				/** 댓글 등록 */
				case "register_comment" : 
					$idx = $board->data($in)
									->validator("comment")
									->registerComment();
									
					if ($idx === false) { // 댓글 등록 실패 
						throw new BoardFrontException("댓글 등록 실패!");
					}
					
					// 댓글 등록 성공시는  추가된 댓글 나열  
					//$url = "board/view?idx=".$in['idxBoard']."#comment_".$idx;
					//go($url, "parent");
					reload("parent");
					break;
				/** 댓글 수정 */
				case "update_comment" : 
					if (!$in['idx']) {
						echo 0;
						exit;
					}
					
					// 댓글 수정 권한이 없는 경우 
					if (!$board->checkUpdateCommentPossible($in['idx'])) {
						echo 0;
						exit;
					}
					
					$result = $board->updateComment($in['idx'], $in['comment']);
					if ($result) { // 수정 성공
						echo 1;
						exit;
					}
					
					echo 0;
					break;
				/** 댓글 삭제 */
				case "delete_comment" : 
					if (!$in['idx']) {
						echo 0;
						exit;
					}
					
					// 삭제 권한이 없는 경우 
					if (!$board->checkDeleteCommentPossible($in['idx'])) {
						echo 0;
						exit;
					}
					
					$result = $board->deleteComment($in['idx']);
					if ($result) {
						echo 1;
						exit;
					}
					
					echo 0;
					break;
				/** 비회원 비밀번호 체크 */
				case "check_password" : 
					if (!isset($in['idx']) || !$in['idx']) {
						throw new BoardFrontException("잘못된 접근입니다.");
					}
					
					if (!$in['password']) {
						throw new BoardFrontException("비밀번호를 입력하세요.");
					}
					
					$result = $board->checkGuestPassword($in['idx'], $in['password']);
					if ($result === false) {
						throw new BoardFrontException("비밀번호 불일치!");
					}
					
					// 비밀번호 일치 하면 세션에 일치 여부 체크 완료에 대한 값
					$key = "guest_board_".$in['idx'];
					$_SESSION[$key] = true;
					reload("parent"); // 새로고침
					
					break;
			}
		} catch (BoardFrontException $e) {
			echo $e;
		}
	}
}