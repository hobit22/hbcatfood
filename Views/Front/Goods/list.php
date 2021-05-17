<ul class='goods_list'>
<?php foreach ($list as $li) :  ?>
	<li class='goods'>
		<a href='<?=siteUrl("goods/view")?>?goodsNo=<?=$li['goodsNo']?>'>
			<div class='images'>
			<?php if (isset($li['images']['list'][0])) : ?>
			<img src='<?=$li['images']['list'][0]['url']?>'>
			<?php endif; ?>
			</div>
			<div class='goods_nm'>
				<?=$li['goodsNm']?>
			</div>
			<div class='short_desc'>
				<?=$li['shortDescription']?>
			</div>
			<div class='price_wrap'>
				<?php if ($li['consumerPrice']) : // 소비자가 ?>
				<strike class='consumer'><?=number_format($li['consumerPrice'])?>원</strike>
				<?php endif; ?>
				<span class='sale'><?=number_format($li['salePrice'])?>원</span>
			</div>
		</a>
	</li>	
<?php endforeach; ?>
</ul>
<?=$pagination?>