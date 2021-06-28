<div class='order_end inner'>
	<div class='guide'>
		<div class='t1'>주문이 완료 되었습니다.</div>
		<div class='t2'>주문번호 : <?=$orderNo?></div>
	</div>
	<div class='btns'>
		<a href='<?=siteUrl("main/index")?>'>쇼핑 계속하기</a>
		<a href='<?=siteUrl("mypage/orderview")?>?orderNo=<?=$orderNo?>'>주문내역확인</a>
	</div>
</div>