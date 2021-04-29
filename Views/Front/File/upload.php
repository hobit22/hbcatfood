<!-- 파일 업로드 양식 -->
<form id='fileFrm' method='post' action='<?=siteUrl("file/uploadOk")?>' target='ifrmHidden' enctype="multipart/form-data">
	<input type='hidden' name='gid' value='<?=$gid?>'>
	<input type='file' name='file'>
</form>