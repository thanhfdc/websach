<?php
	$arrMenu	= array(
							array('Thông tin cá nhân'	, 'changepass.png'	, URL::createLink('default', 'user', 'index',null,'user-info.html')),
							array('Giỏ hàng'	, 'cart.png'		, URL::createLink('default', 'user', 'cart', null, 'cart.html')),
							array('Lịch sử mua hàng'		, 'history.png'		, URL::createLink('default', 'user', 'history', null, 'history.html')),
							array('Đăng xuất'		, 'logout.png'		, URL::createLink('default', 'index', 'logout')),
					);

	$xhtml = '';
	foreach ($arrMenu as $value){
		$xhtml .= '<div class="new_prod_box">
					<a href="'.$value[2].'">'.$value[0].'</a>
					<div class="new_prod_bg">
						<a href="'.$value[2].'"><img class="thumb" src="'.$imageURL . DS . $value[1].'"></a>
					</div>
				</div>';
	}
?>

<div class="new_products">
	<?php echo $xhtml;?>
</div>