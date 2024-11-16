<?php
	$imageURL		= $this->_dirImg;
	
	// Create Link
	$linkHome		= URL::createLink('default', 'user', 'index', null, 'index.html');
	$linkCat		= URL::createLink('default', 'category', 'index', null, 'category.html');
	$linkMyAccount	= URL::createLink('default', 'user', 'index', null, 'my-account.html');
	$linkRegister	= URL::createLink('default', 'index', 'register', null, 'register.html');
	$linkLogin		= URL::createLink('default', 'index', 'login', null, 'login.html');
	
	
	$userObj		= Session::get('user');
	$arrayMenu		= array();
	$arrayMenu[]	= array('class' => 'index-index'		, 'link' => $linkHome	, 'name' => 'Trang chủ');
	$arrayMenu[]	= array('class' => 'category-index'		, 'link' => $linkCat	, 'name' => 'Thể loại sách');
	
	if($userObj['login'] == true){
		$arrayMenu[] = array('class' => 'user-index user-cart user-history', 	'link' => $linkMyAccount, 	'name' => 'Tài khoản');
		$arrayMenu[] = array('class' => 'index-logout', 'link' => URL::createLink('default', 'index', 'logout'), 'name' => 'Đăng xuất');
	}else{
		$arrayMenu[] = array('class' => 'index-register', 	'link' => $linkRegister, 	'name' => 'Đăng ký');
		$arrayMenu[] = array('class' => 'index-login', 		'link' => $linkLogin, 	'name' => 'Đăng nhập');
	}
	
	if($userObj['group_acp'] == true){
		$arrayMenu[] = array('class' => '', 		'link' => URL::createLink('admin', 'index', 'index'), 	'name' => 'Quản trị');
	}
	foreach($arrayMenu as $key => $value){
		$xhtml .= '<li class="'.$value['class'].'"><a href="'.$value['link'].'">'.$value['name'].'</a></li>';
	}

	$controller = !empty($this->arrParam['controller']) ? $this->arrParam['controller'] : 'index';
	$action 	= !empty($this->arrParam['action']) ? $this->arrParam['action'] : 'index';
?>
       
<div class="header">
	<div class="logo">
		<a href="<?php echo $linkHome;?>"><img src="<?php echo $imageURL;?>/logo.gif"/></a>
	</div>
	<div id="menu">
		<ul><?php echo $xhtml;?></ul>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		var controller 	= '<?php echo $controller;?>';
		var action 		= '<?php echo $action;?>';
		var classSelect = controller + '-' + action;
		$('#menu ul li.' + classSelect).addClass('selected');
	});

</script>
