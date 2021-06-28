<!-- 프론트 상단 메뉴 -->
<div class='gnb'>
<div class='inner'>
<!-- 프론트 로고 영역 -->
<div class='main_logo box1'>
	<a href='<?=siteUrl("main/index")?>'>
		<img src='<?=siteUrl("assets/front/images/top_logo.gif")?>'>
	</a>
</div>
<div class='main_top box1'>
	<?php if (isLogin()) : // 회원 ?>
		<?=$_SESSION['member']['memNm']?>(<?=$_SESSION['member']['memId']?>)님 로그인... 
		<a href='<?=siteUrl("member/update")?>'>MY PAGE</a>
		<a href='<?=siteUrl("member/logout")?>'>LOGOUT</a>
	<?php else : // 비회원 ?>
		<a href='<?=siteUrl("member/login")?>'>LOGIN</a>
		<a href='<?=siteUrl("member/join")?>'>JOIN</a>
	<?php endif; ?>
	<a href='<?=siteUrl("order/cart")?>'>CART</a>
</div>
</div><!--inner-->
</div><!--gnb-->
<!-- 프론트 메인 메뉴 -->
<ul class='main_menu'>
<div class='inner'>
<?php if ($categories) : ?>
<?php foreach ($categories as $c) : 
			if (!$c['isDisplay']) continue; // 미노출 상품 분류는 건너 뛴다
?>
	<li class='menu'>
		<a href='<?=siteUrl("goods/list")?>?cateCd=<?=$c['cateCd']?>'><?=$c['cateNm']?></a>
	</li>
<?php endforeach; ?>
<?php endif; ?>
<?php if ($board) : ?>
<?php foreach ($board as $b) : ?>
	<li class='menu'>
		<a href='<?=siteUrl("board/list")?>?id=<?=$b['id']?>'><?=$b['id']?></a>
	</li>
<?php endforeach; ?>
<?php endif; ?>
<form name='frmSearch' class='search_box' action='<?=siteUrl("goods/list")?>' method='get' target='_self'>
<li>
<input type='text' name='goodsNm' value='<?php if (isset($_GET['goodsNm'])) echo $_GET['goodsNm'];?>'>
<i class='xi-search' onclick='frmSearch.submit();'></i>
</li>
</form>

</div>
</ul>