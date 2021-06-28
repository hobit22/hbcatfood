<div class='category_tab'>
	<?php if($subCate['brand']) : ?>
	<ul class='category_tab'>
		<li class='tab<?php if (!$subCate['reqBrand']) echo " on";?>'>
			<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$subCate['cateCd']?>&subCate=<?=$subCate['reqSub']?>'>전체</a>
		</li>
	<?php for($i = 0; $i< sizeof($subCate['brand']); $i++): ?>
		<li class='tab<?php if ($subCate['brand'][$i] == $subCate['reqBrand']) echo " on";?>'>
			<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$subCate['cateCd']?>&subCate=<?=$subCate['reqSub']?>&brandCate=<?=$subCate['brand'][$i]?>'><?=$subCate['brand'][$i]?></a>
		</li>
	<?php endfor; ?>
	<?php endif;?>
	</ul>
	<?php if($subCate['sub']) : ?>
	<ul class='category_tab'>
		<li class='tab<?php if (!$subCate['reqSub']) echo " on";?>'>
			<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$subCate['cateCd']?>&brandCate=<?=$subCate['reqBrand']?>'>전체</a>
		</li>
	<?php for($i = 0; $i< sizeof($subCate['sub']); $i++): ?>
		<li class='tab<?php if ($subCate['sub'][$i] == $subCate['reqSub']) echo " on";?>'>
			<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$subCate['cateCd']?>&subCate=<?=$subCate['sub'][$i]?>&brandCate=<?=$subCate['reqBrand']?>'><?=$subCate['sub'][$i]?></a>
		</li>
	<?php endfor; ?>
	<?php endif;?>
	</ul>
</div>

<ul class='goods_list inner'>

<?php if(empty($list)): ?>
<li class='no_data'>상품이 없습니다</li>
<?php endif ;?>
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