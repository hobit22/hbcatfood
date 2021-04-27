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
				if (!in_array($k, ['id', 'boardNm'])) {
					continue;
				}
				
				$inData[$k] = $v;
				
			} // endforeach 
		} // endif 
		
		$result = db()->table("board")->data($inData)->insert();
		
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
}