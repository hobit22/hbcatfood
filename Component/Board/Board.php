<?php

namespace Component\Board;

use App;
use Component\Exception\Board\BoardAdminException;
use Component\Exception\Board\BoardFrontException;

/**
* 게시판 관련 Component
*
*/
class Board
{
	private $params = []; // 처리할 데이터 
	// 필수 데이터 컬럼 
	private $requiredColumns = [
		'poster' => "작성자",
		'subject' => "제목",
		'contents' => "내용",
	];
	
	/**
	* 게시판 생성 
	*
	* @param String $id 게시판 아이디 
	* @param String $boardNm 게시판명 
	* @param Array $extra 추가 설정 데이터 
	* 
	* @return Boolean 생성 성공 true, 실패 false
	*/
	public function createBoard($id, $boardNm, $extra  = [])
	{
		$inData = [
			'id' => $id,
			'boardNm' => $boardNm,
		];
		
		if ($extra) {
			foreach ($extra as $k => $v) {
				if (in_array($k, ['id', 'boardNm', 'mode'])) {
					continue;
				}
				
				$inData[$k] = $v;
				
			} // endforeach 
		} // endif 
		
		$result = db()->table("board")->data($inData)->insert();
		
		return $result !== false;
	}
	
	/**
	* 게시판 설정 수정 
	*
	* @param String $id 게시판 아이디
	* @param Array $upData 수정할 설정 
	* @return Boolean
	*/
	public function updateBoard($id, $upData)
	{
		$upData['modDt'] = date("Y-m-d H:i:s");
		$result = db()->table("board")
							->data($upData)
							->where(["id" => $id])
							->update();
		
		return $result !== false;
	}
	
	/**
	* 게시판 설정 삭제 
	*
	* @param String $id 게시판 아이디 
	* @return Boolean 
	*/
	public function deleteBoard($id)
	{
		$result = db()->table("board")->where(["id" => $id])->delete();
		
		return $result !== false;
	}
	
	/**
	* 게시판 스킨 목록 
	*
	* @return Array
	*/
	public function getSkins()
	{
		$skins = [];
		$path = __DIR__ . "/../../Views/Front/Board/Skins/*";
		foreach(glob($path) as $f) {
			if (is_dir($f)) {
				$path = explode("/", $f);
				$skins[] = $path[count($path) - 1];
			}
		}
		
		return $skins;
	}
	
	/**
	* 게시판 목록 
	*
	* @return Array
	*/
	public function getBoards()
	{
		$list = db()->table("board")->orderBy([["regDt", "desc"]])->rows();
		
		return $list;
	}
	
	/**
	* 게시판 설정 
	*
	* @param String $id 게시판 아이디 
	* @return Array
	*/
	public function getBoard($id)
	{
		$row = db()->table("board")->where(["id" => $id])->row();
		
		return $row;
	}
	
	/**
	* 처리할 데이터 설정 
	*
	* @param Array $params 처리할 데이터 
	* @return $this
	*/
	public function data($params = [])
	{
		$this->params = $params;
		
		return $this;
	}
	
	/**
	* 게시글 작성/수정 유효성 검사 
	*
	* @return $this
	* @throw BoardFrontException
	*/
	public function validator()
	{
		if (!$this->params) {
			throw new BoardFrontException("유효성 검사할 데이터가 존재하지 않습니다.");
		}
		
		if (!isset($this->params['boardId']) || !$this->params['boardId']) {
			throw new BoardFrontException("잘못된 접근입니다.");
		}
		
		// 게시글 수정 - mode - update 수정시 게시글 번호 누락(idx)
		if (isset($this->params['mode']) && $this->params['mode'] == 'update' && (!isset($this->params['idx']) || !$this->params['idx'])) {
			throw new BoardFrontException("잘못된 접근입니다.");
		}
		
		/** 필수 데이터 체크 S */
		$missing = [];
		foreach ($this->requiredColumns as $column => $colStr) {
			if (!isset($this->params[$column]) || !$this->params[$column]) { // 필수 데이터 누락
				$missing[] = $colStr;
			}
		}
		
		if ($missing) { // 누락 데이터가 있는 경우 
			throw new BoardFrontException("필수 입력 항목 누락 - " . implode(",", $missing));
		}
		
		/** 필수 데이터 체크 E */
		
		return $this;
	}
	
