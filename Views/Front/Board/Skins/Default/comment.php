<!-- Default 스킨 - 댓글 -->
<div class='board_skin_default comment'>
	<form method='post' action='<?=siteUrl("board/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='idxBoard' value='<?=$idxBoard?>'>
		
		<div class='comment_form'>
			<div class='post_info'>
				<input type='text' name='poster' value='<?=isLogin()?$_SESSION['member']['memNm']:""?>'>
			</div>
			<textarea name='comment' placeholder='댓글을 작성하세요..'></textarea>
			<input type='submit' value='댓글등록'>
		</div>
		<!--// comment_form -->
	</form>
</div>
<!--// board_skin_default -->