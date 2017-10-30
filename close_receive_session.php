<?php  
	include("function.php");

	$id = addslashes($_POST['id']);
		
	close_receive_session($id);

	if(mysqli_affected_rows($GLOBALS['db']) > 0 ){
		$receiving_session = get_receiving_session_by_id($id);
		$response['receiving_session'] = array();
		while($r = $receiving_session->fetch_assoc()){
			array_push($response['receiving_session'], $r);
		}
		$response['success'] = 1;
	}else{
		$response['success'] = 0;		
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>