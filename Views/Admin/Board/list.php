<div class='title1'>게시판 목록</div>
<div class='content_box'>
	<form method='post' action='indb' target='ifrmHidden' autocomplete='off'>
		<table class='table_rows'>
			<thead>
				<tr>
					<th width='20'>
						<input type='checkbox' class='selectAll' data-target-name='id'>
					</th>
					<th width='100'>게시판아이디</th>
					<th width='180'>게시판명</th>
					<th width='90'>댓글사용</th>
					<th width='150'>게시판스킨</th>
					<th width='120'>등록일시</th>
					<th>관리</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($list as $li) : ?>
				<tr>
					<td align='center'>
						<input type='checkbox' name='id[]' value='<?=$li['id']?>'>
					</td>
					<td><?=$li['id']?></td>
					<td>
						<input type='text' name='boardNm[<?=$li['id']?>]' value='<?=$li['boardNm']?>'>
					</td>
					<td>
						<select name='useReply[<?=$li['id']?>]'>
							<option value='1'<?=$li['useReply']?" selected":""?>>사용</option>
							<option value='0'<?=$li['useReply']?"":" selected"?>>미사용</option>
						</select>
					</td>
					<td>
						<select name='boardSkin[<?=$li['id']?>]'>
						<?php foreach ($skins as $skin) : ?>
							<option value='<?=$skin?>'<?php if ($skin == $li['boardSkin']) echo " selected";?>><?=$skin?></option>
						<?php endforeach; ?>
						</select>
					</td>
					<td align='center'><?=$li['regDt']?></td>
					<td></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<div class='action_box'>
			<select name='mode'>
				<option value='board_update_list'>수정</option>
				<option value='board_delete_list'>삭제</option>
			</select>
			<input type='submit' value='처리하기' class='btn1' onclick="return confirm('정말 처리하시겠습니까?');">
		</div>
		<!--// action_box -->
	</form>
</div>
<!--// content_box -->