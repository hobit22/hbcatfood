<?php
/**
* Component, Controller 파일 자동 로드 
*
* pathinfo -> 파일 경로의 정보 -> 디렉토리, 파일명, 확장자 
* isset -> 값이 지정이 되어 있는 체크
*/
$folders = ["Component", "Controller"];
foreach ($folders as $folder) {
	$path = __DIR__ . "/../{$folder}/*";
	foreach (glob($path) as $filePath) {
		$pi = pathinfo($filePath);
		// php 파일 - 바로 추가 
		if (isset($pi['extension']) && strtolower($pi['extension']) == 'php') {	
			include $filePath;
		} else if (is_dir($filePath)) { // 한번더 순회 처리 
			foreach (glob($filePath . "/*") as $file) {
				debug($file);
			}
		}
	}
}