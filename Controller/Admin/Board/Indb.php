<?php

namespace Controller\Admin\Board;

use App;
use Component\Exception\Board\BoardAdminException;

/**
* 게시판관리 DB 처리 
*
*/
class IndbController extends \Controller\Admin\Controller
{
	public function __construct()
	{
		parent::__construct();
		
		$this->layoutBlank = true;
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$board = App::load(\Component\Board\Board::class);
			switch ($in['mode']) {
				/** 게시판 등록 */
				case "register_board" :
					/**
					 게시판 아이디 -> 생성 
					 + 추가 설정 
					*/
					$result = $board->createBoard($in['id'], $in['boardNm'], $in);
					if ($result === false) {
						throw new BoardAdminException("게시판 생성 실패!");
					}
					
					// 게시판 생성 성공
					go("admin/board/list", "parent");
					break;
			}
		} catch (BoardAdminException $e) {
			echo $e;
		}
	}
}