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
			$extra = $this->confColumns($extra);
			$inData = array_merge($inData, $extra);
		}
	
		
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
		
		$_upData = $this->confColumns($upData);
		$_upData['modDt'] = date("Y-m-d H:i:s");

		$result = db()->table("board")
							->data($_upData)
							->where(["id" => $id])
							->update();
		
		return $result !== false;
	}
	
	/**
	* 게시판 등록, 설정 공통 컬럼 
	*
	*/
	public function confColumns($data)
	{
		$dbData = [];
		foreach ($data as $k => $v) {
			if (in_array($k, ["id", 'mode'])) {
				continue;
			}
			$dbData[$k] = $v;
		}
		
		
		if (isset($dbData['columns'])) {
			$dbData['columns'] = $dbData['columns']?implode(",", $dbData['columns']):"";
		} else {
			$dbData['columns'] = "";
		}
		
		if (isset($dbData['useViewList'])) {
			$dbData['useViewList'] = $dbData['useViewList']?1:0;
		} else {
			$dbData['useViewList'] = 0;
		}
		
		return $dbData;
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
		if ($row) {
			$row['columns'] = $row['columns']?explode(",", $row['columns']):[];
		}
		
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
	public function validator($mode = null)
	{
		// 댓글인 경우는 별도 commentValidator 호출 
		if ($mode == 'comment') {
			return $this->commentValidator();
		}
		
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
		if (!isLogin()) { // 비회원인 경우는 글수정, 글삭제 비번 체크 필요 
			$this->requiredColumns['password'] = '비회원 비밀번호';
		}
		
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
	* 댓글 작성/수정 유효성 검사 
	*
	* @return $this
	* @throw BoardFrontException 
	*/
	public function commentValidator()
	{
		if (!$this->params) {
			throw new BoardFrontException("유효성 검사할 데이터가 존재하지 않습니다.");
		}
		
		// 게시글 번호 체크 
		if (!$this->params['idxBoard']) {
			throw new BoardFrontException("잘못된 접근입니다.");
		}
		
		$required = [
			'poster' => '작성자',
			'comment' => '댓글내용',
		];
		
		// 비회원인 경우 글수정, 삭제시 비밀번호 필수 체크 
		if (!isLogin()) {
			$required['password'] = '비회원 비밀번호';
		}
		
		$missing = [];
		foreach ($required as $col => $colNm) {
			if (!$this->params[$col]) {
				$missing[] = $colNm;
			}
		} // endforeach 
		
		if ($missing) {
			throw new BoardFrontException("필수 입력 항목 누락 - " . implode(",", $missing)); 
		}
		
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
			'email' => isset($this->params['email'])?$this->params['email']:"",
			'link' => isset($this->params['link'])?$this->params['link']:"",
			'ip' => $_SERVER['REMOTE_ADDR'],
		];
		
		// 비회원 글수정, 글삭제일때 비밀번호 처리 
		if (!isLogin()) {
			$security = App::load(\Component\Core\Security::class);
			$inData['password'] = $security->createHash($this->params['password']);
		}
		
		$result = db()->table("boardData")->data($inData)->insert();
		if ($result !== false) { // 게시글 등록이 성공 했을때 
			// 파일 첨부 처리
			$this->processUploadFiles($this->params['gid']);
		}
		
		
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
			'email' => isset($this->params['email'])?$this->params['email']:"",
			'link' => isset($this->params['link'])?$this->params['link']:"",
			'modDt' => date("Y-m-d H:i:s"),
		];
		
		// 비회원 비밀번호 처리 
		if (!isLogin()) {
			$security = App::load(\Component\Core\Security::class);
			$upData['password'] = $security->createHash($this->params['password']);
		}
		
		$result = db()->table("boardData")
							->data($upData)
							->where(["idx" => $this->params['idx']])
							->update();
		
		if ($result !== false) { // 게시글 수정 성공시 
			// 업로드 파일 처리 
			$this->processUploadFiles($this->params['gid']);
		}
		
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
	* 댓글 등록 처리 
	*
	* @return Integer|Boolean 성공시 - 등록번호(idx), 실패 - false
	*/
	public function registerComment()
	{
		$memNo = isLogin()?$_SESSION['memNo']:0;
		$inData = [
			'poster' => $this->params['poster'],
			'memNo' => $memNo,
			'idxBoard' => $this->params['idxBoard'],
			'comment' => $this->params['comment'],
		];
		
		// 비회원인 경우 댓글 수정, 삭제위한 비밀번호 처리 
		if (!isLogin()) {
			$security = App::load(\Component\Core\Security::class);
			$inData['password'] = $security->createHash($this->params['password']);
		}
		
		$result = db()->table("boardComment")->data($inData)->insert();
		return $result;
	}
	
	
	/**
	* 댓글 수정 
	*
	* @param Integer $idx 댓글번호 
	* @param String $comment 수정할 댓글 
	* 
	* @return Boolean
	*/
	public function updateComment($idx, $comment) 
	{
		$result = db()->table("boardComment")
							->data(["comment" => $comment])
							->where(["idx" => $idx])
							->update();
		
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
			// 수정권한이 있는지 여부 
			$data['updatePossible'] = $this->checkUpdatePossible($idx);
			
			// 삭제권한이 있는지 여부 
			$data['deletePossible'] = $this->checkDeletePossible($idx);
			
			$file = App::load(\Component\File::class);
			$data['attachFiles'] = $file->getGroupFiles($data['gid']);
		}
		
		return $data;
	}
	
	/**
	* 본인 게시글인지 체크 
	*
	* @param Integer $idx 게시글 번호
	* @return Boolean true - 본인, false - 타인 
	*/
	public function isMine($idx) 
	{
		if (isLogin()) {
			$row = db()->table("boardData")
							 ->select("memNo")
							 ->where(["idx" => $idx])
							 ->row();
			if ($row && $row['memNo'] == $_SESSION['memNo']) {
				return true; // 본인이 쓴 글
			}
		}
		
		return false;
	}
	
	/**
	* 비회원 게시글인지 체크 
	*
	* @param Integer $idx 게시글 번호 
	* @return Boolean true - 비회원 게시글, false - 회원 게시글 
	*/
	public function isGuest($idx)
	{
		$row = db()->table("boardData")
						->select("memNo")
						->where(["idx" => $idx])
						->row();
						
		if ($row && !$row['memNo']) { // 게시글의 memNo가 0인 경우 - 비회원
			return true;
		}
		
		return false;
	}
	
	/**
	* 글 수정권한 체크 
	*
	* @param Integer $idx 게시글 번호 
	* @return Boolean true - 가능, false - 불가 
	*/
	public function checkUpdatePossible($idx)
	{
		if (isAdmin() || $this->isMine($idx) || $this->isGuest($idx)) 
			return true; // 관리자또는 본인 글 또는 비회원 게시글인 경우 true;
		
		return false;
	}
	
	/**
	* 글 삭제권한 체크 
	*
	* @param Integer $idx 게시글 번호 
	* @return Boolean true - 가능, false - 불가 
	*/
	public function checkDeletePossible($idx)
	{
		if (isAdmin() || $this->isMine($idx) || $this->isGuest($idx)) 
			return true; // 관리자 또는 본인 글 또는 비회원 게시글인 경우 삭제 가능 
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
	
	/**
	* 첨부된 파일 처리 
	*
	* @param String $gid 그룹 ID
	* @param String $name 파일태그의 name 
	*
	* @return Array 파일 추가 번호(배열)
	*/
	public function processUploadFiles($gid, $name = 'file')
	{
		$name = $name?$name:"file";
		
		$file = App::load(\Component\File::class);
		$idxes = $file->upload($gid, $name, 'all', false, true);
		
		return $idxes;
	}
	
	
	/**
	* 게시글 조회수 업데이트 
	*
	* @param Integer $idx 게시글 번호 
	*/
	public function updateViewCount($idx)
	{
		// 게시글 번호 + 브라우저ID 추가 
		try {
			db()->table("boardView")
				->data(["idx" => $idx, "browserId" => browserId()])
				->insert();
		} catch (\PDOException $e) {}
		
		// 게시글에 조회 수 업데이트 
		$hit = db()->table("boardView")->where(["idx" => $idx])->count();
		
		db()->table("boardData")
			->data(["hit" => $hit])
			->where(["idx" => $idx])
			->update();
	}
	
	/**
	* 게시글별 댓글 목록
	*
	* @param Integer $idxBoard 게시글 번호 
	* @return Array
	*/
	public function getComments($idxBoard) 
	{
		$config = getConfig();
		$px = $config['prefix'];
		
		$joinTable = [
			'member' => ["{$px}member.memNo", "{$px}boardComment.memNo", "left"],
		];
		
		$list = db()->table("boardComment", $joinTable)
						->select("{$px}boardComment.*, {$px}member.memId, {$px}member.memNm")
						->where(["{$px}boardComment.idxBoard" => $idxBoard])
						->orderBy([["{$px}boardComment.regDt", "asc"]])
						->rows();
		
		foreach ($list as $k => $v) {
			// 수정, 삭제 가능여부 체크 
			$v['updatePossible'] = $this->checkUpdateCommentPossible($v['idx']); 
			$v['deletePossible'] = $this->checkDeleteCommentPossible($v['idx']);
			
			$list[$k] = $v;
		}
		
		return $list;
	}
	
	/**
	* 댓글 조회 
	*
	* @param Integer $idx 댓글 등록 번호
	* @return Array
	*/
	public function getComment($idx)
	{
		$config = getConfig();
		$px = $config['prefix'];
		
		$joinTable = [
			'member' => ["{$px}member.memNo", "{$px}boardComment.memNo", "left"],
		];
		
		$data = db()->table("boardComment", $joinTable)
						->select("{$px}boardComment.*, {$px}member.memId, {$px}member.memNm")
						->where(["{$px}boardComment.idx" => $idx])
						->row();
		
		if ($data) {
			$data['updatePossible'] = $this->checkUpdateCommentPossible($data['idx']);
			$data['deletePossible'] = $this->checkDeleteCommentPossible($data['idx']);
		}
		return $data;
	}
	
	/**
	* 댓글 삭제 
	*
	* @param Integer $idx 댓글 등록번호
	* @return Boolean
	*/
	public function deleteComment($idx)
	{
		$result = db()->table("boardComment")
						  ->where(["idx" => $idx])
						  ->delete();
						  
		return $result !== false;
	}
	
	/**
	* 댓글 수정권한 체크 
	*
	* @param Integer $idx 댓글 번호 
	* @return Boolean true - 가능, false - 불가능 
	*/
	public function checkUpdateCommentPossible($idx) 
	{
		if (isAdmin() || $this->isMyComment($idx) || $this->isGuestComment($idx)) 
			return true; // 관리자 또는 본인 또는 비회원 댓글인 경우 
		
		return false;
	}
	
	/**
	* 댓글 삭제권한 체크 
	*
	* @param Integer $idx 댓글 번호 
	* @return Boolean true - 가능, false - 불가능 
	*/
	public function checkDeleteCommentPossible($idx) 
	{
		if (isAdmin() || $this->isMyComment($idx) || $this->isGuestComment($idx))
			return true; // 관리자 또는 본인 또는 비회원 댓글인 경우 
		
		return false;
	}
	
	/**
	* 본인 작성 댓글 여부 
	*
	* @param Integer $idx 댓글 번호
	* @return Boolean true - 본인, false - 타인 
	*/
	public function isMyComment($idx)
	{
		$row = db()->table("boardComment")
						->select("memNo")
						->where(["idx" => $idx])
						->row();
						
		if (isLogin() && $row && $_SESSION['memNo'] == $row['memNo'])
			return true; // 본인 댓글
		
		return false;
	}
	
	/**
	* 비회원 게시글 여부 체크 
	*
	* @param Integer $idx 댓글 번호
	* @return Boolean  // memNo - 0 인 경우 - 비회원 댓글
	*/
	public function isGuestComment($idx) 
	{
		$row = db()->table("boardComment")
						->select("memNo")
						->where(["idx" => $idx])
						->row();
		
		if ($row && !$row['memNo']) { // 댓글의 memNo가 0이면 비회원 댓글 
			return true;
		}
		
		return false;
	}
	
	/**
	* 비회원 게시글 비밀번호 체크 
	*
	* @param Integer $idx - 게시글 번호
	* @param String $password - 비회원 비밀번호 
	* 
	* @return Boolean 
	*/
	public function checkGuestPassword($idx, $password)
	{
		$row = db()->table("boardData")
						->select("memNo, password")
						->where(["idx" => $idx])
						->row();
		
		if ($row && !$row['memNo'] && $row['password']) {
			$security = App::load(\Component\Core\Security::class);
			
			$result = $security->compareHash($password, $row['password']);
			
			return $result; // 일치 true, 
		}
		
		return false;
	}
}