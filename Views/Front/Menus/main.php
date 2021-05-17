<!-- 프론트 상단 메뉴 -->
<div class='main_top'>
	<?php if (isLogin()) : // 회원 ?>
		<?=$_SESSION['member']['memNm']?>(<?=$_SESSION['member']['memId']?>)님 로그인... 
		<a href='<?=siteUrl("member/update")?>'>회원정보수정</a>
		<a href='<?=siteUrl("member/logout")?>'>로그아웃</a>
	<?php else : // 비회원 ?>
		<a href='<?=siteUrl("member/login")?>'>로그인</a>
		<a href='<?=siteUrl("member/join")?>'>회원가입</a>
	<?php endif; ?>
	<a href='<?=siteUrl("order/cart")?>'>장바구니</a>
</div>
<!-- 프론트 로고 영역 -->
<div class='main_logo'>
	<a href='<?=siteUrl("main/index")?>'>
		<img src='<?=siteUrl("assets/front/images/logo.png")?>'>
	</a>
</div>
<!-- 프론트 메인 메뉴 -->
<?php if ($categories) : ?>
<ul class='main_menu'>
<?php foreach ($categories as $c) : 
			if (!$c['isDisplay']) continue; // 미노출 상품 분류는 건너 뛴다
?>
	<li class='menu'>
		<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$c['cateCd']?>'><?=$c['cateNm']?></a>
	</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>