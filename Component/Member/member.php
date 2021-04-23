<?php

namespace Component\Member;

use Component\Exception\Member\MemberRegisterException;

/**
* 회원관련 
*
*/
class Member
{
	private $params = []; // 처리할 데이터 
	
	/** 회원 필수 데이터 컬럼 */
	private $requiredColumns = [
		'memId' => '회원아이디',
		'memNm' => '회원명',
	];
	
	
	/**
	* 처리할 데이터 설정 
	*
	* @param Array $params 
	* @return $this
	*/
	public function data($params = [])
	{
		$this->params = $params;
		
		return $this;
	}
	
	/**
	* 유효성 검사
	*
	* @param String $mode 회원가입(register), 정보수정(update) ... 
	* @return $this 
	* @throw MemberRegisterException, MemberUpdateException ... 
	*/
	public function validator($mode = "register")
	{
		if (!$this->params) {
			$exception = "Member".ucfirst($mode)."Exception";
			throw new $exception("유효성 검사할 데이터가 없습니다.");
		}
		switch ($mode) {
			/** 회원가입 유효성 검사 */
			case "register" : 
				$required = $this->requiredColumns;
				$required['memPw'] = '비밀번호';
				$missing = [];
				foreach ($required as $col => $colNm) {
					if (!$this->params[$col]) {
						$missing[] = $colNm;
					}
				}
				
				if ($missing) {
					throw new MemberRegisterException("필수 입력 데이터 누락 - (".implode(",", $missing).")");
				}
				
				break;
		}
		
		return $this;
	}
	
	/**
	* 회원 가입 처리 
	*
	* @return Integer|Boolean 성공시 회원번호(memNo), 실패시 false
	*/
	public function register()
	{
		$inData = [
			'memId' => $this->params['memId'],
			'level' => $this->params['level']?$this->params['level']:0,
			'memPw' => '',
			'memNm' => $this->params['memNm'],
			'email' => $this->params['email'],
			'cellPhone' => $this->params['cellPhone'],
		];
		$memNo = db()->table("member")
							  ->data($inData)
							  ->insert();
		
		return $memNo;
	}
}