<div class='inner'>
<h1 class='member_tit'>비밀번호 찾기</h1>
<div class='findPw_wrap'>
<form method='post' action='<?=siteUrl("member/indb")?>' target='ifrmHidden' autocomplete='off' class='find_form'>
	<input type='hidden' name='mode' value='find_pw'>
	<dl>
		<dt>아이디</dt>
		<dd>
			<input type='text' name='memId'>
		</dd>
	</dl>
	<dl>
		<dt>이메일</dt>
		<dd>
			<input type='email' name='email'>
		</dd>
	</dl>
	<dl>
		<dt>휴대전화</dt>
		<dd>
			<input type='text' name='cellPhone'>
		</dd>
	</dl>
	<input type='submit' value='비밀번호 찾기' class='find_btn'>
</form>
</div>
</div>