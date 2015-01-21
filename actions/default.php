<?php
	$user = new User();
	echo json_encode(Array(
		'success' => true,
		'data' => Array(
			'authed' => $user->isAuthed()
		)
	));