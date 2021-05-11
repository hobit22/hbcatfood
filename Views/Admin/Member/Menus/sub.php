<ul class='sub_menu'>
	<li><a href='<?=siteUrl("admin/member/list")?>'<?php if ($menu == 'list') echo " class='on'";?>>회원목록</a></li>
	<li><a href='<?=siteUrl("admin/member/register")?>'<?php if ($menu == 'register') echo " class='on'";?>>회원등록</a></li>
	<li><a href='<?=siteUrl("admin/member/config")?>'<?php if ($menu == 'config') echo " class='on'"?>>회원설정</a>
</ul>