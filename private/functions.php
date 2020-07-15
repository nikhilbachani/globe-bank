<?php
	function url_for($script_path) {
		// add the leading '/' if not present
		if($script_path[0] != '/') {
			$script_path = '/' / $script_path;
		}
		// we get absolute point on which we can base all
		// our other URLs upon.
		return WWW_ROOT . $script_path;
	}
?>
