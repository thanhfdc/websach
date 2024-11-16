<?php
	include_once (MODULE_PATH . 'admin/views/toolbar.php');

	// Input
	$dataForm 		= $this->arrParam['form'];

	$inputToken		= Helper::cmsInput('hidden', 'form[token]', 'token', time());
	$inputId		= Helper::cmsInput('hidden', 'form[id]', 'id', $dataForm['id']);
	$slbStatus		= Helper::cmsSelectbox('form[status]', null, array('default' => '- Chọn trạng thái -',2 => 'Đã giao dịch xong', 1 => 'Đã duyệt', 0 => 'Chờ duyệt'), $dataForm['status'], 'width: 150px');

	$inputID		= '';
	$rowID			= '';
	if(isset($this->arrParam['id']) || $dataForm['id']){
		$inputID		= Helper::cmsInput('text', 'form[id]', 'id', $dataForm['id'], 'inputbox readonly');
		$rowID			= Helper::cmsRowForm('ID', $inputID);

	}
	// Row
	$rowStatus		= Helper::cmsRowForm('Trạng thái', $slbStatus);

	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);

	//get
	$cartId			= $dataForm['id'];
	$date			= date("H:i d/m/Y", strtotime($dataForm['date']));
	$arrBookID		= json_decode($dataForm['books']);
	$arrPrice		= json_decode($dataForm['prices']);
	$arrName		= unserialize($dataForm['names']);
	$arrQuantity	= json_decode($dataForm['quantities']);
	$arrPicture		= json_decode($dataForm['pictures']);
	$tableContent	= '';
	$totalPrice		= 0;

	// print_r($arrBookID);

	$tableHeader = '<tr class="cart_title"><th width="100px">Ảnh</th><th>Tên sách</th><th  width="100px">Giá</th><th  width="100px">Số lượng</th><th  width="100px">Tổng tiền</th></tr>';
	foreach ($arrBookID as $keyB => $valueB){
		$linkDetail		= URL::createLink('default', 'book', 'detail', array('book_id' => $valueB));
		$picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $arrPicture[$keyB];
		if(file_exists($picturePath)==true){
			$picture	= '<img  width="30" height="45" src="'.UPLOAD_URL . 'book' . DS . '98x150-' . $arrPicture[$keyB].'">';
		}else{
			$picture	= '<img width="30" height="45" src="'.UPLOAD_URL . 'book' . DS . '98x150-default.jpg' .'">';
		}
		$totalPrice		+= $arrQuantity[$keyB] * $arrPrice[$keyB];
		$tableContent .= '<tr>
						<td class="center"><a href="'.$linkDetail.'">'.$picture.'</a></td>
						<td class="name">'.$arrName[$keyB].'</td>
						<td>'.number_format($arrPrice[$keyB]).'</td>
						<td>'.$arrQuantity[$keyB].'</td>
						<td>'.number_format($arrQuantity[$keyB] * $arrPrice[$keyB]).'</td>
					</tr>';
	}



	$xhtml .= '<div class="history-cart">
					<h3>Mã đơn hàng:'.$cartId.' - Thời gian: '.$date.'</h3>
					<table class="cart_table">
						<tbody>
							'.$tableHeader.$tableContent.'
							<tr>
								<td colspan="4" class="cart_total"><span class="red">Tổng:</span></td>
								<td>'.number_format($totalPrice).'</td>
							</tr>
						</tbody>
					</table>
				</div>';
?>
<div id="system-message-container"><?php echo $strMessage . $this->errors;?></div>
<div id="element-box">
	<div class="m">
		<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate">
			<!-- FORM LEFT -->
			<div class="width-100 fltlft">
				<fieldset class="adminform">
					<legend>Chi tiết</legend>

					<div class="clr"></div>
					<!--  -->
					<?php echo $xhtml; ?>
					<!--  -->
					<ul class="adminformlist">
						<?php echo $rowStatus;?>
					</ul>
					<div>
						<?php echo $inputToken . $inputId;?>
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

