<div class='goods_view'>
	<div class='goods_top'>
		<div class='images'>
			<div class='swiper-container'>
				<div class='swiper-wrapper'>
					<?php if ($images['main']) : ?>
					<?php foreach ($images['main'] as $image) : ?>
						<div class='swiper-slide'>
							<img src='<?=$image['url']?>'>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<div class='swiper-pagination'></div>
			</div>
		</div>
		<!--// images -->
		<div class='info'>
			<div class='goods_nm'><?=$goodsNm?></div>
			<div class='short_desc'><?=$shortDescription?></div>
			
			<dl>
				<dt>판매가격</dt>
				<dd>
					<?php if ($consumerPrice) : ?>
					<strike class='consumer'><?=number_format($consumerPrice)?>원</strike>
					<?php endif; ?>
					<span class='price'><?=number_format($salePrice)?></span>원
				</dd>
			</dl>
			<dl>
				<dt>배송비</dt>
				<dd></dd>
			</dl>
			<?php if ($options) : // 옵션이 있는 경우 ?>
			<?php foreach ($options['optNames'] as $no => $optName) : ?>
			<dl>
				<dt><?=$optName?></dt>
				<dd>
					<select name='options[<?=$no?>]' class='options'>
						<option value=''>- <?=$optName?> 선택 -</option>
					<?php foreach ($options['opts'][$no] as $opt) : 
								if (!$opt['isDisplay']) continue;
					?>
						<option value='<?=$opt['optNo']?>'>
							<?=$opt['optName']?>
							<?=$opt['addPrice']?"(".number_format($opt['addPrice'])."원)":""?>
						</option>
					<?php endforeach; ?>
					</select>
				</dd>
			</dl>
			<?php endforeach; ?>
			<?php else : // 옵션 X, 단품 판매 ?>
			<dl>
				<dt>구매수량</dt>
				<dd></dd>
			</dl>
			<?php endif; ?>
		</div>
		<!--// info -->
	</div>
	
	<!--// goods_top -->
	<div class='description'>
		<?=$description?>
	</div>
</div>
<!-- goods_view -->