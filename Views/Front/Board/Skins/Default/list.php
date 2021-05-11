<!-- Default 스킨 - 게시글 목록 -->
<div class='board_skin_default list'>
	<!-- 게시판 분류 S -->
	<?php if ($confCategory) : ?>
	<ul class='category_tab'>
		<li class='tab<?php if (!$category) echo " on";?>'>
			<a href='<?=siteUrl("board/list")?>?id=<?=$id?>'>전체</a>
		</li>
	<?php foreach ($confCategory as $cate) : ?>
		<li class='tab<?php if ($category == $cate) echo " on";?>'>
			<a href='<?=siteUrl("board/list")?>?id=<?=$id?>&category=<?=$cate?>'><?=$cate?></a>
		</li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<!-- 게시판 분류 E -->
	<ul>
	<?php foreach ($list as $li) : ?>
		<li class='list_rows'>
			<a href='<?=siteUrl("board/view")?>?idx=<?=$li['idx']?>' class='subject'>
				<?=$li['category']?"[".$li['category']."]":""?>
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