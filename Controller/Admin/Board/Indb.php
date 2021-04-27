<?php

namespace Controller\Admin\Board;

use App;

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
		$in = request()->all();
		$board = App::load(\Component\Board\Board::class);
		switch ($in['mode']) {
			/** 게시판 등록 */
			case "register_board" :
			
				break;
		}
	}
}