		<table class='table_rows cart_goods'>
			<thead>
				<tr>
					<?php if (!isset($isOrder)) : ?>
					<th width='20'>
						<input type='checkbox' class='selectAll' data-target-name='cartNo' checked>
					</th>
					<?php endif; ?>
					<th colspan='2'>상품</th>
					<th width='150'>구매수량</th>
					<th width='100'>합계</th>
					<?php if (!isset($isOrder)) : ?>
					<th width='130'></th>
					<?php endif; ?>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($list as $li) : ?>
			<tr>
				<?php if (!isset($isOrder)) : // 장바구니 ?>
				<td align='center'>
					<input type='checkbox' name='cartNo[]' value='<?=$li['cartNo']?>' checked>
				</td>
				<?php else : // 주문서 ?>
					<input type='hidden' name='cartNo[]' value='<?=$li['cartNo']?>'>
				<?php endif; ?>
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
				<td align='center'>
					<?php if (isset($isOrder)) : // 주문서 ?>
					<?=number_format($li['goodsCnt'])?>개
					<?php else : // 장바구니 ?>
					<input type='number' name='goodsCnt[<?=$li['cartNo']?>]' value='<?=$li['goodsCnt']?>' class='goodsCnt'>
					<i class='xi-caret-up-square-o goodsCnt_up'></i>
					<i class='xi-caret-down-square-o goodsCnt_dn'></i>
					<?php endif; ?>
				</td>
				<td align='center'>
					<span class='goodsTotal' data-basic='<?=($li['salePrice'] + $li['addPrice'])?>'><?=number_format($li['totalGoodsPrice'])?></span>원
				</td>
				<?php if (!isset($isOrder)) : ?>
				<td align='center'>
					<a class='btn2 delete' href='<?=siteUrl("order/indb?mode=delete&cartNo[]={$li['cartNo']}")?>' target='ifrmHidden' onclick="return confirm('정말 삭제하시겠습니까?');">상품삭제</a><br>
					<span class='btn2 order'>바로구매</span>
				</td>
				<?php endif; ?>
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