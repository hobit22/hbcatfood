<!-- 파일 업로드 양식 -->
<div class='file_upload_form'>
	<form id='fileFrm' method='post' action='<?=siteUrl("file/uploadOk")?>' target='ifrmHidden' enctype="multipart/form-data">
		<input type='hidden' name='gid' value='<?=$gid?>'>
		<input type='hidden' name='type' value='<?=$type?>'>
		<input type='hidden' name='location' value='<?=$location?>'>
		<input type='file' name='file'>
	</form>
</div>
<!--// file_upload_form -->