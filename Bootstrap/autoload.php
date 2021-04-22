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
$fileList = App::includeFiles($path);
foreach ($fileList as $f) {
	include_once $f;
}