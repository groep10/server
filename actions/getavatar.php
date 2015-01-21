<?php
	$user = new User();
	if(!$user->isAuthed()) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Missing or invalid authorization'
		));
		return;
	}

	$id = isset($_GET['id']) ? $_GET['id'] : $user->user['id'];
	$id = (int) $id;

	$result = null;
	if(!file_exists('./avatars/' . $id . '.png')) {
		$result = file_get_contents('./avatars/default.png');
	} else {
		$result = file_get_contents('./avatars/' . $id . '.png');
	}

	if(!isset($_GET['raw'])) {
		$result = base64_encode($result);
	} else {
		header('Content-type:image/png');
	}

	echo $result;
