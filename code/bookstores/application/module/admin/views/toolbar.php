<?php
	$controller	= $this->arrParam['controller'];
	// New
	$linkNew	= URL::createLink('admin', $controller, 'form');
	$btnNew		= Helper::cmsButton('Thêm mới', 'toolbar-popup-new', $linkNew, 'icon-32-new');

	// Publish
	$linkPublish= URL::createLink('admin', $controller, 'status', array('type' => 1));
	$btnPublish	= Helper::cmsButton('Hiển thị', 'toolbar-publish', $linkPublish, 'icon-32-publish', 'submit');

	// Unpublish
	$linkUnPublish	= URL::createLink('admin', $controller, 'status', array('type' => 0));
	$btnUnPublish	= Helper::cmsButton('Ẩn', 'toolbar-unpublish', $linkUnPublish, 'icon-32-unpublish', 'submit');

	// Ordering
	$linkOrdering	= URL::createLink('admin', $controller, 'ordering');
	$btnOrdering	= Helper::cmsButton('Sắp xếp', 'toolbar-checkin', $linkOrdering, 'icon-32-checkin', 'submit');

	// Trash
	$linkTrash	= URL::createLink('admin', $controller, 'trash');
	$btnTrash	= Helper::cmsButton('Xóa', 'toolbar-trash', $linkTrash, 'icon-32-trash', 'submit');

	// Save
	$linkSave	= URL::createLink('admin', $controller, 'form', array('type' => 'save'));
	$btnSave	= Helper::cmsButton('Lưu', 'toolbar-apply', $linkSave, 'icon-32-apply', 'submit');

	// Save & Close
	$linkSaveClose	= URL::createLink('admin', $controller, 'form', array('type' => 'save-close'));
	$btnSaveClose	= Helper::cmsButton('Lưu và thoát', 'toolbar-save', $linkSaveClose, 'icon-32-save', 'submit');

	// Save & New
	$linkSaveNew	= URL::createLink('admin', $controller, 'form', array('type' => 'save-new'));
	$btnSaveNew		= Helper::cmsButton('Lưu và thêm mới', 'toolbar-save-new', $linkSaveNew, 'icon-32-save-new', 'submit');

	// Cancel
	$linkCancel		= URL::createLink('admin', $controller, 'index');
	$btnCancel		= Helper::cmsButton('Hủy', 'toolbar-cancel', $linkCancel, 'icon-32-cancel');

	// Save order
	$linkSaveOrder	= URL::createLink('admin', $controller, 'orderDetail', array('type' => 'save'));
	$btnSaveOrder	= Helper::cmsButton('Lưu', 'toolbar-apply', $linkSaveOrder, 'icon-32-apply', 'submit');

	// Trash order
	$linkTrashOrder	= URL::createLink('admin', $controller, 'trashOrder');
	$btnTrashOrder	= Helper::cmsButton('Xóa', 'toolbar-trash', $linkTrashOrder, 'icon-32-trash', 'submit');

	switch ($this->arrParam['action']) {
		case 'index':
			if($controller == 'group'){
				$strButton	= $btnPublish . $btnUnPublish . $btnOrdering  ;
			}else{
				$strButton	= $btnNew . $btnPublish . $btnUnPublish . $btnOrdering . $btnTrash ;
			}
			break;
		case 'form':
			$strButton	= $btnSave . $btnSaveClose . $btnCancel;
			break;
		case 'orderDetail':
			$strButton	= $btnSaveOrder. $btnTrashOrder;
			break;
		case 'profile':
			$strButton	= $btnSave . $btnSaveClose  . $btnCancel;
			break;
	}
?>
<div id="toolbar-box">
			<div class="m">
            	<!-- TOOLBAR -->
				<div class="toolbar-list" id="toolbar">
                    <ul>
                    	<?php echo $strButton;?>
                    </ul>

					<div class="clr"></div>
				</div>
				<!-- TITLE -->
                <div class="pagetitle icon-48-groups"><h2><?php echo $this->_title;?></h2></div>
			</div>
		</div>