<?php
	$bookInfo	= $this->bookInfo;
	$name		= $bookInfo['name'];
	$quantity 	= ($bookInfo['quantity'] > 0) ? $bookInfo['quantity'] : 'Hết hàng';

	$picture 		= Helper::createImage('book', '98x150-', $bookInfo['picture']);
	$picturePath	= UPLOAD_PATH . 'book' . DS . '98x150-' . $bookInfo['picture'];
	$pictureFull	= '';
	if(file_exists($picturePath)==true){
		$pictureFull	= UPLOAD_URL . 'book' . DS . $bookInfo['picture'];
	}

	$description	= substr($bookInfo['description'], 0, 400);

	$priceReal 		= 0;
	if($bookInfo['sale_off'] > 0){
		$priceReal	= (100-$bookInfo['sale_off'])*$bookInfo['price']/100;
		$price	 = ' <span class="red-through">'.number_format($bookInfo['price']).'</span>';
		$price	.= ' <span class="red">'.number_format($priceReal).'</span>';
	}else{
		$priceReal	= $bookInfo['price'];
		$price	= ' <span class="red">'.number_format($priceReal).'</span>';
	}

	$linkOrder			= URL::createLink('default', 'user', 'order', array('book_id' => $bookInfo['id'], 'price' => $priceReal));
	$linkRelateBoook	= URL::createLink('default', 'book', 'relate', array('book_id' => $bookInfo['id'], 'category_id' => $bookInfo['category_id']));
?>

<!-- TITLE -->
<?php echo Helper::createTitle("$imageURL/bullet1.gif", $name);?>

<!-- BOOK INFO -->
<div class="feat_prod_box_details">
	<div class="prod_img">
		<a href="#"><?php echo $picture;?></a> <br>
		<br> <a id="single_image" href="<?php echo $pictureFull;?>"
			rel="lightbox"> <img src="<?php echo $imageURL;?>/zoom.gif" ></a>
	</div>
	<div class="prod_det_box">
		<div class="box_top"></div>
		<div class="box_center">
			<div class="prod_title">Giới thiệu</div>
			<p class="details"><?php echo $description;?></p>
			<div class="price">
				<strong>Giá: </strong><?php echo $price;?>
			</div>
			<div class="sold">
				<strong>Số lượng: </strong><span><?php echo $quantity; ?></span>
			</div>
			<?php
				if($bookInfo['quantity'] > 0){
					?><a href="<?php echo $linkOrder;?>" class="more"><img src="<?php echo $imageURL;?>/order_now.gif"></a><?php
				}
			?>
			<div class="clear"></div>
		</div>
		<div class="box_bottom"></div>
	</div>
	<div class="clear"></div>
</div>


<div id="demo" class="demolayout">

	<ul id="demo-nav" class="demolayout">
		<li><a class="tab1 active" href="#">Chi tiết</a></li>
		<li><a class="tab2" href="javascript:void(0)" onclick="showRelateBooks('<?php echo $linkRelateBoook;?>')">Sách liên quan</a></li>
	</ul>

	<div class="tabs-container">

		<div style="display: block;" class="tab" id="tab1">
			<p class="more_details"><?php echo $bookInfo['description'];?></p>
		</div>

		<div style="display: none;" class="tab" id="tab2">
			<!-- RELATE BOOK -->
		</div>
	</div>
</div>