<div class='title1'>분류설정</div>
<div class='content_box'>
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='register_category'>
		<table class='table_cols'>
			<tr>
				<th>분류코드</th>
				<td width='200'>
					<input type='text' name='cateCd'>
				</td>
				<th>분류명</th>
				<td>
					<input type='text' name='cateNm'>
				</td>
				<th>브랜드</th>
				<td>
					<input type='text' name='brandCate'>
				</td>
				<th>서브 카테고리</th>
				<td>
					<input type='text' name='subCategory'>
				</td>
			</tr>
		</table>
		<input type='submit' value='등록하기' class='btn1 mt20 mb20'>
	</form>
	
	<form method='post' action='<?=siteUrl("admin/goods/indb")?>' target='ifrmHidden' autocomplete='off'>
	<table class='table_rows'>
		<thead>
			<tr>
				<th width='20'>
					<input type='checkbox' class='selectAll' data-target-name='cateCd'>
				</th>
				<th width='150'>분류코드</th>
				<th width='200'>분류명</th>
				<th width='100'>진열여부</th>
				<th width='100'>진열순서</th>
				<th width='300'>브랜드</th>
				<th width='300'>서브카테고리</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($list as $li) : ?>
			<tr>
				<td align='center'>
					<input type='checkbox' name='cateCd[]' value='<?=$li['cateCd']?>'>
				</td>
				<td align='center'><?=$li['cateCd']?></td>
				<td>
					<input type='text' name='cateNm[<?=$li['cateCd']?>]' value='<?=$li['cateNm']?>'>
				</td>
				<td>
					<select name='isDisplay[<?=$li['cateCd']?>]'>
						<option value='1'<?=$li['isDisplay']?" selected":""?>>진열</option>
						<option value='0'<?=$li['isDisplay']?"":" selected"?>>미진열</option>
					</select>
				</td>
				<td>
					<input type='text' name='listOrder[<?=$li['cateCd']?>]' value='<?=$li['listOrder']?>'>
				</td>
				<td>
					<input type='text' name='brandCate[<?=$li['cateCd']?>]' value='<?=$li['brandCate']?>'>
				</td>
				<td>
					<input type='text' name='subCategory[<?=$li['cateCd']?>]' value='<?=$li['subCategory']?>'>
				</td>
				<td>
					<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$li['cateCd']?>' target='_blank' class='btn2'>상품 목록 미리보기</a>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<div class='action_box'>
		<select name='mode'>
			<option value='update_category'>수정</option>
			<option value='delete_category'>삭제</option>
		</select>
		<input type='submit' value='처리하기' class='btn1' onclick="return confirm('정말 처리하시겠습니까?');">
	</div>
	</form>
</div>
<!--// content_box -->