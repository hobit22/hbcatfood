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