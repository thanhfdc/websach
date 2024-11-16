<?php
	$imageURL	= $this->_dirImg;
	$arrMenu	= array(
						array('link' => URL::createLink('admin', 'user', 'orderList')			, 'name' => 'Quản lí đơn hàng'		, 'image' => 'icon-48-article-add'),
						array('link' => URL::createLink('admin', 'book', 'index')		, 'name' => 'Quản lí sách'		, 'image' => 'icon-48-article'),
						array('link' => URL::createLink('admin', 'category', 'index')		, 'name' => 'Quản lí thể loại'		, 'image' => 'icon-48-category'),
						array('link' => URL::createLink('admin', 'user', 'orderListReports')		, 'name' => 'Quản lí thống kê'		, 'image' => 'icon-48-contacts'),
						array('link' => URL::createLink('admin', 'user', 'index')		, 'name' => 'Quản lí người dùng'		, 'image' => 'icon-48-user'),
					);
	foreach($arrMenu as $key => $value){
		$image	= $imageURL .'/header/'.$value['image'].'.png';
		$xhtml .= '<div class="icon-wrapper">
								<div class="icon">
									<a href="'.$value['link'].'">
										<img src="'.$image.'" alt="'.$value['name'].'">
										<span>'.$value['name'].'</span>
									</a>
								</div>
							</div>';
	}
?>
<div id="element-box">
	<div class="m">
		<div class="adminform">
			<div class="cpanel-left">
				<div class="cpanel">
					<?php echo $xhtml;?>
				</div>
			</div>
		</div>
		<div class="clr"></div>
	</div>
</div>