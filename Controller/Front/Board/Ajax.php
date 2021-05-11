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
		//header("Content-Type: application/json;charset=utf-8");
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
					
					if ($board->isGuestComment($in['idx'])) { // 비회원
						echo "
							<div class='comment_data'>
								<div>비회원 비밀번호 입력</div>
								<input type='password' name='password' placeholder='비회원 비밀번호 입력..' class='w120'>
								<span class='btn1 password_confirm'>확인</span>
							</div>
						";
						
					} else { // 회원 또는 비회원 인증 완료 시 
						echo "<textarea class='comment_data'>{$data['comment']}</textarea>";
					}
					/*
					$data = [
						'error' => 0,
						'data' => $board->getComment($in['idx']),
					];
					echo json_encode($data);
					*/
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