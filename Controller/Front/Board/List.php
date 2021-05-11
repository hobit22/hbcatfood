<?php

namespace Controller\Front\Board;

use App;

/**
* 게시글 목록 
*
*/
class ListController extends \Controller\Front\Controller
{
	public function __construct()
	{
		$this->addCss(["board"]);
	}
	
	public function index()
	{
		$id = request()->get("id"); // 게시판 아이디 
		if (!$id) {
			return msg("잘못된 접근입니다.", -1);
		}
		
		$board = App::load(\Component\Board\Board::class);
		$data = $board->getBoard($id); // 게시판 설정 
		if (!$data) {
			return msg("존재하지 않는 게시판입니다.", -1);
		}
		
		$page = request()->get("page");
		$category = request()->get("category");
		$qs = [];
		
		// 게시글 목록 
		if ($category) { // 분류 있으면 검색 추가 
			$config = getConfig();
			$px = $config['prefix'];
			$board->addWhere(["{$px}boardData.category" => $category]);
			
			$qs[] = "category=".$category;
		}
		
		$qs = $qs?implode("&", $qs):"";
		
		$result = $board->getList($id, $page, $qs);
		$data = array_merge($data, $result);
		
		$data['category'] = $category; // 선택한 게시판 분류
		
		App::render("Board/list", $data);
	}
}