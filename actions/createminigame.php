<?php
	$user = new User();
	if(!$user->isAuthed()) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Missing or invalid authorization'
		));
		return;
	}

	$type = $_REQUEST['type'];
	$gameid = (int) $_REQUEST['gameid'];

	$db->insert("minigames", Array(
		"type" => $type,
		"gameid" => $gameid
	));

	$minigameid = $db->lastInsertId();

	echo json_encode(Array(
		'success' => true,
		'data' => Array(
			'id' => $minigameid
		)
	));