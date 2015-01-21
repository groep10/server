<?php

$records = $db->fetchAllRaw('SELECT type, count(type) as count from minigames group by type');

echo json_encode(Array(
	'success' => true,
	'data' => $records
));