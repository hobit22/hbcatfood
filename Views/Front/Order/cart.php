<div class='cart_page'>
	<div class='main_title'>장바구니</div>
	
	<form method='post' action='<?=siteUrl("order/indb")?>' target='ifrmHidden' aucomplete='off'>
		<input type='hidden' name='mode' value='order'>
		<table class='table_rows cart_goods'>
			<thead>
				<tr>
					<th width='20'>
						<input type='checkbox' class='selectAll' data-target-name='cartNo'>
					</th>
					<th colspan='2'>상품</th>
					<th width='150'>구매수량</th>
					<th width='100'>합계</th>
					<th width='100'></th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($list as $li) : ?>
			<tr>
				<td align='center'>
					<input type='checkbox' name='cartNo[]' value='<?=$li['cartNo']?>'>
				</td>
				<td width='80'>
					<?php if ($li['goodsImage']) : ?>
					<a href='<?=siteUrl("goods/view?goodsNo={$li['goodsNo']}")?>' target='_blank'> 
						<img src='<?=$li['goodsImage']?>' width='80'>
					</a>
					<?php endif; ?>
				</td>
				<td>
					<a class='goods_nm' href='<?=siteUrl("goods/view?goodsNo={$li['goodsNo']}")?>' target='_blank'><?=$li['goodsNm']?></a>
					<?php if ($li['optName']) : ?>
					<div class='opt_info'>
						<?=$li['optName']?> : <?=$li['optItem']?>
					</div>
					<?php endif; ?>
				</td>
				<td>
					<input type='number' name='goodsCnt[<?=$li['cartNo']?>]' value='<?=$li['goodsCnt']?>'>
					
				</td>
				<td>
					<span class='goodsTotal'><?=number_format($li['totalGoodsPrice'])?></span>원
				</td>
				<td>
					<span class='btn delete'>상품삭제</span><br>
					<span class='btn order'>바로구매</span>
				</td>
			</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
		<ul class='summary'>
			<li>
				<div class='t1'>상품 총 합계</div>
				<div class='t2'>
					<span class='totalGoodsPrice'><?=number_format($totalGoodsPrice)?></span>원
				</div>
			</li>
			<li>
				<div class='t1'>배송비 총 합계</div>
				<div class='t2'>
					<span class='totalDeliveryPrice'><?=number_format($totalDeliveryPrice)?></span>원
				</div>
			</li>
			<li>
				<div class='t1'>총 결제금액</div>
				<div class='t2'>
					<span class='totalPayPrice'><?=number_format($totalPayPrice)?></span>원
				</div>
			</li>	
		</ul>
		
	</form>
</div>
<!--// cart_page -->