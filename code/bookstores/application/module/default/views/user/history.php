<?php

	$xhtml = '';
	if(!empty($this->Items)){
		$tableHeader = '<tr class="cart_title"><td>Hình ảnh</td><td>Tên sách</td><td>Giá</td><td>Số lượng</td><td>Tổng tiền</td></tr>';
		foreach($this->Items as $key => $value){

			$cartId			= $value['id'];
			$date			= date("H:i d/m/Y", strtotime($value['date']));
			$arrBookID		= json_decode($value['books']);
			$arrPrice		= json_decode($value['prices']);
			$arrName		= unserialize($value['names']);
			$arrQuantity	= json_decode($value['quantities']);
			$arrPicture		= json_decode($value['pictures']);
			$tableContent	= '';
			$totalPrice		= 0;

			$linkDestroyOrder		= URL::createLink('default', 'user', 'destroy_order', array('book_id' => $cartId));

			$status = '<span class="alert alert-success">Thành công</span>';
			if($value['status'] == 0){
				$status = '<span class="alert alert-pendding">Chưa xử lý</span><a href="'.$linkDestroyOrder.'" class="destroy_order" onclick="return confirm(\'Bạn có muốn xóa đơn hàng này không?\')">Hủy đơn hàng</a>';
			}else if($value['status'] == 1){
				$status = '<span class="alert alert-wating">Đang xử lý</span>';
			}else if($value['status'] == 2){
				$status = '<span class="alert alert-success">Đã giao hàng</span>';
			}

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
								<td><a href="'.$linkDetail.'">'.$picture.'</a></td>
								<td class="name">'.$arrName[$keyB].'</td>
								<td>'.number_format($arrPrice[$keyB]).'</td>
								<td>'.$arrQuantity[$keyB].'</td>
								<td>'.number_format($arrQuantity[$keyB] * $arrPrice[$keyB]).'</td>
							</tr>';
			}



			$xhtml .= '<div class="history-cart">
							<h3>Mã đơn hàng:'.$cartId.' - Thời gian: '.$date.'</h3>
							<h3 class="status_order">Trạng thái: '.$status.'</h3>
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
		}
	}else{
		$xhtml = '<h3>Chưa có đơn hàng nào!</h3>';
	}
?>

<!-- TITLE -->
<?php echo Helper::createTitle("$imageURL/bullet1.gif", 'Lịch sử');?>

<!-- LIST BOOKS -->
<div class="feat_prod_box_details"><?php echo $xhtml;?></div>

<style type="text/css">
	h3.status_order {
	    color: #f00;
	}
	span.alert {
	    background: #f00;
	    color: #fff;
	    font-size: 12px;
	    padding: 3px;
	    font-weight: 300;
	    border-radius: 3px;
	}
	span.alert-pendding {
	    background: #f00;
	}
	span.alert-wating {
	    background: #f8981d;
	}
	span.alert-success {
	    background: #00a12a;
	}
	a.destroy_order {
	    font-size: 12px;
	    margin-left: 10px;
	    color: #1da1f2;
	}
</style>
