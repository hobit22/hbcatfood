<!-- 회원 등록/수정 양식 -->
<div class='title1'>회원 등록</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/member/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='register'>
	<dl>
		<dt>회원등급</dt>
		<dd>
			<select name='level'>
			<?php for ($i = 0; $i <= 10; $i++) : ?>
				<option value='<?=$i?>'><?=$i?></option>
			<?php endfor; ?>
			</select>
		</dd>
	</dl>
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
	
	<input type='submit' value='회원가입처리' onclick="return confirm('정말 가입처리 하시겠습니까?');" class='btn1 mt20'>
	</form>
</div>
<!--// content_box -->