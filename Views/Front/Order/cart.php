<div class='cart_order'>
	<div class='main_title'>장바구니</div>
	<?php if ($list) : ?>
	<form id='frmCart' name='frmCart' method='post' action='<?=siteUrl("order/indb")?>' target='ifrmHidden' aucomplete='off'>
		<input type='hidden' name='mode' value='order'>
		<?php
			include "_cart_item.php";
		?>
		
		<div class='cart_btns'>
			<span class='btn1 empty_cart'>장바구니 비우기</span>
			<span class='btn1 selected_delete'>선택상품 삭제</span>
			<span class='btn1 selected_order'>선택상품 주문</span>
			<span class='btn1 order_all'>전체 상품 주문하기</span>
		</div>
	</form>
	<?php else : // 담긴 상품이 없는 경우 ?>
	<div class='no_goods'>
		담겨있는 상품이 없습니다.
	</div>
	<?php endif; ?>
</div>
<!--// cart_page -->