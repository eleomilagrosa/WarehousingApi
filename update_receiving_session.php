<?php  
	include("function.php");

	$id = addslashes($_POST['id']);
	$station_id = addslashes($_POST['station_id']);
	$ref_no = addslashes($_POST['ref_no']);
		
	update_receiving_session($id,$station_id,$ref_no);

	if(mysqli_affected_rows($GLOBALS['db']) > 0 ){
		$receiving_session = get_receiving_session_by_id($id);
		$result = get_receiving_results($receiving_session);
		$response['success'] = $result['success'];
		$response['message'] = $result['message'];
		if($result['success'] == 1){
			$response['receiving_session'] = $result['receiving_session'];
		}
	}else{
		$response['success'] = 0;	
		$response['message'] = "No Changes";	
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>