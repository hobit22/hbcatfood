<!-- Default 스킨 - 게시글 보기 -->
<div class='board_skin_default view'>
	<div class='subject'><?=$subject?></div>
	<div class='post_info'>
		Poster : <?=$poster?>(<?=$memNo?$memId:"비회원"?>)
		/ Date : <?=date("Y.m.d H:i", strtotime($regDt))?>
	</div>
	<?php if ($link) : ?>
	<div class='rows'>
		링크 : <a href='<?=$link?>' target='_blank'><?=$link?></a>
	</div>
	<?php endif; ?>
	<?php if ($email) : ?>
	<div class='rows'>
		이메일 : <a href='mailto:<?=$email?>'><?=$email?></a>
	</div>
	<?php endif; ?>
	<?php if (isset($attachFiles['files'])) : ?>
	<?php foreach ($attachFiles['files'] as $k => $file) : ?>
	<div class='rows'>
		첨부파일<?=$k+1?> : <a href='<?=siteUrl("file/download")?>?idx=<?=$file['idx']?>' target='ifrmHidden'><?=$file['fileName']?></a>
	</div>
	<?php endforeach; ?>
	<?php endif; ?>
	
	<div class='contents'><?=$contents?></div>
	
	<a href='<?=siteUrl("board/list")?>?id=<?=$boardId?>' class='btn1'>글목록</a>
	<a href='<?=siteUrl("board/write")?>?id=<?=$boardId?>' class='btn1'>글쓰기</a>
	<a href='<?=siteUrl("board/update")?>?idx=<?=$idx?>' class='btn1'>글수정</a>
	<a href='<?=siteUrl("board/indb")?>?mode=delete&idx=<?=$idx?>' onclick="return confirm('정말 삭제하시겠습니까?');" class='btn1'>글삭제</a>
</div>
<!--// board_skin_default -->