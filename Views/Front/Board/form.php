<form id='frmBoard' name='frmBoard' method='post' action='<?=siteUrl("board/indb")?>' target='ifrmHidden' autocomplete='off' enctype='multipart/form-data'>
	<input type='hidden' name='mode' value='register'>
	<input type='hidden' name='boardId' value='<?=$id?>'>
<?php
// 게시판 작성,수정 
$path = __DIR__ . "/Skins/".$boardSkin."/form.php";
if (file_exists($path)) {
	include $path;
}
?>
</form>