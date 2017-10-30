<?php  
	include("function.php");

	$user_id = addslashes($_POST['user_id']);

	$receiving_session_id = create_receive_session($user_id);

	if($receiving_session_id){
		$receiving_session = get_receiving_session_by_id($receiving_session_id);
		$result = get_receiving_results($receiving_session);
		$response['success'] = $result['success'];
		$response['message'] = $result['message'];
		if($result['success'] == 1){
			$response['receiving_session'] = $result['receiving_session'];
		}
	}else{
		$response['success'] = 0;
		$response['message'] = "Fail Insert ID" . mysqli_error($GLOBALS['db']);
	}	

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>