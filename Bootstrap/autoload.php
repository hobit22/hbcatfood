<?php
/**
* Component, Controller 파일 자동 로드 
*
* pathinfo -> 파일 경로의 정보 -> 디렉토리, 파일명, 확장자 
* isset -> 값이 지정이 되어 있는 체크
*/
$path = [
	__DIR__ . "/../Component",
	__DIR__ . "/../Controller",
];
$tmp = App::includeFiles($path);
$fileList = $tmp2 = [];
foreach ($tmp as $t) {
	$pi = pathinfo($t);
	if ($pi['filename'] == 'Controller') {
		$fileList[] = $t;
	} else if (!preg_match("/Component/", $t)) {
		$dirs = explode("/", $pi['dirname']);
		$tmp2[count($dirs)][] = $t;
	} else {
		$fileList[] = $t;
	}
}

krsort($tmp2);

foreach ($tmp2 as $list) {
	foreach ($list as $f) {
		$fileList[] = $f;
	}
}

foreach ($fileList as $f) {
	include_once $f;
}