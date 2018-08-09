<?php
function hash_text($text) {
	$options = [
		'cost' => 12,
	];
	$result = password_hash($text, PASSWORD_BCRYPT, $options);

	return $result;
}

echo hash_text('admin_ubait');