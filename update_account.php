<?php  
	include("function.php");

	$id = addslashes($_POST['id']);
	$first_name = addslashes($_POST['first_name']);
	$last_name = addslashes($_POST['last_name']);
	$email = addslashes($_POST['email']);
	$phone_no = addslashes($_POST['phone_no']);
		
	update_account($id,$first_name,$last_name,$email,$phone_no);

	if(mysqli_affected_rows($GLOBALS['db']) > 0 ){
		$accounts = get_account_by_id($id);
		$response['accounts'] = array();
		while($r = $accounts->fetch_assoc()){
			array_push($response['accounts'], $r);
		}
		$response['success'] = 1;
	}else{
		$response['success'] = 0;	
		$response['message'] = "No Changes";	
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>