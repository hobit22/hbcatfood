<!-- Default 스킨 - 게시글 목록 -->
<div class='board_skin_default list'>
	<?php if ($confCategory) : ?>
	<ul class='category_tab'>
	
	</ul>
	<?php endif; ?>
	<ul>
	<?php foreach ($list as $li) : ?>
		<li class='list_rows'>
			<a href='<?=siteUrl("board/view")?>?idx=<?=$li['idx']?>' class='subject'>
				<?=$li['subject']?>
			</a>
			<div class='post_info'>
				<?=$li['poster']?>
				<?=$li['memNo']?"(".$li['memId'].")":""?>
				/ <?=date("Y.m.d", strtotime($li['regDt']))?>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
	<?=$pagination?>
</div>
<!--// board_skin_default -->