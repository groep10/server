<?php
	$username = $_POST['username'];
	$password = $_POST['password'];

	$row = $db->fetchRow('users', '*', 'username = ?', Array($username));
	if($row == false) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Invalid username or password'
		));
		return;
	}

	if($row['password'] != User::hash($password, $row['salt'])) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Invalid username or password'
		));
		return;
	}

	$sessionid = User::sessionid($row['username'], $row['password']);

	// TODO: deprecate old sessions.
	// $db->delete('sessions', 'userid = ?', Array($row['id']));
	$db->insert('sessions', Array(
		'userid' => $row['id'],
		'sessionid' => $sessionid,
		'settings' => json_encode(Array())
	));
	// Security
	unset($row['password']);
	unset($row['salt']);
	echo json_encode(Array(
		'success' => true,
		'data' => Array(
			'token' => $sessionid,
			'user' => $row
		)
	));