<div class='title1'>상품 목록</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("goods/indb")?>' target='ifrmHidden' autocomplete='off'>
		<table class='table_rows'>
			<thead>
				<tr>
					<th width='20'>
						<input type='checkbox' class='selectAll' data-target-name='goodsNo'>
					</th>
					<th width='80'>상품번호</th>
					<th colspan='2'>상품</th>
					<th width='100'>판매가</th>
					<th width='100'>소비자가</th>
					<th>관리</th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($list as $li) : ?>
				<tr>
					<td align='center'>
						<input type='checkbox' name='goodsNo[]' value='<?=$li['goodsNo']?>'>
					</td>
					<td align='center'><?=$li['goodsNo']?></td>
					<td width='50'>이미지</td>
					<td width='300'><?=$li['goodsNm']?></td>
					<td align='center'><?=number_format($li['salePrice'])?>원</td>
					<td align='center'><?=number_format($li['consumerPrice'])?>원</td>
					<td>
						<a href='<?=siteUrl("admin/goods/update")?>?goodsNo=<?=$li['goodsNo']?>' class='btn2'>상품수정</a>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	</form>
</div>
<!--// content_box -->