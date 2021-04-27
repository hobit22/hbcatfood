<?php

namespace Controller\Admin\Board;

use App;
use Controller\Admin\Board\Traits\SubMenu;

/**
* 게시판 생성 
*
*/
class RegisterController extends \Controller\Admin\Controller
{
	use SubMenu;
	
	protected $mainCode = "board";
	private $subCode = "register";
	
	public function index()
	{
		App::render("Board/form");
	}
}