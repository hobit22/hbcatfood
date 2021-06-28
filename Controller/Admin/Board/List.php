<?php

namespace Controller\Admin\Board;

use App;
use Controller\Admin\Board\Traits\SubMenu;

/**
* 게시판 목록 
*
*/
class ListController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = 'board';
	private $subCode = "list";
	
	public function index()
	{
		$board = App::load(\Component\Board\Board::class);
		$data = [
			'list' => $board->getBoards(),
			'skins' => $board->getSkins(),
		];
		
		App::render("Board/list", $data);
	}
}