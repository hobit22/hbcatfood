<ul class='sub_menu'>
	<li>
		<a href='<?=siteUrl("admin/goods/list")?>'<?php if ($menu == 'list') echo " class='on';"?>>상품목록</a>
	</li>
	<li>
		<a href='<?=siteUrl("admin/goods/register")?>'<?php if ($menu == 'register') echo " class='on';"?>>상품등록</a>
	</li>
</ul>