<ul class='sub_menu'>
	<li>
		<a href='<?=siteUrl("admin/board/list")?>'<?php if ($menu == 'list') echo " class='on'";?>>게시판목록</a>
		<a href='<?=siteUrl("admin/board/register")?>'<?php if ($menu == 'register') echo " class='on'";?>>게시판생성</a>
	</li>
</ul>