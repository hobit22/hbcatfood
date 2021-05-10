<?php
/**
* 공통 함수 
*
*/

/**
* 변수, 객체, 배열의 데이터 확인 함수
*
* @param Mixed $v 확인 데이터 
*/
function debug($v = null)
{
	echo "<xmp style='background-color: black; color: yellow; font-size: 12px; padding: 10px; font-weight: bold;'>";
	print_r($v);
	echo "</xmp>";
}


/**
* DB 인스턴스 호출 
*
* @return Instance
*/
function db()
{
	return \App::load(\Component\Core\DB::class);
}

/**
* Request 인스턴스 호출 
*
* @return Instance
*/
function request()
{
	return \App::load(\Component\Core\Request::class);
}

/**
* 사이트 설정 
*
* @return Array
*/
function getConfig()
{	
	$config = [];
	$path = __DIR__ . "/../../config.ini";
	if (file_exists($path)) {
		$config = parse_ini_file($path);
	}
	return $config;
}

/**
* 사이트 FULL URL 생성 함수 
*
* @return String
*/
function siteUrl($url = null)
{
	$config = getConfig();
	
	return $config['mainurl'] . $url;
}

/**
* 페이지 이동 
*
* @param String $url 이동할 경로 
* @param String $target 이동할 창(self - 현재창, parent - 부모창)
*/
function go($url, $target = "self")
{
	$url = siteUrl($url);
	
	echo "<script>{$target}.location.href='{$url}';</script>";
	exit;
}

/**
* 페이지 새로고침 
*
* @param String $target 새로고침할 창(self - 현재창, parent - 부모창)
*/
function reload($target = "self")
{
	echo "<script>{$target}.location.reload();</script>";
	exit;
}

/**
* 메세지 alert 처리, 이동 또는 뒤로 가기 처리 
*
* @param String $msg 알림 메세지
* @param Integer|String $action 
						숫자 -> history.go  (뒤로, 앞으로)
						문자 -> location.href (페이지 이동)
* @param String $target 
								- self - 현재창 이동 
								- parent - 부모창 이동 
*/
function msg($msg, $action = 0, $target = 'self') 
{
	
	echo "<script>alert('{$msg}');</script>";
	if ($action) {
		if (is_numeric($action)) { // history.go 
			echo "<script>{$target}.history.go({$action});</script>";
		} else { // location.href 
			go($action, $target);
		}
		exit;
	} // endif 
}

/**
* 로그인여부 체크 
*
* @return Boolean
*/
function isLogin()
{
	$member = App::load(\Component\Member\Member::class);
	
	return $member->isLogin();
}

/**
* 그룹 ID(유일한 값)
* md5 -> hash -> md5 형식의 해시 
* @return String
*/
function gid()
{ 
	return md5(uniqid());
}

/**
* 접속 브라우저별 사용자 구분 ID 
*  (IP + 브라우저 정보(user-agent)
*   IP - > $_SERVER['REMOTE_ADDR'] 
*   user-agent -> $_SERVER['HTTP_USER_AGENT']
*/
function browserId()
{
	$bid = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
	
	return $bid;
}

/**
* 관리자 여부 체크 
*
* @return Boolean true - 관리자, false - 일반회원 또는 비회원 
*/
function isAdmin()
{
	$isAdmin = false;
	if (isLogin() && $_SESSION['member']['level'] == 10) $isAdmin = true;
	
	return $isAdmin;
}