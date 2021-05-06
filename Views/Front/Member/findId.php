<h1>아이디 찾기</h1>
<?php if ($memId) : // 아이디 찾음 ?>

<div class='guide_box'>
	회원님의 아이디는 <b><?=$memId?></b>입니다.<br>
	
	<a href='<?=siteUrl("member/login")?>'>로그인으로 이동</a>
</div>

<?php else : ?>
<form method='post' action='<?=siteUrl("member/findId")?>' autocomplete='off'>
	<input type='hidden' name='isSubmitted' value='1'>
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
	<input type='submit' value='아이디찾기'>
</form>
<?php endif; ?>