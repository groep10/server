<?php
	$user = new User();
	if(!$user->isAuthed()) {
		echo json_encode(Array(
			'success' => false,
			'error' => 'Missing or invalid authorization'
		));
		return;
	}

	$max = 1024 * 1024 * 5; // 5 MB
	$id = $user->user['id'];

	try {
    
    if (
        !isset($_FILES['avatar']['error']) ||
        is_array($_FILES['avatar']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    switch ($_FILES['avatar']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    if ($_FILES['avatar']['size'] > 1000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['avatar']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }

    $image = null;
    switch($ext) {
    	case 'jpg':
			$image = imagecreatefromjpeg($_FILES['avatar']['tmp_name']);
	    	break;
    	case 'gif':	
			$image = imagecreatefromgif($_FILES['avatar']['tmp_name']);
    		break;
		case 'png':
			$image = imagecreatefrompng($_FILES['avatar']['tmp_name']);
			break;	
    }
    list($width_orig, $height_orig) = getimagesize($_FILES['avatar']['tmp_name']);

    $image_p = imagecreatetruecolor(128, 128);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, 128, 128, $width_orig, $height_orig);
    imagedestroy($image);
	// imagepng($image_p, './avatars/' . $id . '.png');
	// touch('./avatars/' . $id . '.png');
    if (!@imagepng($image_p, './avatars/' . $id . '.png')) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
	imagedestroy($image_p);

	echo json_encode(Array(
		'success' => true
	));
} catch (RuntimeException $e) {
	echo json_encode(Array(
		'success' => false,
		'error' => $e->getMessage()
	));
}