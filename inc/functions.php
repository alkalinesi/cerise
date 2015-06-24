<?php

function show_response($response_array = array(), $die = 0) {
	
	header('Content-type: application/json');
	
	echo json_encode($response_array);
	
	if ($die) {
		die;
	}
	
}

function generateCSV($fileHandle, $data, $column_titles = true) {

	if (empty($data)) {

		fwrite($fileHandle, 'No data found');

	} else {
	
		if (is_object($data)) {
			
			$data = $data->toArray();
			
		}

		// Put column titles in first row
		if ($column_titles) {

			fputcsv($fileHandle, array_keys($data[0]));

		}

		foreach ($data as $record) {

			fputcsv($fileHandle, $record);

		}

	}

	fclose($fileHandle);

}

function outputCSV($filename, $data, $column_titles = true) {

	$fileHandle = fopen('php://output', 'w');

	ob_start();
	generateCSV($fileHandle, $data, $column_titles);
	$csv_data = ob_get_clean();
	ob_end_clean();

	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="'. $filename .'"');

	echo $csv_data;
	
	die;
	
}

function find_code($code, $mysqli) {
	
	$query = $mysqli->query("SELECT * FROM rsvp_codes WHERE code = '". $mysqli->real_escape_string($code) ."' LIMIT 1");
	
	if ($query->num_rows) {
		
		$code = $query->fetch_array(MYSQLI_ASSOC);
		
		$query->close();
		
/*
		$query = $mysqli->query("SELECT * FROM rsvps WHERE rsvp_code = '". $code['code'] ."'");
		
		if ($query->num_rows) {
		
			$query->close();
			
			return 'redeemed';
			
		}
		
		$query->close();
*/
		
		return $code;
		
	}
	
	$query->close();
	
	return false;
	
}

?>