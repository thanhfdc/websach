<!-- TITLE -->
<?php echo Helper::createTitle("$imageURL/bullet1.gif", 'Thông tin cá nhân');?>

<?php
	$dataForm = $this->userInfo;
	// Input
	// $dataForm 		= $this->arrParam['form'];
	$inputUserName	= Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'form-control required readonly', 40);
	$inputEmail		= Helper::cmsInput('text', 'form[email]', 'email', $dataForm['email'], 'form-control required', 40);
	$inputFullName	= Helper::cmsInput('text', 'form[fullname]', 'fullname', $dataForm['fullname'], 'form-control', 40);
	$inputPassword	= Helper::cmsInput('password', 'form[password]', 'password', null, 'form-control required', 40);
	$inputPhone   	= Helper::cmsInput('text', 'form[phone]', 'phone', $dataForm['phone'], 'form-control required', 40);
	$inputAddress   = Helper::cmsInput('text', 'form[address]', 'address', $dataForm['address'], 'form-control required', 40);
	$inputIdHidden	= Helper::cmsInput('text', 'form[id]', 'idhidden', $dataForm['id'], 'form-control hidden', 40);
	$inputToken		= Helper::cmsInput('hidden', 'form[token]', 'token', time());


	// Row
	$rowUserName	= Helper::cmsRowForm('Tên', $inputUserName, true);
	$rowEmail		= Helper::cmsRowForm('Email', $inputEmail, true);
	$rowFullName	= Helper::cmsRowForm('Tên đầy đủ', $inputFullName);
	$rowPassword	= Helper::cmsRowForm('Mật khẩu', $inputPassword, true);
	$rowPhone     	= Helper::cmsRowForm('Điện thoại', $inputPhone, true);
	$rowAddress 	= Helper::cmsRowForm('Địa chỉ', $inputAddress, true);
	$rowIdHidden	= Helper::cmsRowForm('', $inputIdHidden, false);

	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);



?>
<div id="system-message-container"><?php echo $strMessage . $this->errors;?></div>

<div class="new_products user_info">
	<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
		<ul class="adminformlist">
			<?php echo $rowUserName . $rowEmail . $rowFullName . $rowPassword . $rowPhone . $rowAddress . $rowIdHidden ?>
		</ul>
		<div>
			<?php echo $inputToken;?>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-update">Cập nhật</button>
		</div>
	</form>
</div>
<br>
<?php //print_r($this->userInfo); ?>