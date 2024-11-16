<?php 
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	include_once 'submenu/index.php';

	// COLUMN
	$columnPost		= $this->arrParam['filter_column'];
	$orderPost		= $this->arrParam['filter_column_dir'];
	$lblName 		= Helper::cmsLinkSort('Tên', 'name', $columnPost, $orderPost);
	$lblPicture		= Helper::cmsLinkSort('Hình ảnh', 'picture', $columnPost, $orderPost);
	$lblPrice 		= Helper::cmsLinkSort('Giá', 'price', $columnPost, $orderPost);
	$lblSaleOff		= Helper::cmsLinkSort('Khuyến mãi', 'sale_off', $columnPost, $orderPost);
	$lblQuantity	= Helper::cmsLinkSort('Số lượng', 'quantity', $columnPost, $orderPost);
	$lblCategory	= Helper::cmsLinkSort('Thể loại', 'category_id', $columnPost, $orderPost);
	$lblStatus		= Helper::cmsLinkSort('Trạng thái', 'status', $columnPost, $orderPost);
	$lblSpecial		= Helper::cmsLinkSort('Nổi bật', 'special', $columnPost, $orderPost);
	$lblOrdering	= Helper::cmsLinkSort('Sắp xếp', 'ordering', $columnPost, $orderPost);
	$lblCreated		= Helper::cmsLinkSort('Ngày tạo', 'created', $columnPost, $orderPost);
	$lblCreatedBy	= Helper::cmsLinkSort('Người tạo', 'created_by', $columnPost, $orderPost);
	$lblModified	= Helper::cmsLinkSort('Ngày chỉnh sửa', 'modified', $columnPost, $orderPost);
	$lblModifiedBy	= Helper::cmsLinkSort('Người chỉnh sửa', 'modified_by', $columnPost, $orderPost);
	$lblID			= Helper::cmsLinkSort('Mã ID', 'id', $columnPost, $orderPost);
	
	// SELECT
	$arrStatus			= array('default' => '- Chọn trạng thái -', 1 => 'Hiển thị',  0 => 'Ẩn');
	$selectboxStatus	= Helper::cmsSelectbox('filter_state', 'inputbox', $arrStatus, $this->arrParam['filter_state']);
	
	// SELECT SPECIAL
	$arrSpecial			= array('default' => '- Chọn nổi bật -', 1 => 'Có',  0 => 'Không');
	$selectboxSpecial	= Helper::cmsSelectbox('filter_special', 'inputbox', $arrSpecial, $this->arrParam['filter_special']);
	
	// CATEGORY
	$selectboxCategory	= Helper::cmsSelectbox('filter_category_id', 'inputbox', $this->slbCategory, $this->arrParam['filter_category_id']);
	
	// Pagination
	$paginationHTML		= $this->pagination->showPagination(URL::createLink('admin', 'book', 'index'));
	
	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);
	
