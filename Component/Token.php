<?php

namespace Component;

/**
* Token 관련 기능
*		특정 페이지의 유효시간
*/
class Token
{
	private $expires = 300; // 300초 - 5분 
	
	/**
	* 유효시간이 있는 URL 이동 token 생성
	*
	* @param String $url - 이동할 URL 
	* @return Boolean|String - 실패 false, 성공시 토큰 접근 URL 
	*/
	public function create($url)
	{
		$date = date("Y-m-d H:i:s", time() + $this->expires);
		$token = gid();
		$inData = [
			'token' => $token,
			'expires' => $date,
			'url' => $url,
		];
		
		$result = db()->table("token")->data($inData)->insert();
		if ($result !== false) {
			$url = siteUrl("token")."?token=".$token;
			
			return $url;
		}
		
		
		return false; // 토큰 생성 실패 
	}
	
	/**
	* 유효시간 만료 체크 
	*
	*/
	public function check() 
	{
		
	}
}