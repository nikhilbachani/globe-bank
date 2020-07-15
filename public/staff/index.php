<?php 
	// require and include (unlike href) work with the file system on server. This will request globe_bank/private/initialize.php
	require_once('../../private/initialize.php'); 
	// can't replace with PRIVATE_PATH here since we define
	// those constants in that file itself, it should be 
	// loaded first to use these constants. 
?>

<?php $page_title = 'Staff Menu'; // this variable is now available inside included/ required files ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>
<div id="content">

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
