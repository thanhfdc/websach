<?php
class UserModel extends Model{

	private $_columns = array('id', 'username', 'email', 'fullname', 'phone', 'address', 'password','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'group_id');
	private $_userInfo;

	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_USER);

		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	public function countItem($arrParam, $option = null){

		if($option['task'] == 'orderList'){
			$query[]	= "SELECT COUNT(`id`) AS `total`";
			$query[]	= "FROM ".TBL_CART." ";
			$query[]	= "WHERE 1";

			// FILTER : KEYWORD
			if(!empty($arrParam['filter_search'])){
				$keyword	= '"%' . $arrParam['filter_search'] . '%"';
				$query[]	= "AND (`username` LIKE $keyword OR `names` LIKE $keyword)";
			}

			// FILTER : DATE
			if(!empty($arrParam['filter_date'])){
				$date = explode("/",$arrParam['filter_date']);
				$query[]	= "AND date between '".trim($date[0])."' and '".trim($date[1])." :23:59:59' ";
				// $query		= implode(" ", $query);
				// print_r($query); die;
			}

			// FILTER : STATUS
			if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
				$query[]	= "AND `status` = '" . $arrParam['filter_state']. "'";
			}

			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			return $result['total'];
		}

		$query[]	= "SELECT COUNT(`id`) AS `total`";
		$query[]	= "FROM `$this->table`";
		$query[]	= "WHERE `id` > 0";

		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])){
			$keyword	= '"%' . $arrParam['filter_search'] . '%"';
			$query[]	= "AND (`username` LIKE $keyword OR `email` LIKE $keyword)";
		}

		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
			$query[]	= "AND `status` = '" . $arrParam['filter_state']. "'";
		}

		// FILTER : GROUP ID
		if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
			$query[]	= "AND `group_id` = '" . $arrParam['filter_group_id'] . "'";
		}

		$query		= implode(" ", $query);
		$result		= $this->fetchRow($query);
		return $result['total'];
	}

	public function itemInSelectbox($arrParam, $option = null){
		if($option == null){
			$query 	= "SELECT `id`, `name` FROM `" . TBL_GROUP . "`";
			$result = $this->fetchPairs($query);
			$result['default'] = "- Select Group -";
			ksort($result);
		}
		return $result;
	}

	public function listItem($arrParam, $option = null){

		if($option['task'] == 'orderList'){
			$query[]	= "SELECT * FROM ".TBL_CART." ";
			$query[]	= "WHERE 1";

			// FILTER : KEYWORD
			if(!empty($arrParam['filter_search'])){
				$keyword	= '"%' . $arrParam['filter_search'] . '%"';
				$query[]	= "AND (`username` LIKE $keyword OR `names` LIKE $keyword)";
			}

			// FILTER : DATE
			if(!empty($arrParam['filter_date'])){
				$date = explode("/",$arrParam['filter_date']);
				$query[]	= "AND date between '".trim($date[0])."' and '".trim($date[1])." :23:59:59' ";
				// $query		= implode(" ", $query);
				// print_r($query); die;
			}

			// FILTER : STATUS
			if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
				$query[]	= "AND `status` = '" . $arrParam['filter_state']. "'";
			}

			// SORT
			if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
				$column		= $arrParam['filter_column'];
				$columnDir	= $arrParam['filter_column_dir'];
				$query[]	= "ORDER BY `$column` $columnDir";
			}else{
				$query[]	= "ORDER BY `date` DESC";
			}

			// PAGINATION
			$pagination			= $arrParam['pagination'];
			$totalItemsPerPage	= $pagination['totalItemsPerPage'];
			if($totalItemsPerPage > 0){
				$position	= ($pagination['currentPage']-1)*$totalItemsPerPage;
				$query[]	= "LIMIT $position, $totalItemsPerPage";
			}

			$query		= implode(" ", $query);

			$result		= $this->fetchAll($query);
			return $result;
		}

		if($option['task'] == 'orderListReport'){
			$query[]	= "SELECT COUNT(*) AS `total`, status, date";
			$query[]	= "FROM ".TBL_CART." ";

			// FILTER : DATE
			if(!empty($arrParam['filter_date'])){
				$date = explode("/",$arrParam['filter_date']);
				$query[]	= "WHERE date between '".trim($date[0])."' and '".trim($date[1])." :23:59:59' ";
			}

			$query[]	= "GROUP BY status";
			$query		= implode(" ", $query);

			$result		= $this->fetchAll($query);

			//
			$arr_new = array(
				array('total'=>0,'status'=>0,'date'=>''),
				array('total'=>0,'status'=>1,'date'=>''),
				array('total'=>0,'status'=>2,'date'=>''),
			);

			if(count($result) != 3){
				$arr_status = array();

				foreach($result as $k=>$v){
					array_push($arr_status,$v['status']);
				}

				foreach($arr_new as $key=>$val)
				{
		        	if(in_array($val['status'],$arr_status)){
		            	unset($arr_new[$key]);
		            }
		        }
		        $arr_new = array_merge($arr_new,$result);
			}else{
				$arr_new = $result;
			}


			// $this->array_sort_by_column($arr_new, 'status');

			return json_encode($arr_new);
		}

		$query[]	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`phone`, `u`.`address`, `u`.`status`, `u`.`fullname`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS `group_name`";
		$query[]	= "FROM `$this->table` AS `u` LEFT JOIN `". TBL_GROUP . "` AS `g` ON `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `u`.`id` > 0";

		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])){
			$keyword	= '"%' . $arrParam['filter_search'] . '%"';
			$query[]	= "AND (`username` LIKE $keyword OR `email` LIKE $keyword)";
		}

		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
			$query[]	= "AND `u`.`status` = '" . $arrParam['filter_state'] . "'";
		}

		// FILTER : GROUP ID
		if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
			$query[]	= "AND `u`.`group_id` = '" . $arrParam['filter_group_id'] . "'";
		}

		// SORT
		if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
			$column		= $arrParam['filter_column'];
			$columnDir	= $arrParam['filter_column_dir'];
			$query[]	= "ORDER BY `u`.`$column` $columnDir";
		}else{
			$query[]	= "ORDER BY `u`.`id` DESC";
		}

		// PAGINATION
		$pagination			= $arrParam['pagination'];
		$totalItemsPerPage	= $pagination['totalItemsPerPage'];
		if($totalItemsPerPage > 0){
			$position	= ($pagination['currentPage']-1)*$totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}

		$query		= implode(" ", $query);
		$result		= $this->fetchAll($query);
		return $result;
	}

	public function changeStatus($arrParam, $option = null){
		if($option['task'] == 'change-ajax-status'){
			$status 		= ($arrParam['status'] == 0) ? 1 : 0;
			$modified_by	= $this->_userInfo['username'];
			$modified		= date('Y-m-d', time());
			$id				= $arrParam['id'];
			$query	= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
			$this->query($query);

			$result = array(
								'id'		=> $id,
								'status'	=> $status,
								'link'		=> URL::createLink('admin', 'user', 'ajaxStatus', array('id' => $id, 'status' => $status))
						);
			return $result;
		}

		if($option['task'] == 'change-status'){
			$status 		= $arrParam['type'];
			$modified_by	= $this->_userInfo['username'];
			$modified		= date('Y-m-d', time());
			if(!empty($arrParam['cid'])){
				$ids		= $this->createWhereDeleteSQL($arrParam['cid']);
				$query		= "UPDATE `$this->table` SET `status` = $status, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` IN ($ids)";
				$this->query($query);
				Session::set('message', array('class' => 'success', 'content' => 'Có ' . $this->affectedRows(). ' phần tử được thay đổi trạng thái!'));
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Vui lòng chọn vào phần tử muỗn thay đổi trạng thái!'));
			}
		}
	}

	public function deleteItem($arrParam, $option = null){
		if($option == null){
			if(!empty($arrParam['cid'])){
				$ids		= $this->createWhereDeleteSQL($arrParam['cid']);
				$query		= "DELETE FROM `$this->table` WHERE `id` IN ($ids)";
				$this->query($query);
				Session::set('message', array('class' => 'success', 'content' => 'Có ' . $this->affectedRows(). ' phần tử được xóa!'));
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Vui lòng chọn vào phần tử muỗn xóa!'));
			}
		}
	}

	public function infoItem($arrParam, $option = null){
		if($option['task'] == 'orderDetail'){
			$bookid = $arrParam['id'];

			$query[]	= "SELECT * FROM ".TBL_CART." WHERE `id` = '$bookid'  ";
			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			return $result;
		}

		if($option == null){
			$query[]	= "SELECT `id`, `username`, `email`, `fullname`, `phone`, `address`, `group_id`, `status`, `ordering`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->fetchRow($query);
			return $result;
		}
	}

	public function saveItem($arrParam, $option = null){
		if($option['task'] == 'add'){
			$arrParam['form']['created']	= date('Y-m-d', time());
			$arrParam['form']['created_by']	= $this->_userInfo['username'];
			$arrParam['form']['password']	= md5($arrParam['form']['password']);
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
			// Không cho thay đổi Username
			unset($arrParam['form']['username']);

			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $this->_userInfo['username'];
			if($arrParam['form']['password'] != null){
				$arrParam['form']['password']	= md5($arrParam['form']['password']);
			}else{
				unset($arrParam['form']['password']);
			}
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $arrParam['form']['id'];
		}
	}

	public function ordering($arrParam, $option = null){
		if($option == null){
			if(!empty($arrParam['order'])){
				$i = 0;
				$modified_by	= $this->_userInfo['username'];
				$modified		= date('Y-m-d', time());
				foreach($arrParam['order'] as $id => $ordering){
					$i++;
					$query	= "UPDATE `$this->table` SET `ordering` = $ordering, `modified` = '$modified', `modified_by` = '$modified_by'  WHERE `id` = '" . $id . "'";
					$this->query($query);
				}
				Session::set('message', array('class' => 'success', 'content' => 'Có ' .$i. ' phần tử được thay đỏi  ordering!'));
			}
		}
	}

	//UPDATE STATUS ORDER ITEM
	public function updateStatusOrder($arrParam)
	{
		# code...
		$query	= "UPDATE ".TBL_CART." SET `status` = ".$arrParam['status']." WHERE `id` = '" . $arrParam['id'] . "'";
		$this->query($query);
		return;
	}

	//TRASH ORDER ITEM
	public function deleteOrderItem($arrParam)
	{
		$query	= "DELETE FROM ".TBL_CART." WHERE `id` = '".$arrParam['form']['id']."' ";
		// print_r($query); die;
		$this->query($query);
		return;
	}


	public function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	    $sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

	    array_multisort($sort_col, $dir, $arr);
	}

}