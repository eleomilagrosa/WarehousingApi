<?php  
	include("function.php");
	$id = addslashes($_POST['id']);
		
	delete_account($id);

	if(mysqli_affected_rows($GLOBALS['db']) > 0 ){
		$accounts = get_account_by_id($id);
		$response['accounts'] = array();
		while($r = $accounts->fetch_assoc()){
			array_push($response['accounts'], $r);
		}
		$response['success'] = 1;
	}else{
		$response['success'] = 0;		
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>