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
		<dt>주소</dt>
		<dd>
			<input type='text' name='zipcode' placeholder='우편번호' readonly class='w120'>
			<span class='btn1 search_address'>주소 검색</span>
			<input type='text' name='address' readonly>
			<input type='text' name='addressSub' placeholder='나머지 주소'>
		</dd>
	</dl>
	<dl>
		<dt>약관동의</dt>
		<dd>
			<textarea id='terms'>약관 내용 추가...</textarea><br>
			<input type='checkbox' name='agree' id='agree' value='1'>
			<label for='agree'>약관에 동의합니다.</label>
		</dd>
	</dl>
	<input type='submit' value='회원가입'>
</form>