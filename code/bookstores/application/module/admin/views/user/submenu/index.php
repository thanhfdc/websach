<?php
	$linkGroup 	= URL::createLink('admin', 'group', 'index'); 
	$linkUser 	= URL::createLink('admin', 'user', 'index'); 
?>
<div id="submenu-box">
	<div class="m">
		<ul id="submenu">
			<li><a href="<?php echo $linkGroup;?>">Nhóm người dùng</a></li>
			<li><a href="#" class="active">Người dùng</a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>