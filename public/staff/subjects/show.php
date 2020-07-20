<?php require_once('../../../private/initialize.php'); ?>

<?php
	// query parameters are always received as strings
	// superglobal variables (associative arrays) always
	// return string values, even if the passed value in 
	// URL is an integer. If integer is needed, cast it.

	// Following code with ?? (coalescing operator) is same
	// as:
	// $id = isset($_GET['id']) ? $_GET['id'] : '1'; // PHP < 7.0
	$id = $_GET['id'] ?? '1'; // ?? works for PHP >= 7.0
?>

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
	<a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

	<div class="subject show">
		Subject ID: <?php echo h($id); ?>
	</div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
