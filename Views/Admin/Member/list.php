<!-- 회원 목록 -->
<div class='content_box'>

<table class='table_rows'>
	<thead>
		<tr>
			<th>
				<input type='checkbox' class='selectAll' data-target-name='memNo'>
			</th>
			<th>아이디</th>
			<th>회원등급</th>
			<th>회원명</th>
			<th>이메일</th>
			<th>휴대전화번호</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($list as $li) : ?>
	<tr>
		<td>
			<input type='checkbox' name='memNo[]' value='<?=$li['memNo']?>'>
		</td>
		<td><?=$li['memId']?></td>
		<td>
			<select name='level[<?=$li['memNo']?>]'>
			<?php for ($i = 0; $i <= 10; $i++) : ?>
				<option value='<?=$i?>'<?php if ($i == $li['level']) echo " selected";?>><?=$i?></option>
			<?php endfor; ?>
			</select>
		</td>
		<td><?=$li['memNm']?></td>
		<td><?=$li['email']?></td>
		<td><?=$li['cellPhone']?></td>
		<td></td>
	</tr>
<?php endforeach; ?>	
	</tbody>
</table>

<?=$pagination?>
</div>
<!--// content_box -->