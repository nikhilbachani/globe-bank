<?php
	
	function find_all_subjects($options = []) {
		global $db;

		$visible = $options['visible'] ?? false;

		$sql = 'SELECT * FROM subjects ';

		if ($visible) {
			$sql .= 'WHERE visible = true ';
		}

		$sql .= 'ORDER BY position';
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_subject_by_id($id, $options = []) {
		global $db;

		$visible = $options['visible'] ?? false;

		$sql = "SELECT * FROM subjects ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		if ($visible) {
			$sql .= "AND visible = true";
		}
		
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$subject = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $subject;
	}

	function validate_subject($subject) {
		$errors = [];

		if(is_blank($subject['menu_name'])) {
			$errors[] = "Name cannot be blank.";
		} elseif(!has_length($subject['menu_name'], ['min' => 2, 'max' => 255])) {
			$errors[] = 'Name must be between 2 and 255 characters.';
		}

		$position_int = (int) $subject['position'];
		if ($position_int <= 0) {
			$errors[] = 'Position must be greater than zero.';
		} elseif ($position_int > 999) {
			$errors[] = 'Position must be lesser than or equal to 999.';
		}

		$visible_str = (string) $subject['visible'];
		if (!has_inclusion_of($visible_str, ['0', '1'])) {
			$errors[] = 'Visible must be true or false.';
		}

		return $errors;
	}

	function insert_subject($subject) {
		global $db;

		$errors = validate_subject($subject);
		if (!empty($errors)) {
			return $errors;
		}

		$sql = "INSERT INTO subjects ";
		$sql .= "(menu_name, position, visible) ";
		$sql .= "VALUES (";
		$sql .= "'" . db_escape($db, $subject['menu_name']) . "', ";
		$sql .= "'" . db_escape($db, $subject['position']) . "', ";
		$sql .= "'" . db_escape($db, $subject['visible']) . "'";
		$sql .= ")";

		$result = mysqli_query($db, $sql);
		
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function update_subject($subject) {
		global $db;

		$errors = validate_subject($subject);
		if (!empty($errors)) {
			return $errors;
		}

		$sql = "UPDATE subjects SET ";
		$sql .= "menu_name = '" . db_escape($db, $subject['menu_name']) . "', ";
		$sql .= "position = '" . db_escape($db, $subject['position']) . "', ";
		$sql .= "visible = '" . db_escape($db, $subject['visible']) . "' ";
		$sql .= "WHERE id = '" . db_escape($db, $subject['id']) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function delete_subject($id) {
		global $db;

		$sql = "DELETE FROM subjects ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if (!$result) {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function find_all_pages() {
		global $db;

		$sql = 'SELECT * FROM pages ';
		$sql .= 'ORDER BY subject_id, position';
		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_page_by_id($id, $options = []) {
		global $db;

		$visible = $options['visible'] ?? false;

		$sql = "SELECT * FROM pages ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		if ($visible) {
			$sql .= "AND visible = true";
		}

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		$page = mysqli_fetch_assoc($result);
		mysqli_free_result($result);
		return $page;
	}

	function find_pages_by_subject_id($subject_id, $options = []) {
		global $db;

		$visible = $options['visible'] ?? false;

		$sql = "SELECT * FROM pages ";
		$sql .= "WHERE subject_id = '" . db_escape($db, $subject_id) . "' ";

		if ($visible) {
			$sql .= "AND visible = true ";
		}

		$sql .= "ORDER BY position";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function validate_page($page) {
		$errors = [];

		if (is_blank($page['subject_id'])) {
			$errors[] = 'Subject cannot be blank.';
		}

		if (is_blank($page['menu_name'])) {
			$errors[] = 'Name cannot be blank';
		} elseif (!has_length($page['menu_name'], ['min' => 2, 'max' => 255])) {
			$errors[] = 'Name must be between 2 and 255 characters.';
		} 

		$current_id = $page['id'] ?? '0';
		if (!has_unique_page_menu_name($page['menu_name'], $current_id)) {
			$errors[] = 'Name must be unique.';
		}

		$position_int = (int) $page['position'];
		if ($position_int <= 0) {
			$errors[] = 'Position must be greater than zero.';
		} elseif ($position_int > 999) {
			$errors[] = 'Position must be lesser than or equal to 999.';
		}

		$visible_str = (string) $page['visible'];
		if (!has_inclusion_of($visible_str, ['0', '1'])) {
			$errors[] = 'Visible must be true or false';
		}

		if (is_blank($page['content'])) {
			$errors[] = 'Content cannot be blank.';
		}

		return $errors;
	}

	function insert_page($page) {
		global $db;

		$errors = validate_page($page);
		if (!empty($errors)) {
			return $errors;
		}

		$sql = "INSERT INTO pages ";
		$sql .= "(subject_id, menu_name, position, visible, content) ";
		$sql .= "VALUES (";
		$sql.= "'" . db_escape($db, $page['subject_id']) . "', ";
		$sql.= "'" . db_escape($db, $page['menu_name']) . "', ";
		$sql.= "'" . db_escape($db, $page['position']) . "', ";
		$sql.= "'" . db_escape($db, $page['visible']) . "', ";
		$sql.= "'" . db_escape($db, $page['content']) . "'";
		$sql .= ")";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function update_page($page) {
		global $db;

		$errors = validate_page($page);
		if (!empty($errors)) {
			return $errors;
		}

		$sql = "UPDATE pages SET ";
		$sql .= "subject_id = '" . db_escape($db, $page['subject_id']) . "', ";
		$sql .= "menu_name = '" . db_escape($db, $page['menu_name']) . "', ";
		$sql .= "position = '" . db_escape($db, $page['position']) . "', ";
		$sql .= "visible = '" . db_escape($db, $page['visible']) . "', ";
		$sql .= "content = '" . db_escape($db, $page['content']) . "' ";
		$sql .= "WHERE id = '" . db_escape($db, $page['id']) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function delete_page($id) {
		global $db;

		$sql = "DELETE FROM pages ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if (!$result) {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function find_all_admins() {
		global $db;

		$sql = 'SELECT * FROM admins ';
		$sql .= 'ORDER BY last_name, first_name';

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		return $result;
	}

	function find_admin_by_id($id) {
		global $db;

		$sql = "SELECT * FROM admins ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		
		$admin = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		return $admin;
	}

	function find_admin_by_username($username) {
		global $db;

		$sql = "SELECT * FROM admins ";
		$sql .= "WHERE username = '" . db_escape($db, $username) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		confirm_result_set($result);
		
		$admin = mysqli_fetch_assoc($result);
		mysqli_free_result($result);

		return $admin;
	}

	function validate_admin($admin) {
		$errors = [];

		if (is_blank($admin['first_name'])) {
			$errors[] = 'First name cannot be blank.';
		} elseif (!has_length($admin['first_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = 'First name must be between 2 and 255 characters.';
		}

		if (is_blank($admin['last_name'])) {
			$errors[] = 'Last name cannot be blank.';
		} elseif (!has_length($admin['last_name'], array('min' => 2, 'max' => 255))) {
			$errors[] = 'Last name must be between 2 and 255 characters.';
		}

		if (is_blank($admin['email'])) {
			$errors[] = 'Email cannot be blank.';
		} elseif (!has_length($admin['email'], array('max' => 255))) {
			$errors[] = 'Email must be less than 255 characters.';
		} elseif (!has_valid_email_format($admin['email'])) {
			$errors[] = 'Email must be in a valid format.';
		}

		if (is_blank($admin['username'])) {
			$errors[] = 'Username cannot be blank.';
		} elseif (!has_length($admin['username'], array('min' => 8, 'max' => 255))) {
			$errors[] = 'Username must be between 8 and 255 characters.';
		} elseif (!has_unique_username($admin['username'], $admin['id'] ?? 0)) {
			$errors[] = 'Username not allowed. Try another one.';
		}

		if (is_blank($admin['password'])) {
			$errors[] = 'Password cannot be blank.';
		} elseif (!has_length($admin['password'], array('min' => 12))) {
			$errors[] = 'Password must contain 12 or more characters.';
		} elseif (!preg_match('/[A-Z]/', $admin['password'])) {
			$errors[] = 'Password must contain at least 1 uppercase letter.';
		} elseif (!preg_match('/[a-z]/', $admin['password'])) {
			$errors[] = 'Password must contain at least 1 lowercase letter.';
		} elseif (!preg_match('/[0-9]/', $admin['password'])) {
			$errors[] = 'Password must contain at least 1 digit.';
		} elseif (!preg_match('/[^A-Za-z0-9\s]/', $admin['password'])) {
			$errors[] = 'Password must contain at least 1 special character.';
		}

		if (is_blank($admin['confirm_password'])) {
			$errors[] = 'Confirm password cannot be blank.';
		} elseif ($admin['password'] !== $admin['confirm_password']) {
			$errors[] = 'Password and confirm password must match.';
		}

		return $errors;
	}

	function insert_admin($admin) {
		global $db;

		$errors = validate_admin($admin);
		if (!empty($errors)) {
			return $errors;
		}

		$hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

		$sql = "INSERT INTO admins ";
		$sql .= "(first_name, last_name, email, username, hashed_password) VALUES (";
		$sql .= "'" . db_escape($db, $admin['first_name']) . "', ";
		$sql .= "'" . db_escape($db, $admin['last_name']) . "', ";
		$sql .= "'" . db_escape($db, $admin['email']) . "', ";
		$sql .= "'" . db_escape($db, $admin['username']) . "', ";
		$sql .= "'" . db_escape($db, $hashed_password) . "'";
		$sql .= ")";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function update_admin($admin) {
		global $db;

		$errors = validate_admin($admin);
		if (!empty($errors)) {
			return $errors;
		}

		$hashed_password = password_hash($admin['password'], PASSWORD_BCRYPT);

		$sql = "UPDATE admins SET ";
		$sql .= "first_name = '" . db_escape($db, $admin['first_name']) . "', ";
		$sql .= "last_name = '" . db_escape($db, $admin['last_name']) . "', ";
		$sql .= "email = '" . db_escape($db, $admin['email']) . "', ";
		$sql .= "username = '" . db_escape($db, $admin['username']) . "', ";
		$sql .= "hashed_password = '" . db_escape($db, $hashed_password) . "'";
		$sql .= "WHERE id = '" . db_escape($db, $admin['id']) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if ($result) {
			return true;
		} else {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

	function delete_admin($id) {
		global $db;

		$sql = "DELETE FROM admins ";
		$sql .= "WHERE id = '" . db_escape($db, $id) . "' ";
		$sql .= "LIMIT 1";

		$result = mysqli_query($db, $sql);
		if (!$result) {
			echo mysqli_error($db);
			db_disconnect($db);
			exit;
		}
	}

?>
