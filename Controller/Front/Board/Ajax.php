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
		header("Content-Type: application/json;charset=utf-8");
	}
	
	public function index()
	{
		try {
			$in = request()->all();
			$board = App::load(\Component\Board\Board::class);
		} catch (BoardFrontException $e) {
			
		}
	}
}