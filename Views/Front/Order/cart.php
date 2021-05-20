<div class='cart_page'>
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
					<img src='<?=$li['goodsImage']?>' width='80'>
					<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	</form>
</div>
<!--// cart_page -->