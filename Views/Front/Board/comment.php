<?php
// 댓글 
$path = __DIR__ . "/Skins/".$boardSkin."/comment.php";
if (file_exists($path)) {
	include $path;
}