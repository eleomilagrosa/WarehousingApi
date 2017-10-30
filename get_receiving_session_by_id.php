<?php  
	include("function.php");

	$receiving_session_id = addslashes($_GET['receiving_session_id']);
	
	$receiving_session = get_receiving_session_by_id($receiving_session_id);
	$result = get_receiving_results($receiving_session);
	$response['success'] = $result['success'];
	$response['message'] = $result['message'];
	if($result['success'] == 1){
		$response['receiving_session'] = $result['receiving_session'];
	}


	$data['data'] = json_encode($response);
	echo json_encode($data);

?>