<?php
include __DIR__ . "/../vendor/autoload.php"; // 컴포저로 설치한 모듈 자동 추가

/* filp/whoops S */
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
	throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();
/* filp/whoops E */

include "funcs.php"; // 공통함수 
include "app.php"; // 공통 클래스 App
include "autoload.php"; // Component, Controller 파일 자동 추가 

App::routes(); // 라우터 처리 