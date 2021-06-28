<?php if (!isset($isViewList) || !$isViewList) : ?>
<div class='board_title inner'><?=$boardNm?></div>
<?php endif; ?>
<?php
// 게시판 목록
$path = __DIR__ . "/Skins/".$boardSkin."/list.php";
if (file_exists($path)) {
	include $path;
}