?>
        <div id="system-message-container"><?php echo $strMessage;?></div>
        
		<div id="element-box">
			<div class="m">
				<form action="#" method="post" name="adminForm" id="adminForm">
                	<!-- FILTER -->
                    <fieldset id="filter-bar">
                        <div class="filter-search fltlft">
                            <label class="filter-search-lbl" for="filter_search">Lọc:</label>
                            <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->arrParam['filter_search'];?>">
                            <button type="submit" name="submit-keyword">Tìm kiếm</button>
                            <button type="button" name="clear-keyword">Xóa</button>
                        </div>
                        <div class="filter-select fltrt">
                            <?php echo $selectboxStatus . $selectboxSpecial . $selectboxCategory;?>
                        </div>
                    </fieldset>
					<div class="clr"> </div>

                    <table class="adminlist" id="modules-mgr">
                    	<!-- HEADER TABLE -->
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" name="checkall-toggle"></th>
                                <th class="title"><?php echo $lblName;?></th>
                                <th width="8%"><?php echo $lblPicture;?></th>
                                <th width="6%"><?php echo $lblPrice;?></th>
                                <th width="6%"><?php echo $lblSaleOff;?></th>
                                <th width="6%"><?php echo $lblQuantity;?></th>
                                <th width="10%"><?php echo $lblCategory;?></th>
                                <th width="5%"><?php echo $lblStatus;?></th>
                                <th width="5%"><?php echo $lblSpecial;?></th>
                                <th width="6%"><?php echo $lblOrdering;?></th>
                                <th width="7%"><?php echo $lblCreated;?></th>
                                <th width="7%"><?php echo $lblCreatedBy;?></th>
                                <th width="7%"><?php echo $lblModified;?></th>
                                <th width="7%"><?php echo $lblModifiedBy;?></th>
                                <th width="1%" class="nowrap"><?php echo $lblID;?></th>
                            </tr>
                        </thead>
                        <!-- FOOTER TABLE -->
                        <tfoot>
                            <tr>
                                <td colspan="14">
                                    <!-- PAGINATION -->
                                    <div class="container">
                                        <?php echo $paginationHTML;?>
                                    </div>				
                                </td>
                            </tr>
                        </tfoot>
                        <!-- BODY TABLE -->
				<tbody>
				<?php 
							if(!empty($this->Items)){
								$i = 0;
								foreach($this->Items as $key => $value){
									$id 		= $value['id'];
									$ckb		= '<input type="checkbox" name="cid[]" value="'.$id.'">';
									$name		= $value['name'];
									$picture 	= Helper::createImage('book', '98x150-', $value['picture'], array('width' => 60, 'height' => 90));
									$price		= $value['price'];
									$saleoff	= $value['sale_off'];
									$quantity   = $value['quantity'];
									$categoryName	= $value['category_name'];
									$row		= ($i % 2 == 0) ? 'row0' : 'row1';
									$status		= Helper::cmsStatus($value['status'], URL::createLink('admin', 'book', 'ajaxStatus', array('id' => $id, 'status' => $value['status'])), $id);
									$special	= Helper::cmsSpecial($value['special'], URL::createLink('admin', 'book', 'ajaxSpecial', array('id' => $id, 'special' => $value['special'])), $id);
									$ordering	= '<input type="text" name="order['.$id.']" size="5" value="'.$value['ordering'].'" class="text-area-order">';
									$created	= Helper::formatDate('d-m-Y', $value['created']);
									$created_by	= $value['created_by'];
									$modified	= Helper::formatDate('d-m-Y', $value['modified']);
									$modified_by= $value['modified_by'];
									$linkEdit	= URL::createLink('admin', 'book', 'form', array('id' => $id));
								
		                           	echo  '<tr class="'.$row.'">
		                                	<td class="center">'.$ckb.'</td>
		                                	<td><a href="'.$linkEdit.'">'.$name.'</a></td>
			                                <td class="center">'.$picture.'</td>
			                                <td class="center">'.$price.'</td>
			                                <td class="center">'.$saleoff.'</td>
			                                <td class="center">'.$quantity.'</td>
			                                <td class="center">'.$categoryName.'</td>
			                                <td class="center">'.$status.'</td>
			                                <td class="center">'.$special.'</td>
			                                <td class="order">'.$ordering.'</td>
			                                <td class="center">'.$created.'</td>
			                                <td class="center">'.$created_by.'</td>
			                                <td class="center">'.$modified.'</td>
			                                <td class="center">'.$modified_by.'</td>
			                                <td class="center">'.$id.'</td>
			                            </tr>';	
									$i++;
								}
                            }
						?>
						</tbody>
					</table>

                    <div>
                        <input type="hidden" name="filter_column" value="name">
                        <input type="hidden" name="filter_page" value="1">
                        <input type="hidden" name="filter_column_dir" value="asc">
					</div>
                </form>

				<div class="clr"></div>
			</div>
		</div>
	</div>