<?php

$data = Array();

$data[] = "Highest zombie score:";
$records = $db->fetchAllRaw('SELECT ms.score, u.displayname FROM minigamescores as ms 
	LEFT JOIN minigames as m ON m.id = ms.minigameid 
	LEFT JOIN users as u ON u.id = ms.ownerid 
	WHERE m.type = "Zombie" ORDER BY ms.score DESC Limit 5');
foreach($records as $record) {
	$data[] = $record['displayname'] . ': ' . $record['score'];
}


$data[] = "Most Race to the Top wins:";
$records = $db->fetchAllRaw('SELECT u.displayname, count(ms.id) as score FROM minigamescores as ms 
	LEFT JOIN minigames as m ON m.id = ms.minigameid 
	LEFT JOIN users as u ON u.id = ms.ownerid 
	WHERE m.type = "TopRace" AND ms.score = 99 
	GROUP BY ms.ownerid
	ORDER BY count(ms.id) DESC Limit 5');
foreach($records as $record) {
	$data[] = $record['displayname'] . ': ' . $record['score'];
}

$data[] = "Most Tron wins:";
$records = $db->fetchAllRaw('SELECT u.displayname, count(ms.id) as score FROM minigamescores as ms 
	LEFT JOIN minigames as m ON m.id = ms.minigameid 
	LEFT JOIN users as u ON u.id = ms.ownerid 
	WHERE m.type = "Tron" AND ms.score = 1 
	GROUP BY ms.ownerid
	ORDER BY count(ms.id) DESC Limit 5');
foreach($records as $record) {
	$data[] = $record['displayname'] . ': ' . $record['score'];
}

$data[] = "Most Race wins:";
$records = $db->fetchAllRaw('SELECT u.displayname, count(ms.id) as score FROM minigamescores as ms 
	LEFT JOIN minigames as m ON m.id = ms.minigameid 
	LEFT JOIN users as u ON u.id = ms.ownerid 
	WHERE m.type = "Race" AND ms.score >= 10 
	GROUP BY ms.ownerid
	ORDER BY count(ms.id) DESC Limit 5');
foreach($records as $record) {
	$data[] = $record['displayname'] . ': ' . $record['score'];
}


echo json_encode(Array(
	'success' => true,
	'data' => $data
));