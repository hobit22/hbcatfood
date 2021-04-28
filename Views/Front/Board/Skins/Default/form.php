<!-- Default 스킨 form.php -->
<div class='board_skin_default'>
<dl>
	<dt>작성자</dt>
	<dd>
		<input type='text' name='poster' value='<?php if (isset($poster)) { echo $poster; } elseif (!isset($poster) && isLogin()) { echo $_SESSION['member']['memNm']; }?>'>
	</dd>
</dl>
<dl>
	<dt>제목</dt>
	<dd>
		<input type='text' name='subject' value='<?=isset($subject)?$subject:""?>'>
	</dd>
</dl>
<dl>
	<dt>내용</dt>
	<dd>
		<textarea name='contents' id='contents'><?=isset($contents)?$contents:""?></textarea>
	</dd>
</dl>
<dl>
	<dt>이미지</dt>
	<dd></dd>
</dl>
<button type='button' class='cancel_btn'>취소하기</button>
<button type='submit' class='write_btn'><?=isset($idx)?"수정":"작성"?>하기</button>
</div>
<!--// board_skin_default -->