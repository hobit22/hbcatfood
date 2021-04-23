<?php

namespace Component\Core;

/**
* 암호화, 복호화, 해시 
*
*/
class Security
{
	private $cost = 10; // bcrypt 해시 round 값
	
	/**
	* 해시 생성
	*
	* @param String $type - 해시종류 
	*			hash 
	*			password_hash
	*/
	public function createHash($data, $type = 'bcrypt')
	{
		$type = $type?$type:"bcrypt";
		
		$type = strtolower($type);
		if ($type == 'bcrypt') { // password_hash
			$hash = password_hash($data, PASSWORD_DEFAULT, ["cost" => $this->cost]);
		} else { // hash 
			$hash = hash($type, $data);
		}
		
		return $hash;
	}
	
	/**
	* 해시 일치 여부 체크 
	*
	* @param String $data 체크할 데이터
	* @param String $hash 해시
	* @param String $type - 해시 알고리즘 종류(bcrypt, md5, sha256, sha512 ... )
	*
	* @return Boolean 일치 true, 불일치 false
	*/
	public function compareHash($data, $hash, $type = 'bcrypt')
	{
		$type = $type?$type:"bcrypt";
		$type = strtolower($type);
		
		if ($type = 'bcrypt') { // password_verify 
			return password_verify($data, $hash);
		} else { // hash 
			return $hash == hash($type, $data);
		}
	}
}