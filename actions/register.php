<?php
	$username = $_POST['username'];
	$password = $_POST['password'];


	$doesMatch = preg_match(User::email_regex, $username, $matches);
	if(!$doesMatch) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Username is invalid'
		));
		return;
	}


	$row = $db->fetchRow('users', '*', 'username = ?', Array($username));
	if($row != false) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Username is taken'
		));
		return;
	}

	$salt = User::salt();
	$db->insert('users', Array(
		'displayname' => $matches[1],
		'username' => $username,
		'password' => User::hash($password, $salt),
		'salt' => $salt,
		'config' => json_encode(Array()),
		'stats' => json_encode(Array())
	));

	echo json_encode(Array(
		'success' => true,
		'error' => 'Registration is successfull'
	));