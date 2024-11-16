<?php
class UserController extends Controller{

	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	// ACTION: LIST USER
	public function indexAction(){
		$this->_view->_title 		= 'Quản lí người dùng';
		$totalItems					= $this->_model->countItem($this->_arrParam, null);

		$configPagination = array('totalItemsPerPage'	=> 5, 'pageRange' => 3);
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

		$this->_view->slbGroup		= $this->_model->itemInSelectbox($this->_arrParam, null);
		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, null);
		$this->_view->render('user/index');
	}

	// ACTION: ADD & EDIT GROUP
	public function formAction(){
		$this->_view->_title = 'Thêm người dùng';
		$this->_view->slbGroup		= $this->_model->itemInSelectbox($this->_arrParam, null);

		if(isset($this->_arrParam['id'])){

			$this->_view->_title = 'User : Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if(empty($this->_arrParam['form'])) URL::redirect('admin', 'user', 'index');
		}

		if($this->_arrParam['form']['token'] > 0){
			$task			= 'add';
			$requirePass	= true;
			$queryUserName	= "SELECT `id` FROM `".TBL_USER."` WHERE `username` = '".$this->_arrParam['form']['username']."'";
			$queryEmail		= "SELECT `id` FROM `".TBL_USER."` WHERE `email` = '".$this->_arrParam['form']['email']."'";
			if(isset($this->_arrParam['form']['id'])){
				$task			 = 'edit';
				$requirePass	 = false;
				$queryUserName 	.= " AND `id` <> '".$this->_arrParam['form']['id']."'";
				$queryEmail 	.= " AND `id` <> '".$this->_arrParam['form']['id']."'";
			}


			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('username', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25))
					 ->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail))
					 ->addRule('password', 'password', array('action' => $task), $requirePass)
					 ->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
					 ->addRule('status', 'status', array('deny' => array('default')))
					 ->addRule('group_id', 'status', array('deny' => array('default')));
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'user', 'index');
				if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'user', 'form');
				if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'user', 'form', array('id' => $id));
			}
		}

		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('user/form');
	}

	// ACTION: AJAX STATUS (*)
	public function ajaxStatusAction(){
		$result = $this->_model->changeStatus($this->_arrParam, array('task' => 'change-ajax-status'));
		echo json_encode($result);
	}

	// ACTION: STATUS (*)
	public function statusAction(){
		$this->_model->changeStatus($this->_arrParam, array('task' => 'change-status'));
		URL::redirect('admin', 'user', 'index');
	}

	// ACTION: TRASH (*)
	public function trashAction(){
		$this->_model->deleteItem($this->_arrParam);
		URL::redirect('admin', 'user', 'index');
	}

	// ACTION: ORDERING (*)
	public function orderingAction(){
		$this->_model->ordering($this->_arrParam);
		URL::redirect('admin', 'user', 'index');
	}

	// ACTION: ORDER LIST (CART)
	public function orderListAction(){
		$this->_view->_title 		= 'Danh sách đơn hàng';
		$totalItems					= $this->_model->countItem($this->_arrParam, array('task' => 'orderList'));

		$configPagination = array('totalItemsPerPage'	=> 5, 'pageRange' => 3);
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

		// // $this->_view->slbGroup		= $this->_model->itemInSelectbox($this->_arrParam, null);
		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, array('task' => 'orderList'));
		$this->_view->render('user/orderList');
	}

	// ACTION: orderDetailAction
	public function orderDetailAction(){
		$this->_view->_title = 'Chi tiết đơn hàng';

		if($this->_arrParam['form']['token'] > 0){
			// print_r($this->_arrParam);
			// $id = $this->_arrParam['id'];
			URL::redirect('admin', 'user', 'updateStatusOrder', array('id' => $this->_arrParam['form']['id'],'status'=>$this->_arrParam['form']['status']));
		}

		$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam, array('task' => 'orderDetail'));
		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('user/orderDetail');
	}

	// ACTION: updateStatusOrderAction
	public function updateStatusOrderAction(){
		$this->_model->updateStatusOrder($this->_arrParam);
		URL::redirect('admin', 'user', 'orderList');
	}

	// ACTION: TRASH ORDER(*)
	public function trashOrderAction(){
		$this->_model->deleteOrderItem($this->_arrParam);
		URL::redirect('admin', 'user', 'orderList');
	}

	// ACTION: ORDER LIST (CART)
	public function orderListReportsAction(){
		$this->_view->_title 		= 'Thống kê đơn hàng';
		// $totalItems					= $this->_model->countItem($this->_arrParam, array('task' => 'orderList'));
		$this->_view->render('user/orderListReport');
	}

	// ACTION: ORDER LIST (CART) REPORT
	public function orderListReportAction(){

		$this->_view->Items 		= $this->_model->listItem($this->_arrParam, array('task' => 'orderListReport'));
		print_r($this->_view->Items); die;
		// echo json_encode(array(10,20,30));
	}
}