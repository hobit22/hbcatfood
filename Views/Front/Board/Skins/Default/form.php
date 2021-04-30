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
	<dd>
		<span class='btn1' onclick="layer.popup('../file/upload?gid=<?=$gid?>&type=image', 280, 130);">이미지 추가</span>
		<span class='uploaded_images'>
		<?php if (isset($attachFiles) && isset($attachFiles['images'])) : ?>
		<?php foreach ($attachFiles['images'] as $file) : ?>
		<span class='file_box' data-idx='<?=$file['idx']?>' data-url='${data.url}'>
			<a href='../file/download?idx=<?=$file['idx']?>' target='ifrmHidden'><?=$file['fileName']?></a>
			<i class='remove xi-file-remove'></i>
			<i class='addContents xi-upload'></i>
		</span>
		<?php endforeach;?>
		<?php endif; ?>
		</span>
	</dd>
</dl>
<button type='button' class='cancel_btn'>취소하기</button>
<button type='submit' class='write_btn'><?=isset($idx)?"수정":"작성"?>하기</button>
</div>
<!--// board_skin_default -->