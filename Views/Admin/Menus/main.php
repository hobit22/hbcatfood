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
</ul>
</nav>