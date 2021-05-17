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
			</tr>
		</table>
		<input type='submit' value='등록하기' class='btn1 mt20 mb20'>
	</form>
</div>
<!--// content_box -->