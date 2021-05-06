<h1>로그인</h1>
<form method='post' action='<?=siteUrl("member/loginOk")?>' target='ifrmHidden' autocomplete='off'>
	<input type='text' name='memId' placeholder='아이디'>
	<input type='password' name='memPw' placeholder='비밀번호'>
	
	<div>
		<a href='<?=siteUrl("member/findId")?>'>아이디 찾기</a> / 
		<a href='<?=siteUrl("member/findPw")?>'>비밀번호 찾기</a>
	</div>
	
	<input type='submit' value='로그인'>
</form>