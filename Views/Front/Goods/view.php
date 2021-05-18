<div class='goods_view'>
	<form name='goodsFrm' id='goodsFrm' method='post' action='<?=siteUrl("goods/indb")?>' target='ifrmHidden' autocomplete='off'>
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
				<dd>
					<?php if ($delivery['deliveryPrice'] > 0) : // 배송비가 있는 경우 ?>
						<?=number_format($delivery['deliveryPrice'])?>원(<?=$delivery['deliveryName']?>)
					<?php else : // 배송비가 0인 경우 ?>
						무료배송
					<?php endif; ?>
				</dd>
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
							<?=$opt['optItem']?>
							<?=$opt['addPrice']?"(".number_format($opt['addPrice'])."원)":""?>
						</option>
					<?php endforeach; ?>
					</select>
				</dd>
			</dl>
			<?php endforeach; ?>
			<ul class='selected_opts'>	
				<!-- 선택된 옵션이 박스 형태로 붙여지는 부분 -->
			</ul>
			
			<?php else : // 옵션 X, 단품 판매 ?>
			<dl>
				<dt>구매수량</dt>
				<dd class='goodsCnt_wrap'>
					<input type='number' name='goodsCnt' value='1' class='goodsCnt'>
					<i class='xi-caret-up-square-o goodsCnt_up'></i>
					<i class='xi-caret-down-square-o goodsCnt_dn'></i>
				</dd>
			</dl>
			<?php endif; ?>
			
			<div class='buy_btns'>
				<span class='btns cart'>장바구니</span>
				<span class='btns order'>바로구매</span>
			</div>
			<!--// buy_btns -->
		</div>
		<!--// info -->
	</div>
	<!--// goods_top -->
	</form>
	
	<div class='description'>
		<?=$description?>
	</div>
</div>
<!-- goods_view -->

<script type='text/html' id='opt_template'>
	<li class='opt_rows' id='opt_rows_<%optNo%>'>
		<input type='hidden' name='optNo[]' value='<%optNo%>'>
		<div class='box opt_nm'>
			<%optItem%>
		</div>
		<div class='box goodsCnt_wrap'>
			<input type='number' name='goodsCnt[<%optNo%>]' value='1' class='goodsCnt'>
			<i class='xi-caret-up-square-o goodsCnt_up'></i>
			<i class='xi-caret-down-square-o goodsCnt_dn'></i>
		</div>
		<div class='box opt_price'>
			<span class='price'><%optPrice%></span>원
		</div>
		<i class='xi-close remove'></i>
	</li>	
</script>