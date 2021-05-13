<!-- 상품 옵션 -->
<div class='opt_names'>
	<div>
		옵션명 등록
		<i class='xi-plus-square-o add'></i>
		<i class='xi-minus-square-o remove'></i>
	</div>
	
	<div class='inner'></div>
	<span class='btn1 mt20 create_opt_items dn'>옵션 항목생성하기</span>
</div>
<!--// opt_names -->

<div class='opt_items'>
	
</div>


<script type='text/html' id='opt_name_template'>
	<span class='opt_name'>
		<input type='text' name='optNames[]' value='' class='w120'>
	</span>
</script> 

<script type='text/html' id='opt_item_template'>
	<div class='opt_item'>
		<div class='opt_name_tit'>[[optName]]</div>
		<div class='btns'>
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