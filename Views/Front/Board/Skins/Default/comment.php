<!-- Default 스킨 - 댓글 -->
<div class='board_skin_default comment'>
	<form method='post' action='<?=siteUrl("board/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='register_comment'>
		<input type='hidden' name='idxBoard' value='<?=$idxBoard?>'>
		
		<div class='comment_form'>
			<div class='post_info'>
				<input type='text' name='poster' value='<?=isLogin()?$_SESSION['member']['memNm']:""?>'>
			</div>
			<div class='comment_wrap'>
				<textarea name='comment' placeholder='댓글을 작성하세요..'></textarea>
				<input type='submit' value='댓글등록'>
			</div>
		</div>
		<!--// comment_form -->
	</form>
	
	<!-- 댓글 출력 S -->
	<?php if ($list) : ?>
	<ul class='comment_list'>
	<?php foreach ($list as $li) : ?>
		<li>
			<div class='comment'><?=nl2br($li['comment'])?></div>
			<div class='post_info'>
				<?=$li['poster']?><?=$li['memId']?"(".$li['memId'].")":""?>
				/ <?=date("Y.m.d H:i", strtotime($li['regDt']))?>
			</div>
			<div class='btns' data-idx='<?=$li['idx']?>'>
				<span class='update_comment btn1'>수정</span>
				<span class='delete_comment btn1'>삭제</span>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<!--// 댓글 출력 E -->
</div>
<!--// board_skin_default -->