<!-- 상품 옵션 -->
<div class='opt_names'>
	<div>
		옵션명 등록
		<i class='xi-plus-square-o add'></i>
		<i class='xi-minus-square-o remove'></i>
	</div>
	
	<div class='inner'></div>
	<div class='mt20'>
		<span class='btn1 create_opt_items dn'>옵션 항목생성하기</span>
	</div>
</div>
<!--// opt_names -->

<div class='opt_items mt20'>
</div>


<script type='text/html' id='opt_name_template'>
	<span class='opt_name'>
		<input type='text' name='optNames[]' value='' class='w120'>
	</span>
</script> 

<script type='text/html' id='opt_item_template'>
	<div class='opt_item mt20'>
		<div class='opt_name_tit'>
			<%optName%>
			
			<i class='xi-plus-square-o add'></i>
			<i class='xi-minus-square-o remove'></i>
		</div>
	
		<table class='table_rows'>
			<thead>
				<tr>
					<th>옵션항목</th>
					<th>옵션가</th>
					<th>재고</th>
					<th>품절여부</th>
					<th>진열</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</script>

<script type='text/html' id='opt_item_rows_template'>
	<tr>
		<td>
			<input type='text' name='optItem[<%no%>][]' value=''>
		</td>
		<td>
			<input type='text' name='addPrice[<%no%>][]' value=''>
		</td>
		<td>
			<input type='text' name='stock[<%no%>][]' value=''>
		</td>
		<td>
			<select name='stockOut[<%no%>][]'>
				<option value='0'>판매중</option>
				<option value='1'>품절</option>
			</select>
		</td>
		<td>
			<select name='isDisplay[<%no%>][]'>
				<option value='1'>진열</option>
				<option value='0'>미진열</option>
			</select>
		</td>
	</tr>
</script>