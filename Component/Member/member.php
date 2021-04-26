<?php

namespace Component\Member;

use App;
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
		$exception = "\\Component\\Exception\\Member\\Member".ucfirst($mode)."Exception";
		if (!$this->params) {
			throw new $exception("유효성 검사할 데이터가 없습니다.");
		}
		switch ($mode) {
			/** 회원가입 유효성 검사 */
			case "register" : 
				/** 필수 데이터 체크 S */
				$required = $this->requiredColumns;
				$required['memPw'] = '비밀번호';
				$missing = [];
				foreach ($required as $col => $colNm) {
					if (!$this->params[$col]) {
						$missing[] = $colNm;
					}
				}
				
				if ($missing) {
					throw new $exception("필수 입력 데이터 누락 - (".implode(",", $missing).")");
				}
				/* 필수 데이터 체크 E */
				
				/** 아이디 체크 */
				$this->validateMemId($mode);
				
				/** 비밀번호 체크 */
				$this->validatePassword($mode);

				break;
		}
		
		return $this;
	}
	
	/**
	* 회원 아이디 유효성 검사 
	*
	*  1. 이미 가입된 아이디 인지 체크 
	*  2. 자리수  8~30 사이
	*  3. 소문자영문자 + 숫자
	*/
	public function validateMemId($mode = 'register')
	{
		$mode = $mode?$mode:"register";
		$exception = "\\Component\\Exception\\Member\\Member".ucfirst($mode)."Exception";
		$memId = $this->params['memId'] ?? "";
		if (!$memId) {
			throw new $exception("아이디를 입력하세요.");
		}
		
		/* 중복 아이디 체크 S */
		$cnt = db()->table("member")->where(["memId" => $memId])->count();
		if ($cnt > 0) {
			throw new $exception("이미 가입된 아이디 입니다 - {$memId}");
		}
		/* 중복 아이디 체크 E */
		
		/* 자리수 + 문자 제한 체크 S */
		if (strlen($memId) < 8 || strlen($memId) > 30 || preg_match("/[^a-z0-9]/", $memId)) {
			throw new $exception("아이디는 8~30자리의 소문자영문자와 숫자로 구성해 주세요.");
		}
		/* 자리수 + 문자 제한 체크 E */
		
	}
	
	/**
	* 비밀번호 유효성 검사 
	*
	* @param String $mode 처리(register - 회원가입, update - 회원정보 수정)
	* @throw Exception 유효성검사 실패 
	*/
	public function validatePassword($mode = 'register')
	{
		$mode = $mode?$mode:"register";
		$exception = "\\Component\\Exception\\Member\\Member".ucfirst($mode)."Exception";
		
		$memPw = $this->params['memPw'] ?? "";
		$memPwRe = $this->params['memPwRe'] ?? "";
				
		if (!$memPw) {
			throw new $exception("비밀번호를 입력하세요.");
		}
		
		if (!$memPwRe) {
			throw new $exception("비밀번호 확인을 해 주세요.");
		}
		
		if ($memPw != $memPwRe) {
			throw new $exception("비밀번호가 일치하지 않습니다.");
		}
		
		/**
			복잡성 
			1. 자리수(8~30)
			2. 알파벳 + 숫자 + 특수문자 포함(반드시 1개이상)하는 조건 
			3. 알파벳은 최소 1자리는 대문자 
		*/
		$msg = "비밀번호는 8~30자리의 알파벳(대문자 포함), 숫자, 특수문자로 조합하여 만들어 주세요.";
		if (strlen($memPw) < 8 || strlen($memPw) > 30 || !preg_match("/[a-z]/", $memPw) || !preg_match("/[A-Z]/", $memPw) || !preg_match("/[\d]/", $memPw) || !preg_match("/[~!@#$\^&*()]/", $memPw)) {
			throw new $exception($msg);
		}
	}
	
	/**
	* 회원 가입 처리 
	*
	* @return Integer|Boolean 성공시 회원번호(memNo), 실패시 false
	*/
	public function register()
	{
		$security = App::load(\Component\Core\Security::class);
		$inData = [
			'memId' => $this->params['memId'],
			'level' => $this->params['level']?$this->params['level']:0,
			'memPw' => $security->createHash($this->params['memPw']),
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