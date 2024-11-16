<?php 
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	include_once 'submenu/index.php';
	
	// Input
	$dataForm 		= $this->arrParam['form'];
	$inputUserName	= Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'inputbox required', 40);
	$inputEmail		= Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'], 'inputbox required', 40);
	$inputFullName	= Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'inputbox', 40);
	$inputPhone 	= Helper::cmsInput('text', 'form[phone]', 'phone', $dataForm['phone'], 'inputbox', 40);
	$inputAddress	= Helper::cmsInput('text', 'form[address]', 'address', $dataForm['address'], 'inputbox', 40);
	$inputPassword	= Helper::cmsInput('password', 'form[password]', 'password', $dataForm['password'], 'inputbox required', 40);
	$inputOrdering	= Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'inputbox', 40);
	$inputToken		= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$slbStatus		= Helper::cmsSelectbox('form[status]', null, array('default' => '- Chọn trạng thái -', 1 => 'Hiển thị', 0 => 'Ẩn'), $dataForm['status'], 'width: 150px');
	$slbGroup		= Helper::cmsSelectbox('form[group_id]', 'inputbox', $this->slbGroup, $dataForm['group_id']);
	
	$inputID		= '';
	$rowID			= '';
	if(isset($this->arrParam['id']) || $dataForm['id']){
		$inputID		= Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'inputbox readonly');
		$inputUserName	= Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'inputbox readonly', 40);
		$rowID			= Helper::cmsRowForm('ID', $inputID);
		
	}
	// Row
	$rowUserName	= Helper::cmsRowForm('Tên', $inputUserName, true);
	$rowEmail		= Helper::cmsRowForm('Email', $inputEmail, true);
	$rowFullName	= Helper::cmsRowForm('Tên đầy đủ', $inputFullName);
	$rowPhone   	= Helper::cmsRowForm('Điện thoại', $inputPhone);
	$rowAddress 	= Helper::cmsRowForm('Địa chỉ', $inputAddress);
	$rowPassword	= Helper::cmsRowForm('Mật khẩu', $inputPassword, true);
	$rowOrdering	= Helper::cmsRowForm('Sắp xếp', $inputOrdering);
	$rowStatus		= Helper::cmsRowForm('Trạng thái', $slbStatus);
	$rowGroup		= Helper::cmsRowForm('Nhóm người dùng', $slbGroup);
	
	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
?>
<div id="system-message-container"><?php echo $strMessage . $this->errors;?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Chi tiết</legend>
					<ul class="adminformlist">
						<?php echo $rowUserName . $rowEmail . $rowFullName . $rowPhone . $rowAddress . $rowPassword . $rowStatus . $rowGroup . $rowOrdering . $rowID;?>
					</ul>
					<div class="clr"></div>
					<div>
						<?php echo $inputToken;?>
					</div>
				</fieldset>
			</div>
			<div class="clr"></div>
			<div>
			</div>
		</form>
		<div class="clr"></div>
	</div>
</div>
        
     