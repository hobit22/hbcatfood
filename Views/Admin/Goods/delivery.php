<div class='title1'>배송설정</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("goods/indb")?>' target='ifrmHidden' autocomplete='off'>
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
	</form>
</div>
<!--// content_box -->