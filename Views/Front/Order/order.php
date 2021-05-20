<div class='cart_order order_page'>
	<div class='main_title'>주문하기</div>
	<form method='post' action='<?=siteUrl("order/indb")?>' target='ifrmHidden' autocomplete='off'>
		<input type='hidden' name='mode' value='order_process'>
		<input type='hidden' name='isDirect' value='<?=$isDirect?>'>
		<?php
			include "_cart_item.php";
		?>
		
		<div class='sub_title'>주문자 정보</div>
		
		<div class='sub_title'>배송지 정보</div>
		
		
		<div class='sub_title'>결제 정보</div>
	</form>
</div>
<!--// order_page -->