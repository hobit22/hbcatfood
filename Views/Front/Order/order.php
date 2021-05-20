<div class='cart_order order_page'>
	<div class='main_title'>주문하기</div>
	<form name='frmOrder' method='post' action='<?=siteUrl("order/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='order_process'>
		<input type='hidden' name='isDirect' value='<?=$isDirect?>'>
		<?php
			include "_cart_item.php";
		?>
		
		<div class='sub_title'>주문자 정보</div>
		<table class='table_cols'>
			<tr>
				<th>주문자명</th>
				<td>
					<input type='text' name='nameOrder' value='<?=isLogin()?$_SESSION['member']['memNm']:""?>'>
				</td>
			</tr>
			<tr>
				<th>휴대전화</th>
				<td>
					<input type='text' name='cellPhoneOrder' value='<?=isLogin()?$_SESSION['member']['cellPhone']:""?>'>
				</td>
			</tr>
			<tr>
				<th>이메일</th>
				<td>
					<input type='email' name='emailOrder' value='<?=isLogin()?$_SESSION['member']['email']:""?>'>
				</td>
			</tr>
		</table>
		
		<div class='sub_title'>배송지 정보</div>
		<div class='rows'>
			<input type='checkbox' id='same_with_order_info'>
			<label for='same_with_order_info'>주문자 정보와 동일</label>
		</div>
		<table class='table_cols'>
			<tr>
				<th>받는분 이름</th>
				<td>
					<input type='text' name='receiverName'>
				</td>
			</tr>
			<tr>
				<th>휴대전화</th>
				<td>
					<input type='text' name='receiverCellphone'>
				</td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<div class='rows'>
						<input type='text' name='zipcode' id='zipcode' readonly>
						<span class='btn2 search_receiver_address'>주소 검색</span>
					</div>
					<div class='rows'>
						<input type='text' name='receiverAddress' readonly>
					</div>
					<div class='rows'>
						<input type='text' name='receiverAddressSub' placeholder='나머지 주소'>
					</div>
				</td>
			</tr>
		</table>
		
		
		<div class='sub_title'>결제 정보</div>
	</form>
</div>
<!--// order_page -->