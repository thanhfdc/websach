<?php
class UserController extends Controller{

	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction(){
		$this->_view->_title	= 'Tài khoản';
		$this->_view->render('user/index');
	}

	public function cartAction(){
		$this->_view->_title	= 'My Cart';
		$this->_view->Items		= $this->_model->listItem($this->_arrParam, array('task' => 'books-in-cart'));
		$this->_view->render('user/cart');
	}

	public function orderAction(){
		$cart	= Session::get('cart');
		$bookID	= $this->_arrParam['book_id'];
		$price	= $this->_arrParam['price'];

		//check quantity book
		$checkQuantity = $this->_model->checkQuantity($bookID);

		if($checkQuantity['quantity'] > 0){
			if(empty($cart)){
				$cart['quantity'][$bookID]	= 1;
				$cart['price'][$bookID]		= $price;
			}else{
				if(key_exists($bookID, $cart['quantity'])){
					$cart['quantity'][$bookID]	+=1;
					$cart['price'][$bookID]		= $price * $cart['quantity'][$bookID];
				}else{
					$cart['quantity'][$bookID]	= 1;
					$cart['price'][$bookID]		= $price;
				}
			}

			//update quantity book
			$this->_model->updateQuantityBook($bookID,$checkQuantity['quantity']-1);
		}

		Session::set('cart', $cart);
		URL::redirect('default', 'book', 'detail', array('book_id' => $bookID));
	}

	public function historyAction(){
		$this->_view->_title	= 'History';
		$this->_view->Items		= $this->_model->listItem($this->_arrParam, array('task' => 'history-cart'));
		$this->_view->render('user/history');
	}

	public function destroy_orderAction()
	{
		$this->_model->destroy_order($this->_arrParam, array('task' => 'destroy_order'));
		URL::redirect('default', 'user', 'history');
	}

	public function buyAction(){
		$this->_model->saveItem($this->_arrParam, array('task' => 'submit-cart'));
		URL::redirect('default', 'user', 'cart');
	}

	// remove cart
	public function removeAction(){
		$cart	= Session::get('cart');
		$item_id = $this->_arrParam['id'];

		if (!empty($cart['quantity'])) {

		    foreach ($cart['quantity']  as $key => $val) {
		        if($key == $item_id)
		        {
		        	//update lai quantity
		        	$checkQuantity = $this->_model->checkQuantity($key);
		        	$this->_model->updateQuantityBook($key,$checkQuantity['quantity']+$val);

		            unset($cart['quantity'][$key]);
		            unset($cart['price'][$key]);
		        }
		    }
		}

		Session::set('cart', $cart);
		URL::redirect('default', 'user', 'cart');
	}

	//user info
	public function userInfoAction(){

		$task			= 'edit';
		$requirePass	= false;
		$queryUserName 	.= " AND `id` <> '".$this->_arrParam['form']['id']."'";
		$queryEmail 	.= " AND `id` <> '".$this->_arrParam['form']['id']."'";

		if($this->_arrParam['form']['token'] > 0){
		// 	$validate = new Validate($this->_arrParam['form']);
		// 	$validate->addRule('username', 'string-notExistRecord', array('database' => $this->_model, 'query' => $queryUserName, 'min' => 3, 'max' => 25))
		// 			 ->addRule('email', 'email-notExistRecord', array('database' => $this->_model, 'query' => $queryEmail));
		// 	$validate->run();
		// 	$this->_arrParam['form'] = $validate->getResult();
		// 	if($validate->isValid() == false){
		// 		$this->_view->errors = $validate->showErrors();
		// 	}else{
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				// URL::redirect('default', 'user', 'userInfo');
		// 		// if($this->_arrParam['type'] == 'save') 	URL::redirect('default', 'user', 'userInfo', array('id' => $id));
		// 	}
		}

		$this->_view->userInfo = $this->_model->getUserInfo();

		$this->_view->arrParam = $this->_arrParam;
		$this->_view->_title	= 'Tài khoản';
		$this->_view->render('user/user_info');
	}
}

