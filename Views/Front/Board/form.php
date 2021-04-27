<?php
// 게시판 작성,수정 
$path = __DIR__ . "/Skins/".$boardSkin."/form.php";
if (file_exists($path)) {
	include $path;
}