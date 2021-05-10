<!-- Default 스킨 form.php -->
<div class='board_skin_default'>
<dl>
	<dt>작성자</dt>
	<dd>
		<input type='text' name='poster' value='<?php if (isset($poster)) { echo $poster; } elseif (!isset($poster) && isLogin()) { echo $_SESSION['member']['memNm']; }?>'>
	</dd>
</dl>
<?php if (!isLogin()) :  // 비회원인 경우는 비밀번호 입력 항목 추가 ?>
<dl>
	<dt>비밀번호</dt>
	<dd>
		<input type='password' name='password' placeholder='비회원 글수정, 삭제 비밀번호'>
	</dd>
</dl>
<?php endif; ?>
<?php if (in_array("link", $columns)) : ?>
<dl>
	<dt>링크</dt>
	<dd>
		<input type='text' name='link' value='<?=isset($link)?$link:""?>'>
	</dd>
</dl>
<?php endif; ?>
<?php if (in_array("email", $columns)) : ?>
<dl>
	<dt>이메일</dt>
	<dd>
		<input type='email' name='email' value='<?=isset($email)?$email:""?>'>
	</dd>
</dl>
<?php endif; ?>
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
<?php if (in_array('image', $columns)) : ?>
<dl>
	<dt>이미지</dt>
	<dd>
		<span class='btn1' onclick="layer.popup('<?=siteUrl("file/upload")?>?gid=<?=$gid?>&type=image', 280, 130);">이미지 추가</span>
		<span class='uploaded_images'>
		<?php if (isset($attachFiles) && isset($attachFiles['images'])) : ?>
		<?php foreach ($attachFiles['images'] as $file) : ?>
		<span class='file_box' data-idx='<?=$file['idx']?>' data-url='<?=$file['url']?>'>
			<a href='<?=siteUrl("file/download")?>?idx=<?=$file['idx']?>' target='ifrmHidden'><?=$file['fileName']?></a>
			<i class='remove xi-file-remove'></i>
			<i class='addContents xi-upload'></i>
		</span>
		<?php endforeach;?>
		<?php endif; ?>
		</span>
	</dd>
</dl>
<?php endif; ?>
<?php if (in_array('file', $columns)) : ?>
<dl>
	<dt>파일첨부</dt>
	<dd>
		<input type='file' name='file[]' multiple>
		<?php if (isset($attachFiles) && isset($attachFiles['files'])) : ?>
		<div class='uploaded_files mt10'>
			<?php foreach ($attachFiles['files'] as $file) : ?>
			<span class='file_box' data-idx='<?=$file['idx']?>' data-url='<?=$file['url']?>'>
				<a href='<?=siteUrl("file/download")?>?idx=<?=$file['idx']?>' target='ifrmHidden'><?=$file['fileName']?></a>
				<i class='remove xi-file-remove'></i>
			</span>
			<?php endforeach;?>
		</div>
		<?php endif; ?>
	</dd>
</dl>
<?php endif; ?>
<button type='button' class='cancel_btn'>취소하기</button>
<button type='submit' class='write_btn'><?=isset($idx)?"수정":"작성"?>하기</button>
</div>
<!--// board_skin_default -->