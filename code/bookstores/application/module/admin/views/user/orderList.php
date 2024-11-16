
<?php
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	// include_once 'submenu/index.php';

	// COLUMN
	$columnPost		= $this->arrParam['filter_column'];
	$orderPost		= $this->arrParam['filter_column_dir'];

	$lblUserName 	= Helper::cmsLinkSort('Tên người dùng', 'username', $columnPost, $orderPost);
	$lblCreated		= Helper::cmsLinkSort('Ngày tạo', 'created', $columnPost, $orderPost);
	$lblStatus	    = Helper::cmsLinkSort('Trạng thái', 'status', $columnPost, $orderPost);
	$lblID			= Helper::cmsLinkSort('Mã đơn hàng', 'id', $columnPost, $orderPost);

	// SELECT
	$arrStatus			= array('default' => '- Chọn trạng thái -', 2 => 'Đã giao dịch xong', 1 => 'Đã duyệt',  0 => 'Chờ duyệt');
	$selectboxStatus	= Helper::cmsSelectbox('filter_state', 'inputbox', $arrStatus, $this->arrParam['filter_state']);

	// Pagination
	$paginationHTML		= $this->pagination->showPagination(URL::createLink('admin', 'user', 'orderList'));

	// MESSAGE
	$message	= Session::get('message');
	Session::delete('message');
	$strMessage = Helper::cmsMessage($message);

?>
        <div id="system-message-container"><?php echo $strMessage;?></div>
        <!-- <canvas id="myChart" style="position: relative; height:40vh; width:80vw"></canvas> -->
		<div id="element-box">
			<div class="m">
				<form action="#" method="post" name="adminForm" id="adminForm">
                	<!-- FILTER -->
                    <fieldset id="filter-bar">
                        <div class="filter-search fltlft">
                            <label class="filter-search-lbl" for="filter_search">Lọc:</label>
                            <input type="text" name="filter_date" placeholder="Choose time..." value="" autocomplete="off" />
                            <input type="text" name="filter_search" placeholder="Searching..." id="filter_search" autocomplete="off" value="<?php echo $this->arrParam['filter_search'];?>">
                            <button type="submit" name="submit-keyword">Tìm kiếm</button>
                            <button type="button" name="clear-keyword">Xóa</button>
                        </div>
                        <div class="filter-select fltrt">
                            <?php echo $selectboxStatus ?>
                        </div>
                    </fieldset>
					<div class="clr"> </div>

                    <table class="adminlist" id="modules-mgr">
                    	<!-- HEADER TABLE -->
                        <thead>
                            <tr>
                                <th width="1%"><input type="checkbox" name="checkall-toggle"></th>
                                <th width="5%" class="title"><?php echo $lblUserName;?></th>
                                <th width="10%"><?php echo $lblStatus;?></th>
                                <th width="8%"><?php echo $lblCreated;?></th>
                                <th width="1%" class="nowrap"><?php echo $lblID;?></th>
                            </tr>
                        </thead>
                        <!-- FOOTER TABLE -->
                        <tfoot>
                            <tr>
                                <td colspan="12">
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
									$username	= $value['username'];
									$book		= $value['books'];
									$row		= ($i % 2 == 0) ? 'row0' : 'row1';
									$status		= '<div class="pedding">Chờ duyệt</div>';
									if($value['status'] == 1){
										$status		= '<div class="accept">Đã duyệt</div>';
									}else if($value['status'] == 2){
										$status		= '<div class="done">Đã giao dịch xong</div>';
									}
									$created	= Helper::formatDate('H:i d-m-Y', $value['date']);
									$linkEdit	= URL::createLink('admin', 'user', 'orderDetail', array('id' => $id));

		                           	echo  '<tr class="'.$row.'">
		                                	<td class="center">'.$ckb.'</td>
		                                	<td class="center"><a href="'.$linkEdit.'">'.$username.'</a></td>
			                                <td class="center">'.$status.'</td>
			                                <td class="center">'.$created.'</td>
			                                <td class="center">'.$id.'</td>
			                            </tr>';
									$i++;
								}
                            }
						?>
						</tbody>
					</table>

                    <div>
                        <input type="hidden" name="filter_column" value="username">
                        <input type="hidden" name="filter_page" value="1">
                        <input type="hidden" name="filter_column_dir" value="asc">
					</div>
                </form>

				<div class="clr"></div>
			</div>
		</div>
	</div>



<!-- datepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
	// var dataReport = [15, 20, 30];
	// function loadReport(){
	// 	$.ajax({
	// 		url: "http://localhost/bookstores/index.php?module=admin&controller=user&action=orderListReport",
	// 		// type:'post'
	// 		// data:{},
	// 		async: false, //blocks window close
	// 		success: function(data) {

	// 			let array = JSON.parse(data);
	// 			if(array.length){
	// 				dataReport = [array[0].total,array[1].total,array[2].total];
	// 				console.log(dataReport);
	// 			}
	// 		}
	// 		// context: document.body
	// 	})
	// }

	// loadReport();
	// //
	// var ctx = document.getElementById('myChart');
	// var data = {
	//     datasets: [{
	//         data: dataReport,
	//         backgroundColor: [
	// 	        '#f00',
	// 	        '#ff8100',
	// 	        '#22a401',
	// 	    ],
	//     }],

	//     labels: [
	//         'Chờ duyệt',
	//         'Đã duyệt',
	//         'Giao dịch xong'
	//     ],

	// };


	// var myPieChart = new Chart(ctx, {
	//     type: 'pie',
	//     data: data,
	//     options: {
	//         title: {
	//             display: true,
	//             text: 'Thông kê đơn hàng',
	//             position:'bottom'
	//         },
	//         legend: {
	//             display: true,
	//             position:'bottom'
	//         },
	//     }

	// });

	$(function() {

		$('input[name="filter_date"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
			  	cancelLabel: 'Clear'
			}
		});

		$('input[name="filter_date"]').on('apply.daterangepicker', function(ev, picker) {
		  	$(this).val(picker.startDate.format('YYYY-MM-DD') + ' / ' + picker.endDate.format('YYYY-MM-DD'));
		});

		$('input[name="filter_date"]').on('cancel.daterangepicker', function(ev, picker) {
		  	$(this).val('');
		});

	});

</script>