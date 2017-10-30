<?php  
	include("function.php");

	$get_list_type = addslashes($_GET['get_list_type']);	

	if($get_list_type == 1){
		$receiving = get_open_receiving();
	}else if($get_list_type == 2){
		$receiving = get_close_receiving();
	}

	$result = get_receiving_results($receiving);
	$response['success'] = $result['success'];
	$response['message'] = $result['message'];
	if($result['success'] == 1){
		$response['receiving_session'] = $result['receiving_session'];
	}
		
	$data['data'] = json_encode($response);
	echo json_encode($data);

?>