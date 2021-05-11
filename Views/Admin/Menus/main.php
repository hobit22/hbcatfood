<nav>
<ul class='main_menu'>
	<li>
		<a href='<?=siteUrl("admin/basic")?>'<?php if ($menu == 'basic') echo " class='on'";?>>
			<i class='xi-cog'></i>
			기본설정
		</a>
	</li>
	<li>
		<a href='<?=siteUrl("admin/member")?>'<?php if ($menu == 'member') echo " class='on'";?>>
			<i class='xi-user'></i>
			회원관리
		</a>
	</li>
	<li>
		<a href='<?=siteUrl("admin/board")?>'<?php if ($menu == 'board') echo " class='on'";?>>
			<i class='xi-pen'></i>
			게시판관리
		</a>
	</li>
	<li>
		<a href='<?=siteUrl("admin/goods")?>'<?php if ($menu == 'goods') echo " class='on'";?>>
			<i class='xi-box'></i>
			상품관리
		</a>
	</li>
	<li>
		<a href='<?=siteUrl("admin/order")?>'<?php if ($menu == 'order') echo " class='on'"?>>
			<i class='xi-list'></i>
			주문관리 
		</a>
	</li>
	<?php if (isLogin()) : ?>
	<li>
		<a href='<?=siteUrl("admin/member/logout")?>'>로그아웃</a>
	</li>
	<?php endif; ?>
</ul>
</nav>