<div class='title1'>상품 목록</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
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
					<th width='100'>재고</th>
					<th width='100'>품절</th>
					<th width='100'>진열</th>
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
						<input type='text' name='totalStock[<?=$li['goodsNo']?>]' value='<?=$li['totalStock']?>'>
					</td>
					<td>
						<select name='stockOut[<?=$li['goodsNo']?>]'>
							<option value='0'<?=$li['stockOut']?"":" selected"?>>판매중</option>
							<option value='1'<?=$li['stockOut']?" selected":""?>>품절</option>
						</select>
					</td>
					<td>
						<select name='isDisplay[<?=$li['goodsNo']?>]'>
							<option value='0'<?=$li['isDisplay']?"":" selected"?>>미진열</option>
							<option value='1'<?=$li['isDisplay']?" selected":""?>>진열</option>
						</select>
					</td>
					<td>
						<a href='<?=siteUrl("admin/goods/update")?>?goodsNo=<?=$li['goodsNo']?>' class='btn2'>상품수정</a>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
		<div class='action_box'>
			<select name='mode'>
				<option value='update_list'>수정</option>
				<option value='delete_list'>삭제</option>
				<input type='submit' value='처리하기' class='btn1' onclick="return confirm('정말 처리 하시겠습니까?');">
			</select>
		</div>
		<!--// action_box -->
	</form>
</div>
<!--// content_box -->