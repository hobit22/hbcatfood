<?php
// 게시판 조회
$path = __DIR__ . "/Skins/".$boardSkin."/view.php";
if (file_exists($path)) {
	include $path;
}