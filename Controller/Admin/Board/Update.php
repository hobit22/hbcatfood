<?php

namespace Controller\Admin\Board;

use App;
use Controller\Admin\Board\Traits\SubMenu;

/**
* 게시판 설정 수정 
*
*/
class UpdateController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "board";
	private $subCode = "update";
	
	public function index()
	{
		$id = request()->get("id");
		if (!$id) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		
		$data = $board->getBoard($id);
		$data['skins'] = $board->getSkins();
		
		App::render("Board/form", $data);
	}
}