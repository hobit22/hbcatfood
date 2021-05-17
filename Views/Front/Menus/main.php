<!-- 프론트 메인 메뉴 -->
<?php if ($categories) : ?>
<ul class='main_menu'>
<?php foreach ($categories as $c) : 
			if (!$c['isDisplay']) continue; // 미노출 상품 분류는 건너 뛴다
?>
	<li class='menu'>
		<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$c['cateCd']?>'><?=$c['cateNm']?></a>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>