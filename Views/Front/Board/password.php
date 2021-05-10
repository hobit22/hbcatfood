<!-- 비회원 비밀번호 검증 양식 -->
<h1>게시글 비밀번호 확인</h1>
<form method='post' action='<?=siteUrl("board/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='check_password'>
	<input type='hidden' name='idx' value='<?=$idx?>'>
	<input type='password' name='password' placeholder='비밀번호 입력..'>
	<input type='submit' value='확인하기'>
</form>