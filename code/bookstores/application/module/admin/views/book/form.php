<?php
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	include_once 'submenu/index.php';

	// Input
	$dataForm 			= $this->arrParam['form'];
	$inputName			= Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'], 'inputbox required', 40);
	$inputDescription	= '<textarea name="form[description]" id="editor1">'.$dataForm['description'].'</textarea>';
	$inputPrice			= Helper::cmsInput('text', 'form[price]', 'price', $dataForm['price'], 'inputbox required', 40);
	$inputSaleOff		= Helper::cmsInput('text', 'form[sale_off]', 'sale_off', $dataForm['sale_off'], 'inputbox', 40);
	$inputOrdering		= Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'inputbox', 40);
	$inputQuantity		= Helper::cmsInput('number', 'form[quantity]', 'quantity', $dataForm['quantity'], 'inputbox required', 5);
	$inputToken			= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$slbStatus			= Helper::cmsSelectbox('form[status]', null, array('default' => '- Chọn trạng thái -', 1 => 'Hiển thị', 0 => 'Ẩn'), $dataForm['status'], 'width: 180px');
	$slbSpecial			= Helper::cmsSelectbox('form[special]', null, array('default' => '- Chọn nổi bật -', 1 => 'Có', 0 => 'Không'), $dataForm['special'], 'width: 180px');
	$slbCategory		= Helper::cmsSelectbox('form[category_id]', 'inputbox', $this->slbCategory, $dataForm['category_id'], 'width: 180px');
	$inputPicture		= Helper::cmsInput('file', 'picture', 'picture', $dataForm['picture'], 'inputbox', 40);

	$inputID		= '';
	$rowID			= '';
	$picture		= '';
	if(isset($this->arrParam['id']) || $dataForm['id']){
		$inputID		= Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'inputbox readonly');
		$inputUserName	= Helper::cmsInput('text', 'form[username]', 'username', $dataForm['username'], 'inputbox readonly', 40);
		$rowID			= Helper::cmsRowForm('ID', $inputID);
		$picture		= '<img src="'.UPLOAD_URL . 'book' . DS . '98x150-' . $dataForm['picture'].'">';
		$inputPictureHidden	= Helper::cmsInput('hidden', 'form[picture_hidden]', 'picture_hidden', $dataForm['picture'], 'inputbox', 40);
	}

	// Row
	$rowName		= Helper::cmsRowForm('Tên', $inputName, true);
	$rowPicture		= Helper::cmsRowForm('Hình ảnh', $inputPicture . $picture . $inputPictureHidden);
	$rowDescription	= Helper::cmsRowForm('Chi tiết', $inputDescription);
	$rowPrice		= Helper::cmsRowForm('Giá', $inputPrice, true);
	$rowSaleOff		= Helper::cmsRowForm('Khuyến mãi', $inputSaleOff, true);
	$rowOrdering	= Helper::cmsRowForm('Sắp xếp', $inputOrdering, true);
	$rowStatus		= Helper::cmsRowForm('Trạng thái', $slbStatus);
	$rowSpecial		= Helper::cmsRowForm('Nổi bật', $slbSpecial);
	$rowCategory	= Helper::cmsRowForm('Thể loại', $slbCategory);
	$rowQuantity	= Helper::cmsRowForm('Số lượng', $inputQuantity, true);

	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
?>
<div id="system-message-container"><?php echo $strMessage . $this->errors;?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Chi tiết</legend>
					<ul class="adminformlist">
						<?php echo $rowName . $rowPicture . $rowPrice . $rowQuantity . $rowSaleOff . $rowStatus . $rowSpecial .$rowCategory . $rowOrdering . $rowDescription . $rowID;?>
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


<script>
    CKEDITOR.replace( 'editor1' );
</script>