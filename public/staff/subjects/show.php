<?php
	// query parameters are always received as strings
	// superglobal arrays always return string values
	// even if the passed value in URL is an integer
	$id = $_GET['id'];
	echo $id;
?>