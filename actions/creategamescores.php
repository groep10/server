<?php
	$user = new User();
	if(!$user->isAuthed()) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Missing or invalid authorization'
		));
		return;
	}

	$minigameid = (int) $_REQUEST['gameid'];

	$data = json_decode($_REQUEST['data'], true);

	$error->log('create gamescores ' . count($data) . ' ' . $data);

	for($i = 0; $i < count($data); $i += 1) {
		$db->insert('gamescores', Array(
			'gameid' => $minigameid,
			'ownerid' => $data[$i]["id"],
			'score' => $data[$i]["score"]
		));
		$error->log('create gamescore ' . json_encode($data[$i]));

	}

	echo json_encode(Array(
		'success' => true
	));