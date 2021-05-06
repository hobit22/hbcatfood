<?php

namespace Component\Member;

use App;
use Component\Exception\Member\MemberRegisterException;
use Component\Exception\Member\MemberException;

/**
* 회원관련 
*
*/
class Member
{
	private $params = []; // 처리할 데이터 
	private $exception = "";
	
	/** 회원 필수 데이터 컬럼 */
	private $requiredColumns = [
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
		$this->exception = $exception;
		
		if (!$this->params) {
			throw new $exception("유효성 검사할 데이터가 없습니다.");
		}
		switch ($mode) {
			/** 회원정보 수정 유효성 검사 */
			case "update" : 
			/** 회원가입 유효성 검사 */
			case "register" : 
				/** 필수 데이터 체크 S */
				$required = $this->requiredColumns;
				
				if ($mode == 'register') { // 회원 가입일때만 비밀번호 필수 컬럼
					$required['memId'] = '회원아이디';
					$required['memPw'] = '비밀번호';
				}
				
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
				if ($mode == 'register') {
					$this->validateMemId();
				}
				
				/** 비밀번호 체크 */
				if ($mode == 'register') { // 회원가입일땐 반드시 비밀번호 체크 
					$this->validatePassword();
				// 회원정보 수정일때 비빌번호 변경 처리시만 체크 
				} else if ($mode == 'update' && $this->params['memPw']) { 
					$this->validatePassword();
				}
			
				/** 이메일 체크 */
				$this->validateEmail();
				
				/** 휴대전화번호 체크 */
				$this->validateCellPhone();
				
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
	public function validateMemId()
	{
		$exception = $this->exception;
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
	public function validatePassword()
	{
		$exception = $this->exception;
		
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
	* 이메일 유효성 검사 체크 
	*
	* @throw Exception 유효성 검사 실패 
	*/
	public function validateEmail()
	{
		$exception = $this->exception;
		
		$email = $this->params['email'] ?? "";
		// 이메일이 없으면 중지 
		if (!$email)
			return;
		
		/**
		filter_var 
		FILTER_VALIDATE_EMAIL
		*/
		
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if ($email === false) { // 유효성 검사 실패 
			throw $exception("이메일 형식이 아닙니다.");
		}
	}
	
	/**
	* 휴대전화번호 유효성 검사 
	*
	* @throw Exception 유효성 검사 실패
	*/
	public function validateCellPhone()
	{
		$exception = $this->exception;
		$cellPhone = $this->params['cellPhone'] ?? "";
		if (!$cellPhone) 
			return;
		
;
		/**
		   010-3481-2101
		   010_3481_2101
		   01034812101
		   010 3481 2101
		   1. 검증 통일성을 위해서 숫자만 추출 
		   2. 패턴
			   /(01[016789])(\d{3,4})(\d{4})/
			   
		    3. 유효성 검사
			4. 전화번호 formating -> 010-3481-2101
		*/
		$cellPhone = preg_replace("/[^\d]/", "", $cellPhone);
		$pattern = "/(01[016789])(\d{3,4})(\d{4})/";
		if (!preg_match($pattern, $cellPhone)) {
			throw new $exception("휴대전화번호 형식이 아닙니다.");
		}
		
		$this->params['cellPhone'] = preg_replace($pattern, "$1-$2-$3", $cellPhone);
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
			'level' => isset($this->params['level'])?$this->params['level']:0,
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
	
	/**
	* 회원정보 수정 
	*
	* @return Boolean 성공시 true, 실패시 false
	*/
	public function update()
	{
		$upData = [
			'level' => $this->params['level'] ?? 0,
			'memNm' => $this->params['memNm'],
			'email' => $this->params['email'],
			'cellPhone' => $this->params['cellPhone'],
		];
		
		// 비밀번호 변경시 
		if ($this->params['memPw']) {
			$security = App::load(\Component\Core\Security::class);
			$upData['memPw'] = $security->createHash($this->params['memPw']);
		}
		
		$result = db()->table("member")
						  ->data($upData)
						  ->where(["memNo" => $this->params['memNo']])
						  ->update();
		
		return $result !== false;
	}
	
	/**
	* 회원 삭제 
	*
	* @param Integer $memNo 회원번호 
	* @return Boolean
	*/
	public function delete($memNo)
	{
		$result = db()->table("member")
							->where(["memNo" => $memNo])
							->delete();
		
		return $result !== false;
	}
	
	/**
	* 회원 등급변경 
	*
	* @param Integer $memNo 회원번호
	* @param Integer $level 회원 등급
	*
	* @return Boolean
	*/
	public function changeLevel($memNo, $level)
	{
		$result = db()->table("member")
							->data(["level" => $level])
							->where(["memNo" => $memNo])
							->update();
		
		return $result !== false;
	}
	
	/**
	* 로그인 처리 
	*
	* @param String $memId 아이디
	* @param String $memPw 비밀번호 
	*
	* @return Boolean 성공 true, 실패 false
	*/
	public function login($memId, $memPw)
	{
		$info = $this->get($memId); // 회원정보 추출 
		if (!$info) { // 회원이 존재하는지 여부 
			$this->errMessage = "존재하지 않는 회원입니다.";
			return false;
		}
		
		// 회원이 입력한 비밀번호와 DB에 있는 비밀번호 hash가 일치하는가?
		$security = App::load(\Component\Core\Security::class);
		$result = $security->compareHash($memPw, $info['memPw']);
		if (!$result) { 
			$this->errMessage = "로그인 비밀번호 불일치";
			return false;
		}
		
		// 회원 정보를 찾을 수 있는 단서를 SESSION에 저장
		$_SESSION['memNo'] = $info['memNo'];
		
		return true;
	}
	
	/**
	* 회원정보 조회
	*
	* @param Integer|String 숫자 - 회원번호, 문자 - 아이디 
	* @return Array
	*/
	public function get($memNo = null)
	{
		$memNo = $memNo?$memNo:$_SESSION['memNo'];
		if (!$memNo) return [];
		
		if (!is_numeric($memNo)) { // 숫자가 아닌 경우는 아이디 -> 회원 번호 변경
			$row = db()->table('member')
							->select("memNo")
							->where(["memId" => $memNo])
							->row();
			if ($row && isset($row['memNo'])) $memNo = $row['memNo'];
		}
		
		if (!$memNo) return [];
		
		$row = db()->table("member")
						->where(["memNo" => $memNo])
						->row();
						
		return $row;
	}
	
	/**
	* 로그인 여부 체크 
	*
	* @return Boolean 
	*/
	public function isLogin()
	{
		$memNo = $_SESSION['memNo'] ?? 0;
		
		return $memNo > 0;
	}
	
	/**
	* 로그아웃 
	*
	*/
	public function logout()
	{
		session_destroy();
	}
	
	/**
	* 회원 아이디 검색
	*
	* @param String $memNm 회원명
	* @param String $email 이메일
	* @parma String $cellPhone 휴대전화번호
	*
	* @return String 회원 아이디 
	*/
	public function findMemId($memNm, $email, $cellPhone) 
	{
		// 휴대전호번호 -> DB 형식에 맞게 변경(000-0000-0000)
		// 숫자만 추출 -> 형식에 맞게 변환 
		$pattern = "/([0-9]{3})([0-9]{4})([0-9]{4})/";
		$cellPhone = preg_replace("/[^0-9]/", "", $cellPhone); // 숫자만 추출 
		$cellPhone = preg_replace($pattern, "$1-$2-$3", $cellPhone); // 형식에 맞게 변환
		
		$where = [
			'memNm' => $memNm,
			'email' => $email,
			'cellPhone' => $cellPhone,
		];
		$row = db()->table("member")
						->select("memId")
						->where($where)
						->row();
						
		$memId = isset($row['memId'])?$row['memId']:"";
		
		return $memId;
	}
	
	/**
	* 회원 비밀번호 찾기 
	*			비밀번호 초기화 URL을 생성 -> 메일로 전송 
	*
	* @param String $memId 아이디
	* @param String $email 이메일 
	* @param String $cellPhone 휴대전화번호
	*
	* @throw MemberException 정보 불일치 
	*/
	public function findMemPw($memId, $email, $cellPhone) 
	{
		/**
		1. 회원정보 일치 여부 체크 
		2. URL 토큰 생성 (토큰 - 유효시간, 이동할 URL)
		3. 이메일 정송
		*/
		
		$where = [
			'memId' => $memId, 
			'email' => $email,
			'cellPhone' => $cellPhone,
		];
		$cnt = db()->table("member")->where($where)->count();
	
		if (!$cnt) {
			throw new MemberException("일치하는 회원이 없습니다.");
		}
		
		$token = App::load(\Component\Token::class);
		
		$url = siteUrl("member/changePw");
		$_SESSION['changePw_memId'] = $memId;
	
		$tokenUrl = $token->create($url);
		echo $tokenUrl;
	}
}