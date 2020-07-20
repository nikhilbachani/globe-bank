<?php
	if(!isset($page_title)) { $page_title = 'Staff Area'; }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>GBI - <?php echo h($page_title); ?></title>
		<meta charset="utf-8">
		<!-- href works with url not file system. This will request (web_root)/stylesheets/staff.css -->
		<link rel="stylesheet" media="all" type="text/css" href="<?php echo url_for('/stylesheets/staff.css'); ?>">
	</head>
	<body>
		<header>
			<h1>GBI Staff Area</h1>
		</header>

		<nav>
			<ul>
				<li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
			</ul>
		</nav>
		