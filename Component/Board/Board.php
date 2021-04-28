<?php

namespace Component\Board;

use App;
use Component\Exception\Board\BoardAdminException;

/**
* 게시판 관련 Component
*
*/
class Board
{
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
}