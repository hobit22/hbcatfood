<div class='title1'>게시판 생성</div>
<div class='content_box'>
	<form method='post' action='indb' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='register_board'>
		<table class='table_cols'>
			<tr>
				<th>게시판아이디</th>
				<td>
					<input type='text' name='id'>
				</td>
			</tr>
			<tr>
				<th>게시판명</th>
				<td>
					<input type='text' name='boardNm'>
				</td>
			</tr>
			<tr>
				<th>댓글</th>
				<td>
					<input type='radio' name='useReply' value='0' id='useReplay0'>
					<label for='useReply0'>사용안함</label>
					<input type='radio' name='useReply' value='1' id='useReply1' checked>
					<label for='useReply1'>사용함</label>
				</td>
			</tr>
			<tr>
				<th>스킨</th>
				<td></td>
			</tr>
		</table>
		<input type='submit' value='게시판 생성하기' class='btn1 mt20' onclick="return confirm('정말 생성하시겠습니까?');">
	</form>
</div>