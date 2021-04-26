<!-- 회원 목록 -->
<div class='content_box'>

<form method='post' action='indb' target='ifrmHidden' autocomplete='off'>
<table class='table_rows'>
	<thead>
		<tr>
			<th width='20'>
				<input type='checkbox' class='selectAll' data-target-name='memNo'>
			</th>
			<th width='120'>아이디</th>
			<th width='80'>회원등급</th>
			<th width='120'>회원명</th>
			<th width='250'>이메일</th>
			<th width='120'>휴대전화번호</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($list as $li) : ?>
	<tr>
		<td align='center'>
			<input type='checkbox' name='memNo[]' value='<?=$li['memNo']?>'>
		</td>
		<td align='center'><?=$li['memId']?></td>
		<td>
			<select name='level[<?=$li['memNo']?>]'>
			<?php for ($i = 0; $i <= 10; $i++) : ?>
				<option value='<?=$i?>'<?php if ($i == $li['level']) echo " selected";?>><?=$i?></option>
			<?php endfor; ?>
			</select>
		</td>
		<td align='center'><?=$li['memNm']?></td>
		<td align='center'><?=$li['email']?></td>
		<td align='center'><?=$li['cellPhone']?></td>
		<td></td>
	</tr>
<?php endforeach; ?>	
	</tbody>
</table>
<div class='action_box'>
	<select name='mode'>
		<option value='update_list'>수정</option>
		<option value='delete_list'>삭제</option>
	</select>
	<input type='submit' value='처리하기' onclick="return confirm('정말 처리하시겠습니까?');" class='btn1'>
</div>
</form>
<?=$pagination?>
</div>
<!--// content_box -->