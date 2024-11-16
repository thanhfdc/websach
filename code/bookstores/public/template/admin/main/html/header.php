<?php
	$linkControlPanel	= URL::createLink('admin', 'index', 'index');
	$linkMyProfile		= URL::createLink('admin', 'index', 'profile');
	$linkUserManager	= URL::createLink('admin', 'user', 'index');
	$linkAddUser		= URL::createLink('admin', 'user', 'form');
	$linkGroupManager	= URL::createLink('admin', 'group', 'index');
	$linkAddGroup		= URL::createLink('admin', 'group', 'form');
	$linkCategoryManager= URL::createLink('admin', 'category', 'index');
	$linkAddCategory	= URL::createLink('admin', 'category', 'form');
	$linkBookManager	= URL::createLink('admin', 'book', 'index');
	$linkAddBook		= URL::createLink('admin', 'book', 'form');
	$linkLogout			= URL::createLink('admin', 'index', 'logout');
	$linkViewSite		= URL::createLink('default', 'index', 'index');
	$linkOrderManager	= URL::createLink('admin', 'user', 'orderList');
	$linkOrderManagerReport	= URL::createLink('admin', 'user', 'orderListReports');

?>
	<div id="border-top" class="h_blue">
		<span class="title"><a href="<?php echo $linkControlPanel;?>">Quản trị</a></span>
	</div>

    <!-- HEADER -->
	<div id="header-box">
		<div id="module-status">
			<span class="viewsite"><a href="<?php echo $linkViewSite;?>" target="_blank">Trang chủ</a></span>
            <span class="no-unread-messages"><a href="<?php echo $linkLogout;?>">Đăng xuất</a></span>
		</div>
        <div id="module-menu">
        	<!-- MENU -->
            <ul id="menu" >
                <li class="node"><a href="#">Site</a>
                    <ul>
                        <li><a class="icon-16-cpanel" href="<?php echo $linkControlPanel;?>">Control Panel</a></li>
                        <li class="separator"><span></span></li>
                        <li><a class="icon-16-profile" href="<?php echo $linkMyProfile;?>">Hồ sơ của tôi</a></li>
                    </ul>
                </li>
                <li class="separator"><span></span></li>

                <li class="node"><a href="#">Tài khoản</a>
					<ul>
						<li class="node">
							<a class="icon-16-user" href="<?php echo $linkUserManager;?>">Quản lí người dùng</a>
							<ul id="menu-com-users-users" class="menu-component">
								<li><a class="icon-16-newarticle" href="<?php echo $linkAddUser;?>">Thêm người dùng</a></li>
							</ul>
						</li>
						<li class="node">
							<a class="icon-16-groups" href="<?php echo $linkGroupManager;?>">Quản lí nhóm người dùng</a>
							<ul id="menu-com-users-groups" class="menu-component">
								<li><a class="icon-16-newarticle" href="<?php echo $linkAddGroup;?>">Thêm nhóm người dùng</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<li class="node"><a href="#">Sách</a>
					<ul>
						<li class="node">
							<a class="icon-16-category" href="<?php echo $linkCategoryManager;?>">Quản lí thể loại</a>
							<ul id="menu-com-users-users" class="menu-component">
								<li><a class="icon-16-newarticle" href="<?php echo $linkAddCategory;?>">Thêm thể loại</a></li>
							</ul>
						</li>
						<li class="node">
							<a class="icon-16-article" href="<?php echo $linkBookManager;?>">Quản lí sách</a>
							<ul id="menu-com-users-groups" class="menu-component">
								<li><a class="icon-16-newarticle" href="<?php echo $linkAddBook;?>">Thêm sách</a></li>
							</ul>
						</li>
					</ul>
				</li>

				<li class="node"><a href="#">Đơn hàng</a>
					<ul>
						<li class="">
							<a class="icon-16-category" href="<?php echo $linkOrderManager;?>">Danh sách đơn hàng</a>
						</li>
						<li class="">
							<a class="icon-16-category" href="<?php echo $linkOrderManagerReport;?>">Thống kê đơn hàng</a>
						</li>
					</ul>
				</li>

            </ul>
        </div>

		<div class="clr"></div>
	</div>