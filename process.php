<?php
ini_set('display_errors', 'On');
error_reporting(-1);

require_once('inc/inc.php');

if ($mysqli->connect_error) {
	
	$response = array('success' => 'false', 'errors' => ['DB Connect Failed']);
	
	show_response($response, true);
	
}

if (empty($_POST)) {
	
	$response = array('success' => 'false', 'errors' => ['Not Allowed']);
	
	show_response($response, true);
	
}

$fields = array(
	'first_name' => 'Please provide your first name',
	'last_name' => 'Please provide your last name',
	'email_address' => 'Please provide your email address',
	'guest_first_name' => 'Please provide your guest\'s first name',
	'guest_last_name' => 'Please provide your guest\'s last name',
	//'questions' => ''
);

$field_values = array();

$errors = array();

foreach ($fields as $field => $error) {
	
	if ( ! isset($_POST[$field])) {
		continue;
	}
	
	if (empty($_POST[$field]) && !empty($error)) {
		$errors[$field] = $error;
	}
	
	$field_values[$field] = $_POST[$field];
	
}

if (isset($field_values['email_address'])) {
	
	if (filter_var($field_values['email_address'], FILTER_VALIDATE_EMAIL) === false) {
		
		$errors['email_address'] = 'Please provide a valid email adddress';
		
	}
	
}

if (empty($errors)) {
	
	$created = date('Y-m-d H:i:s');
	
	$query = 'INSERT INTO rsvps SET ';
	
	foreach ($field_values as $field => $value) {
		
		$query .= $field .' = \''. $mysqli->real_escape_string($value) . '\', ';
		
	}
	
	$query .= 'created = \''. $created .'\'';
	
	$mysqli->query($query);
	
	$response = array('success' => 'true', 'errors' => []);
	
	//$submission_address = 'rsvpchicago@virginhotels.com';
	$submission_address = 'dylan@1trickpony.com';
	
	$mail_headers  = 'MIME-Version: 1.0' . "\r\n";
	$mail_headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$mail_headers .= 'From: Virgin Hotels <no-reply@virginhotels.com>' . "\r\n";
	
	$message = <<<EOD
<!DOCTYPE html>
<html>
	<head>
		<title></title>
	</head>
	<body>
		<p>{$field_values['first_name']} {$field_values['last_name']} has submitted their RSVP for the Grand Opening of Cerise.</p>
		<br />
		<strong>First Name:</strong> {$field_values['first_name']}<br />
		<strong>Last Name:</strong> {$field_values['last_name']}<br />
		<strong>Email Address:</strong> {$field_values['email_address']}<br />
EOD;

	if (isset($field_values['guest_first_name']) && isset($field_values['guest_last_name'])) {
		
		$message .= '<strong>Guest First Name:</strong> ' . $field_values['guest_first_name'] . '<br />';
		$message .= '<strong>Guest Last Name:</strong> ' . $field_values['guest_last_name'] . '<br />';
		
	}
	
/*
	if (isset($field_values['questions']) && ! empty($field_values['questions'])) {
		
		$message .= '<strong>Questions:</strong><br />' . $field_values['questions'];
		
	}
*/

	$message .= '</body></html>';
	
	$subject = 'Cerise RSVP from '. $field_values['first_name'] .' '. $field_values['last_name'];
	
	//mail($submission_address, $subject, $message, $mail_headers, '-f no-reply@virginhotels.com');
	
} else {
	
	$response = array('success' => 'false', 'errors' => $errors);
	
}

show_response($response);

$mysqli->close();

?>