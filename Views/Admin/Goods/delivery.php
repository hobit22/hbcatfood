<div class='title1'>배송설정</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='register_delivery'>
		<table class='table_cols'>
			<tr>
				<th>설정이름</th>
				<td>
					<input type='text' name='deliveryName'>
				</td>
				<th>배송비</th>
				<td>
					<input type='text' name='deliveryPrice'>
				</td>
				<th>합배송여부</th>
				<td>
					<select name='isTogether'>
						<option value='1'>같은 설정간 합배송</option>
						<option value='0'>개별배송비 부과</option>
					</select>
				</td>
			</tr>
		</table>
		<input type='submit' value='설정 등록하기' class='btn1 mt20'>
	</form>
	
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
		<table class='table_rows'>
			<thead>
				<tr>
					<th width='20'>
						<input type='checkbox' class='selectAll' data-target-name='deliveryNo'>
					</th>
					<th>설정이름</th>
					<th>배송비</th>
					<th>합배송여부</th>
					<th>기본배송설정</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $li) : ?>
				<tr>
					<td align='center'>
						<input type='checkbox' name='deliveryNo[]' value='<?=$li['deliveryNo']?>'>
					</td>
					<td>
						<input type='text' name='deliveryName[<?=$li['deliveryNo']?>]' value='<?=$li['deliveryName']?>'>
					</td>
					<td>
						<input type='text' name='deliveryPrice[<?=$li['deliveryNo']?>]' value='<?=$li['deliveryPrice']?>'>
					</td>
					<td>
						<select name='isTogether[<?=$li['deliveryNo']?>]'>
							<option value='1'<?=$li['isTogether']?" selected":""?>>같은 설정간 합배송</option>
							<option value='0'<?=$li['isTogether']?"":" selected"?>>개별배송비 부과</option>
						</select>
					</td>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</form>
</div>
<!--// content_box -->