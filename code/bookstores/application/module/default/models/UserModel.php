<?php
class UserModel extends Model{

	private $_columns = array(
								'id',
								'username',
								'email',
								'fullname',
								'phone',
								'address',
								'password',
								'created',
								'created_by',
								'modified',
								'modified_by',
								'register_date',
								'register_ip',
								'status',
								'ordering',
								'group_id'
							);
	private $_userInfo;

	public function __construct(){
		parent::__construct();
		$this->setTable(TBL_USER);

		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'];
	}

	public function listItem($arrParam, $option = null){
		if($option['task'] == 'books-in-cart'){
			$cart	= Session::get('cart');
			$result	= array();
			if(!empty($cart)){
				$ids	= "(";
				foreach($cart['quantity'] as $key => $value) $ids .= "'$key', ";
				$ids	.= " '0')" ;

				$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`category_id`, `c`.`name` AS `category_name`";
				$query[]	= "FROM `".TBL_BOOK."` AS `b`, `".TBL_CATEGORY."` AS `c`";
				$query[]	= "WHERE `b`.`status`  = 1 AND  `c`.`id` = `b`.`category_id` AND `b`.`id` IN $ids";
				$query[]	= "ORDER BY `b`.`ordering` ASC";

				$query		= implode(" ", $query);
				$result		= $this->fetchAll($query);

				foreach($result as $key => $value){
					$result[$key]['quantity']	= $cart['quantity'][$value['id']];
					$result[$key]['totalprice']	= $cart['price'][$value['id']];
					$result[$key]['price']		= $result[$key]['totalprice'] / $result[$key]['quantity'];
				}
			}
			return $result;
		}

		if($option['task'] == 'history-cart'){
			$username	= $this->_userInfo['username'];

			$query[]	= "SELECT `id`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`";
			$query[]	= "FROM `".TBL_CART."`";
			$query[]	= "WHERE `username` = '$username'";


			$query[]	= "ORDER BY `date` DESC";

			$query		= implode(" ", $query);
			$result		= $this->fetchAll($query);

			return $result;
		}
	}

	public function saveItem($arrParam, $option = null){
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		if($option['task'] == 'submit-cart'){
			$id			= $this->randomString(7);
			$username	= $this->_userInfo['username'];
			$books		= json_encode($arrParam['form']['bookid']);
			$prices		= json_encode($arrParam['form']['price']);
			$quantities	= json_encode($arrParam['form']['quantity']);
			$names		= serialize($arrParam['form']['name']);
			$pictures	= json_encode($arrParam['form']['picture']);
			$date		= date('Y-m-d H:i:s', time());



			$query	= "INSERT INTO `".TBL_CART."`(`id`, `username`, `books`, `prices`, `quantities`, `names`, `pictures`, `status`, `date`)
					VALUES ('$id', '$username', '$books', '$prices', '$quantities', '$names', '$pictures', '0', '$date')";
			// print_r($query);die;
			$this->query($query);
			Session::delete('cart');
		}

		if($option['task'] == 'edit'){
			// Không cho thay đổi Username
			unset($arrParam['form']['username']);

			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $this->_userInfo['username'];
			if($arrParam['form']['password'] != null){
				$arrParam['form']['password']	= md5($arrParam['form']['password']);
				$queryPass = ", `password`= '".md5($arrParam['form']['password'])."'";
			}else{
				unset($arrParam['form']['password']);
				$queryPass = '';
			}
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$query = "UPDATE `user` SET `email`='".$data['email']."',`fullname`='".$data['fullname']."',`modified`='".$data['modified']."',`modified_by`='".$data['modified_by']."' ".$queryPass." WHERE id= ".$data['id']." ";
			$this->query($query);

			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $arrParam['form']['id'];
		}
	}

	private function randomString($length = 5){

		$arrCharacter = array_merge(range('a','z'), range(0,9), range('A','Z'));
		$arrCharacter = implode($arrCharacter, '');
		$arrCharacter = str_shuffle($arrCharacter);

		$result		= substr($arrCharacter, 0, $length);
		return $result;
	}

	//check quantity
	public function checkQuantity($bookid)
	{
		# code...
		$query[]	= "SELECT quantity FROM ".TBL_BOOK." WHERE `id` = '$bookid'  ";
		$query		= implode(" ", $query);
		$result		= $this->fetchRow($query);

		return $result;
	}


	//update quantity book
	public function updateQuantityBook($bookid,$quantity)
	{
		# code...
		$quantity = ($quantity > 0) ? $quantity : 0;
		$query = "UPDATE ".TBL_BOOK." SET `quantity`='".$quantity."' WHERE id= ".$bookid." ";

		$this->query($query);
		return;
	}
	//get user info
	public function getUserInfo()
	{
		# code...
		$userId = $this->_userInfo['id'];

		$query[]	= "SELECT * FROM ".TBL_USER." WHERE `id` = '$userId'  ";
		$query		= implode(" ", $query);
		$result		= $this->fetchRow($query);

		return $result;
	}

	//destroy_order
	public function destroy_order($arrParam, $option = null){
		$bookid = $arrParam['book_id'];
		// print_r($bookid);
		$query	= "DELETE FROM ".TBL_CART." WHERE `id` = '".$bookid."' ";
		$this->query($query);
		return;
	}
}