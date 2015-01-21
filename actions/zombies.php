<?php

$records = $db->fetchAllRaw('SELECT ms.score FROM minigamescores as ms 
	LEFT JOIN minigames as m ON m.id = ms.minigameid 
	WHERE m.type = "Zombie" ORDER BY ms.score DESC Limit 50');

echo json_encode(Array(
	'success' => true,
	'data' => $records
));