<?php
	$user = new User();
	if(!$user->isAuthed()) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Missing or invalid authorization'
		));
		return;
	}

	$name = $_REQUEST['name'];

	$db->insert("games", Array(
		"ownerid" => $user->user['id'],
		"name" => $name
	));

	$gameid = $db->lastInsertId();

	echo json_encode(Array(
		'success' => true,
		'data' => Array(
			'id' => $gameid
		)
	));