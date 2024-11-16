<?php
class BookController extends Controller{

	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	// ACTION: LIST BOOK
	public function listAction(){

		$this->_view->_title 		= 'Danh sách';
		$this->_view->categoryName 	= $this->_model->infoItem($this->_arrParam, array('task' => 'get-cat-name'));

		#pagination
		$totalItems	= $this->_model->countItem($this->_arrParam, null);
		// die($totalItems);
		$configPagination = array('totalItemsPerPage'	=> 2, 'pageRange' => 3);
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);

		$this->_view->Items	 		= $this->_model->listItem($this->_arrParam, array('task' => 'books-in-cat'));

		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('book/list');
	}

	// ACTION: DETAIL BOOK
	public function detailAction(){
		$this->_view->_title 		= 'Chi tiết';
 		$this->_view->bookInfo 		= $this->_model->infoItem($this->_arrParam, array('task' => 'book-info'));
		$this->_view->render('book/detail');
	}

	// ACTION: RELATE BOOK
	public function relateAction(){
		$this->_view->bookRelate	= $this->_model->listItem($this->_arrParam, array('task' => 'books-relate'));
		$this->_view->render('book/relate', false);
	}
}