<h1><?=isset($memNo)?"회원정보수정":"회원가입"?></h1>
<form method='post' action='<?=siteUrl("member/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=isset($memNo)?"update":"register"?>'>
	<dl>
		<dt>아이디</dt>
		<dd>
			<?php if (isset($memNo)) : ?>
				<?=$memId?>
			<?php else : ?>
				<input type='text' name='memId'>
			<?php endif; ?>
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
			<input type='text' name='memNm' value='<?=isset($memNm)?$memNm:""?>'>
		</dd>
	</dl>
	<dl>
		<dt>이메일</dt>
		<dd>
			<input type='email' name='email' value='<?=isset($email)?$email:""?>'>
		</dd>
	</dl>
	<dl>
		<dt>휴대전화</dt>
		<dd>
			<input type='text' name='cellPhone' value='<?=isset($cellPhone)?$cellPhone:""?>'>
		</dd>
	</dl>
	<dl>
		<dt>주소</dt>
		<dd>
			<input type='text' name='zipcode' placeholder='우편번호' readonly class='w120' value='<?=isset($zipcode)?$zipcode:""?>'>
			<span class='btn1 search_address'>주소 검색</span>
			<input type='text' name='address' readonly  value='<?=isset($address)?$address:""?>'>
			<input type='text' name='addressSub' placeholder='나머지 주소' value='<?=isset($addressSub)?$addressSub:""?>'>
		</dd>
	</dl>
	<?php if (!isset($memNo)) : ?>
	<dl>
		<dt>약관동의</dt>
		<dd>
			<textarea id='terms'>약관 내용 추가...</textarea><br>
			<input type='checkbox' name='agree' id='agree' value='1'>
			<label for='agree'>약관에 동의합니다.</label>
		</dd>
	</dl>
	<?php endif; ?>
	<input type='submit' value='<?=isset($memNo)?'정보수정':'회원가입'?>'>
</form>