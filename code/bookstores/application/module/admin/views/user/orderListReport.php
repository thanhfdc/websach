
<?php
	include_once (MODULE_PATH . 'admin/views/toolbar.php');
	// include_once 'submenu/index.php';

	// COLUMN
	$columnPost		= $this->arrParam['filter_column'];
	$orderPost		= $this->arrParam['filter_column_dir'];

?>
        <div id="system-message-container"><?php echo $strMessage;?></div>

		<div id="element-box">
			<div class="m">
				<form action="#" method="post" name="adminForm" id="adminForm">
                	<!-- FILTER -->
                    <fieldset id="filter-bar">
                        <div class="filter-search fltlft">
                            <label class="filter-search-lbl" for="filter_search">Lọc:</label>
                            <input type="text" id="date_filter" name="filter_date" placeholder="Choose time..." value="" autocomplete="off" />
                            <button type="button" onclick="loadReportSearch()">Tìm kiếm</button>
                            <button type="button" name="clear-keyword">Hủy</button>
                        </div>
                        <div class="filter-select fltrt">
                            <?php echo $selectboxStatus ?>
                        </div>
                    </fieldset>
					<div class="clr"> </div>
				<tbody></tbody>
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
		<canvas id="myChart" style="position: relative; height:40vh; width:80vw"></canvas>
	</div>



<!-- datepicker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script type="text/javascript">
	var dataReport = [0, 0, 0];
	var URL_ROOT = 'http://localhost/bookstores/';

	function loadReportSearch(){
		let date = document.getElementById('date_filter').value;
		if(date){
			// let arr_date = date.split('/');
			//ajax
			$.ajax({
				url: URL_ROOT+"index.php?module=admin&controller=user&action=orderListReport",
				// type:'POST',
				data:{'filter_date':date},
				async: false, //blocks window close
				success: function(res) {
					let array = JSON.parse(res);
					if(array.length ==3){
						dataReport = [array[0].total,array[1].total,array[2].total];
					}else if(array.length ==2){

					}else if(array.length ==1){
						if(array.status == 0){
							dataReport= [array[0].total,0,0];
						}else if(array.status == 1){
							dataReport= [0,array[1].total,0];
						}else if(array.status == 2){
							dataReport= [0,0,array[2].total];
						}
					}else{
						dataReport= [0,0,0];
					}
					console.log(dataReport);
					loadChart(dataReport);
				}
			})
		}
		return false;
	}

	function loadReport(){
		$.ajax({
			url: URL_ROOT+"index.php?module=admin&controller=user&action=orderListReport",
			async: false, //blocks window close
			success: function(data) {

				let array = JSON.parse(data);
				if(array.length){
					dataReport = [array[0].total,array[1].total,array[2].total];
					loadChart(dataReport);
				}
			}
		})
	}

	loadReport();

	function loadChart(dataReport){
		//
		var ctx = document.getElementById('myChart');
		var data = {
		    datasets: [{
		        data: dataReport,
		        backgroundColor: [
			        '#f00',
			        '#ff8100',
			        '#22a401',
			    ],
		    }],

		    labels: [
		        'Chờ duyệt',
		        'Đã duyệt',
		        'Giao dịch xong'
		    ],

		};

		var theHelp = Chart.helpers;
		var myPieChart = new Chart(ctx, {
		    type: 'pie',
		    data: data,
		    options: {
		        title: {
		            display: true,
		            text: 'Thông kê đơn hàng',
		            position:'bottom'
		        },
		        legend: {
		            display: true,
		            position:'bottom',
		            labels: {
					      generateLabels: function(chart) {
					        var data = chart.data;
					        if (data.labels.length && data.datasets.length) {
					          return data.labels.map(function(label, i) {
					            var meta = chart.getDatasetMeta(0);
					            var ds = data.datasets[0];
					            var arc = meta.data[i];
					            var custom = arc && arc.custom || {};
					            var getValueAtIndexOrDefault = theHelp.getValueAtIndexOrDefault;
					            var arcOpts = chart.options.elements.arc;
					            var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
					            var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
					            var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
					              return {
					              // And finally :
					              text: label + " (" + ds.data[i] +')'  ,
					              fillStyle: fill,
					              strokeStyle: stroke,
					              lineWidth: bw,
					              hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
					              index: i
					            };
					          });
					        }
					        return [];
					      }
					    }
		        },
		    }

		});
	}


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