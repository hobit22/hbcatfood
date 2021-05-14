<!-- 상품 옵션 -->
<div class='opt_names'>
	<div>
		<?php if (!isset($options) || !$options['optNames']) : // 상품등록, 옵션이 없는 경우만 ?>
		옵션명 등록
		<i class='xi-plus-square-o add'></i>
		<i class='xi-minus-square-o remove'></i>
		<?php else : ?>
		옵션설정 
		<?php endif; ?>
	</div>
	
	<div class='inner'>
	<?php if (isset($options) && $options['optNames']) : ?>
	<?php foreach ($options['optNames'] as $optName) : ?>
		<input type='hidden' name='optNames[]' value='<?=$optName?>'>
		<span class='opt_name_str'><?=$optName?></span> 
	<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<div class='mt20'>
		<?php if (isset($options) && $options['optNames']) : ?>
			<span class='btn1 initialize_opt_items'>옵션 초기화 하기</span>
		<?php else : ?>
			<span class='btn1 create_opt_items dn'>옵션 항목생성하기</span>
		<?php endif; ?>
	</div>
</div>
<!--// opt_names -->

<div class='opt_items mt20'>
<?php if (isset($options) && $options['opts']) : ?>
<?php foreach ($options['opts'] as $k => $list) : ?>
	<div class='opt_item mt20'>
		<div class='opt_name_tit'>
			<?=$options['optNames'][$k]?>
			
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
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $li) : ?>
				<tr>
					<td>
						<input type='text' name='opt_optItem[<?=$k?>][]' value='<?=$li['optItem']?>'>
					</td>
					<td>
						<input type='text' name='opt_addPrice[<?=$k?>][]' value='<?=$li['addPrice']?>'>
					</td>
					<td>
						<input type='text' name='opt_stock[<?=$k?>][]' value='<?=$li['stock']?>'>
					</td>
					<td>
						<select name='opt_stockOut[<?=$k?>][]'>
							<option value='0'<?=$li['stockOut']?"":" selected"?>>판매중</option>
							<option value='1'<?=$li['stockOut']?" selected":""?>>품절</option>
						</select>
					</td>
					<td>
						<select name='opt_isDisplay[<?=$k?>][]'>
							<option value='1'<?=$li['isDisplay']?" selected":""?>>진열</option>
							<option value='0'<?=$li['isDisplay']?"":" selected"?>>미진열</option>
						</select>
					</td>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
<?php endforeach; ?>
<?php endif; ?>
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
			<input type='text' name='opt_optItem[<%no%>][]' value=''>
		</td>
		<td>
			<input type='text' name='opt_addPrice[<%no%>][]' value=''>
		</td>
		<td>
			<input type='text' name='opt_stock[<%no%>][]' value=''>
		</td>
		<td>
			<select name='opt_stockOut[<%no%>][]'>
				<option value='0'>판매중</option>
				<option value='1'>품절</option>
			</select>
		</td>
		<td>
			<select name='opt_isDisplay[<%no%>][]'>
				<option value='1'>진열</option>
				<option value='0'>미진열</option>
			</select>
		</td>
	</tr>
</script>