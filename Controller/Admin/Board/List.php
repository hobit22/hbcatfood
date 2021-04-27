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
		App::render("Board/list");
	}
}