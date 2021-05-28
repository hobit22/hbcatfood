<div class='cart_order order_page'>
	<div class='main_title'>주문하기</div>
	<form name='frmOrder' method='post' action='<?=siteUrl("order/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='order_process'>
		<input type='hidden' name='isDirect' value='<?=$isDirect?>'>
		<input type='hidden' class='zipcode' value='<?=isLogin()?$_SESSION['member']['zipcode']:""?>'>
		<input type='hidden' class='address' value='<?=isLogin()?$_SESSION['member']['address']:""?>'>
		<input type='hidden' class='addressSub' value='<?=isLogin()?$_SESSION['member']['addressSub']:""?>'>
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
		<table class='table_cols'>
			<tr>
				<th>상품합계</th>
				<td><?=number_format($totalGoodsPrice)?>원</td>
			</tr>
			<tr>
				<th>배송비</th>
				<td>
					<?php if ($totalDeliveryPrice) : ?>
						<?=number_format($totalDeliveryPrice)?>원
					<?php else: ?>
						무료배송
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th>결제금액</th>
				<td><?=number_format($totalPayPrice)?>원</td>
			</tr>
			<tr>
				<th>결제수단</th>
				<td>
					<input type='radio' name='settleKind' value='무통장입금' id='settleKind1' class='settleKind' checked>
					<label for='settleKind1'>무통장입금</label>
					<input type='radio' name='settleKind' value='신용카드' id='settleKind2' class='settleKind'>
					<label for='settleKind2'>신용카드</label>
					<input type='radio' name='settleKind' value='가상계좌' id='settleKind3' class='settleKind'>
					<label for='settleKind3'>가상계좌</label>
				</td>
			</tr>
			<tr class='bank_transfer_pay'>
				<th>입금계좌</th>
				<td>
					<select name='bankAccount'>
						<option value='농협 1111-1111-1111 회사명'>농협 1111-1111-1111 회사명</option>
						<option value='국민 1111-1111-1111 회사명'>국민 1111-1111-1111 회사명</option>
					</select>
					<input type='text' name='bankDepositor' placeholder='입금자명' value='<?=isLogin()?$_SESSION['member']['memNm']:""?>'>
				</td>
			</tr>
		</table>
		
		<input type='submit' class='btn3' value='주문하기'>
	</form>
</div>
<!--// order_page -->