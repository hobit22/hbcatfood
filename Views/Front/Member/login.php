<div class='inner'>

<h1 class='member_tit'>로그인</h1>
<div class='login_wrap'>
<form method='post' action='<?=siteUrl("member/loginOk")?>' target='ifrmHidden' autocomplete='off' class='login_form'>
	<h2>회원 로그인</h2>
	<input type='text' name='memId' placeholder='아이디'>
	<input type='password' name='memPw' placeholder='비밀번호'>
	
	<input type='submit' value='로그인' class='login_btn'>
	
	<div class='lbox_wrap'>
		<a href='<?=siteUrl("member/findId")?>' class='lbox'>아이디 찾기</a>
		<a href='<?=siteUrl("member/findPw")?>' class='lbox'>비밀번호 찾기</a>
		<a href='<?=siteUrl("member/join")?>' class='lbox'>회원가입</a>
	</div>
</form>
</div>
<div class='sns_login'>

</div>
</div>
