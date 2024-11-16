<?php 
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	include_once 'submenu/index.php';
	
	// Input
	$dataForm 		= $this->arrParam['form'];
	$inputName		= Helper::cmsInput('text', 'form[name]', 'name', $dataForm['name'], 'inputbox required', 40);
	$inputOrdering	= Helper::cmsInput('text', 'form[ordering]', 'ordering', $dataForm['ordering'], 'inputbox', 40);
	$inputToken		= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$selectStatus	= Helper::cmsSelectbox('form[status]', null, array('default' => '- Chọn trạng thái -', 1 => 'Hiển thị', 0 => 'Ẩn'), $dataForm['status'], 'width: 150px');
	$selectGroupACP	= Helper::cmsSelectbox('form[group_acp]', null, array('default' => '- Chọn quyền truy cập -', 1 => 'Có', 0 => 'Không'), $dataForm['group_acp'], 'width: 150px');
	
	$inputID		= '';
	$rowID			= '';
	if(isset($this->arrParam['id'])){
		$inputID	= Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'inputbox readonly');
		$rowID		= Helper::cmsRowForm('ID', $inputID);
		
	}
	// Row
	$rowName		= Helper::cmsRowForm('Tên', $inputName, true);
	$rowOrdering	= Helper::cmsRowForm('Sắp xếp', $inputOrdering);
	$rowStatus		= Helper::cmsRowForm('Trạng thái', $selectStatus);
	$rowGroupACP	= Helper::cmsRowForm('Quyền truy cập', $selectGroupACP);
	
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
						<?php echo $rowName . $rowStatus . $rowGroupACP . $rowOrdering . $rowID;?>
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
        
     