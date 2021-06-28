<div class='inner'>
<h1>비밀번호 변경</h1>
<form method='post' action='<?=siteUrl("member/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='change_pw'>
	<input type='password' name='memPw' placeholder='변경할 비밀번호'>
	<input type='password' name='memPwRe' placeholder='비밀번호 확인'>
	<input type='submit' value='비밀번호 변경' onclick="return confirm('정말 변경하시겠습니까?');">
</form>
</div>