	/**
	* 게시글 등록 
	*
	* @return Integer|Boolean 등록 성공 - 게시글 번호(idx), 실패 - false
	*/
	public function register()
	{
		// memNo - 0(비회원 게시글), memNo > 0 - 회원 게시글
		$memNo = isLogin()?$_SESSION['memNo']:0;
		$inData = [
			'gid' => $this->params['gid'],
			'memNo' => $memNo,
			'boardId' => $this->params['boardId'],
			'poster' => $this->params['poster'],
			'subject' => $this->params['subject'],
			'contents' => $this->params['contents'],
		];
		
		$result = db()->table("boardData")->data($inData)->insert();
		
		return $result;
	}
	
	/**
	* 게시글 수정 
	*
	* @return Boolean 성공 true, 실패 false
	*/
	public function update()
	{
		$upData = [
			'poster' => $this->params['poster'],
			'subject' => $this->params['subject'],
			'contents' => $this->params['contents'],
			'modDt' => date("Y-m-d H:i:s"),
		];
		$result = db()->table("boardData")
							->data($upData)
							->where(["idx" => $this->params['idx']])
							->update();
		
		return $result !== false;
	}
	
	/**
	* 게시글 삭제 
	*
	* @param Integer $idx 게시글 번호 
	* @return Boolean 
	*/
	public function delete($idx)
	{
		$result = db()->table("boardData")->where(["idx" => $idx])->delete();
		
		return $result !== false;
	}
	
	/**
	* 게시글 조회 
	*
	* @param Integer $idx 게시글 번호 
	* @return Array
	*/
	public function get($idx)
	{
		// yh_boardData, yh_board 
		$config = getConfig();
		
		$fields = "{$config['prefix']}boardData.*, {$config['prefix']}member.memId, {$config['prefix']}member.memNm, {$config['prefix']}board.boardNm, {$config['prefix']}board.boardSkin, {$config['prefix']}board.id";
		$joinTable = [
			'board' => [$config['prefix']."boardData.boardId", $config['prefix']."board.id", "left"],
			'member' => [$config['prefix']."boardData.memNo", $config['prefix']."member.memNo", "left"],
		];
		$data = db()->table("boardData", $joinTable)
					  ->select($fields)
					  ->where([$config['prefix']."boardData.idx" => $idx])
					  ->row();
		
		if ($data) {
			$file = App::load(\Component\File::class);
			$files = $file->getGroupFiles($data['gid']);
		}
		
		return $data;
	}
	
	/**
	* 게시글 목록 
	*
	* @param String $id 게시판 아이디 
	* @param Integer $page 페이지번호
	* @param String $qs GET 쿼리스트링 
	*
	* @return Array 
					- list 게시글 목록 
					- pagination 페이징 HTML
					- total 전체 게시글 수 
					- offset 게시글 시작 지점
	*/
	public function getList($id, $page = 1, $qs = "")
	{
		$page = $page?$page:1;
		$limit = 20;
		$offset = ($page - 1) * $limit;
		
		$config = getConfig();
		$px = $config['prefix'];
		
		$joinTable = [
			'member' => [$px."boardData.memNo", $px."member.memNo", "left"],
		];
		
		$total = db()->table("boardData", $joinTable)
						->where(["{$px}boardData.boardId" => $id])
						->count();
		
		$columns = "{$px}boardData.*, {$px}member.memNm, {$px}member.memId";
		$list = db()->table("boardData", $joinTable)
						->where(["{$px}boardData.boardId" => $id])
						->select($columns)
						->limit($limit, $offset)
						->orderBy([["{$px}boardData.regDt", "desc"]])
						->rows();
		
		$url = siteUrl("board/list")."?id={$id}";
		if ($qs) $url .= "&".$qs;
		
		$paginator = App::load(\Component\Pagination::class, $page, $limit, $total, $url);
		$pagination = $paginator->getPages();
		
		$result = [
			'list' => $list,
			'pagination' => $pagination,
			'total' => $total,
			'offset' => $offset,
		];
		
		return $result;
	}
}