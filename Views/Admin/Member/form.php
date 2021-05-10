<!-- 회원 등록/수정 양식 -->
<div class='title1'>회원 <?=isset($memNo)?"수정":"등록"?></div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/member/indb")?>' target='ifrmHidden' autocomplete='off'>
	<input type='hidden' name='mode' value='<?=isset($memNo)?"update":"register"?>'>
	<?php if (isset($memNo)) : ?>
	<input type='hidden' name='memNo' value='<?=$memNo?>'>
	<?php endif; ?>
	<dl>
		<dt>회원등급</dt>
		<dd>
			<select name='level'>
			<?php for ($i = 0; $i <= 10; $i++) : ?>
				<option value='<?=$i?>'<?php if (isset($level) && $level == $i) echo " selected"?>><?=$i?></option>
			<?php endfor; ?>
			</select>
		</dd>
	</dl>
	<dl>
		<dt>아이디</dt>
		<dd>
			<?php if(isset($memNo)) : ?>
			<?=$memId?>
			<?php else : ?>
			<input type='text' name='memId' value='<?=isset($memId)?$memId:""?>'>
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
			<span class='btn2 search_address'>주소 검색</span>
			<input type='text' name='address' readonly value='<?=isset($address)?$address:""?>'>
			<input type='text' name='addressSub' placeholder='나머지 주소' value='<?=isset($addressSub)?$addressSub:""?>'>
		</dd>
	</dl>
	<input type='submit' value='회원<?=isset($memNo)?"수정":"가입"?>처리' onclick="return confirm('정말 <?=isset($memNo)?"수정":"가입"?>처리 하시겠습니까?');" class='btn1 mt20'>
	</form>
</div>
<!--// content_box -->