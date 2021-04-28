<!-- Default 스킨 - 게시글 보기 -->
<div class='board_skin_default view'>
	<div class='subject'><?=$subject?></div>
	<div class='post_info'>
		Poster : <?=$poster?>(<?=$memNo?$memId:"비회원"?>)
		/ Date : <?=date("Y.m.d H:i", strtotime($regDt))?>
	</div>
	<div class='contents'><?=$contents?></div>
	
	<a href='<?=siteUrl("board/list")?>?id=<?=$boardId?>' class='btn1'>목록</a>
	<a href='<?=siteUrl("board/update")?>?idx=<?=$idx?>' class='btn1'>수정</a>
	<a href='<?=siteUrl("board/indb")?>?mode=delete&idx=<?=$idx?>' onclick="return confirm('정말 삭제하시겠습니까?');" class='btn1'>삭제</a>
</div>
<!--// board_skin_default -->