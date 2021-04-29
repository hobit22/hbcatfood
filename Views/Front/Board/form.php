<div class='board_title'><?=$boardNm?></div>

<form id='frmBoard' name='frmBoard' method='post' action='<?=siteUrl("board/indb")?>' target='ifrmHidden' autocomplete='off' enctype='multipart/form-data'>
	<input type='hidden' name='mode' value='<?=isset($idx)?"update":"register"?>'>
	<input type='hidden' name='boardId' value='<?=$id?>'>
	<input type='hidden' name='gid' value='<?=$gid?>'>
	<?php if (isset($idx)) : // 게시글 수정 ?>
	<input type='hidden' name='idx' value='<?=$idx?>'>
	<?php endif; ?>
<?php
// 게시판 작성,수정 
$path = __DIR__ . "/Skins/".$boardSkin."/form.php";
if (file_exists($path)) {
	include $path;
}
?>
</form>