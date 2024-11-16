<?php
	$xhtml = '';
	if(!empty($this->Items)){
		// Pagination
		$paginationHTML		= $this->pagination->showPagination(URL::createLink('default', 'book', 'list'));

		foreach($this->Items as $key => $value){
			$name	= $value['name'];

			$bookID			= $value['id'];
			$catID			= $value['category_id'];
			$bookNameURL	= URL::filterURL($name);
			$catNameURL		= URL::filterURL( $this->categoryName);

			$link	= URL::createLink('default', 'book', 'detail', array('category_id' => $value['category_id'],'book_id' => $value['id']), "$catNameURL/$bookNameURL-$catID-$bookID.html");

			// $description	= $value['description'];
			$description	= substr($value['description'], 0, 220)."...";

			$picture 		= Helper::createImage('book', '98x150-', $value['picture']);
			$xhtml 	.= '<div class="feat_prod_box">
							<div class="prod_img"><a href="'.$link.'">'.$picture.'</a></div>

							<div class="prod_det_box">
								<div class="box_top"></div>
								<div class="box_center">
									<div class="prod_title">'.$name.'</div>
									<p class="details">'.$description.'</p>
									<a href="'.$link.'" class="more">- xem thêm -</a>
									<div class="clear"></div>
								</div>
								<div class="box_bottom"></div>
							</div>
							<div class="clear"></div>
						</div>';
		}
	}else{
		$xhtml 	= '<div class="feat_prod_box">Nội dung đang cập nhật!</div>';
	}
?>

<!-- TITLE -->
<?php echo Helper::createTitle("$imageURL/bullet1.gif", $this->categoryName);?>

<!-- LIST CATEGORIES -->
<?php
	if(isset($this->arrParam['filter_search']) && !empty($this->arrParam['filter_search'])){
		$keyword_search = $this->arrParam['filter_search'];
	}else{
		$keyword_search = '';
	}
?>
<form action="#" method="post" name="adminForm" id="adminForm1">
	<div class="form-group">
		<input type="text" class="form-control" placeholder="nhập tên sách..." name="filter_search" value="<?php echo $keyword_search ?>">
		<input type="text" name="filter_page" id="filter_search" value="1" style="display: none">
		<button class="btn btn-search" type="submit">Tìm kiếm</button>
	</div>
	<?php echo $xhtml;?>
	<?php echo $paginationHTML; ?>
</form>
