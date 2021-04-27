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
				/** 게시판 설정 수정 */
				case "update_board_list" : 
					if (!isset($in['id'])) {
						throw new BoardAdminException("수정할 게시판을 선택하세요.");
					}
					
					foreach ($in['id'] as $id) {
						$upData = [
							'boardNm' => $in['boardNm'][$id],
							'useReply' => $in['useReply'][$id]?1:0,
							'boardSkin' => $in['boardSkin'][$id],
						];
						$board->updateBoard($id, $upData);
					}
					
					reload("parent");
					
					break;
				/** 게시판 설정 삭제 */
				case "delete_board_list" : 
					// 게시판 id 존재유무 -> 삭제할 게시판을 선택했는지 여부 
					if (!isset($in['id'])) {
						throw new BoardAdminException("삭제할 게시판을 선택하세요.");
					}
					
					foreach ($in['id'] as $id) {
						$board->deleteBoard($id);
					}
					
					reload("parent");
					break;
			}
		} catch (BoardAdminException $e) {
			echo $e;
		}
	}
}