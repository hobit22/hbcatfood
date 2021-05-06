<h1>회원가입</h1>
<form method='post' action='<?=siteUrl("member/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='register'>
	<dl>
		<dt>아이디</dt>
		<dd>
			<input type='text' name='memId'>
		</dd>
	</dl>
	<dl>
		<dt>비밀번호</dt>
		<dd>
			<input type='password' name='memPw'>
		</dd>
	</dl>
	<dl>
		<dt>비밀번호확인</dt>
		<dd>
			<input type='password' name='memPwRe'>
		</dd>
	</dl>
	<dl>
		<dt>회원명</dt>
		<dd>
			<input type='text' name='memNm'>
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
	<dl>
		<dt>약관동의</dt>
		<dd>
			<textarea id='terms'>약관 내용 추가...</textarea><br>
			<input type='checkbox' name='agree' id='agree'>
			<label for='agree'>약관에 동의합니다.</label>
		</dd>
	</dl>
	<input type='submit' value='회원가입'>
</form>