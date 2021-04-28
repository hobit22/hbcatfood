<!-- Default 스킨 - 게시글 목록 -->
<div class='board_skin_default list'>
	<ul>
	<?php foreach ($list as $li) : ?>
		<li>
			<a href='<?=siteUrl("board/view")?>?idx=<?=$li['idx']?>' class='subject'>
				<?=$li['subject']?>
			</a>
			<div class='poster_info'>
				<?=$li['poster']?>
				<?=$li['memNo']?"(".$li['memId'].")":""?>
			</div>
		</li>
	<?php endforeach; ?>
	</ul>
	<?=$pagination?>
</div>
<!--// board_skin_default -->