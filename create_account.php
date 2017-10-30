<?php  
	include("function.php");

	$first_name = addslashes($_POST['first_name']);
	$last_name = addslashes($_POST['last_name']);
	$uname = addslashes($_POST['username']);
	$pword = addslashes($_POST['password']);
	$email = addslashes($_POST['email']);
	$phone_no = addslashes($_POST['phone_no']);

	$is_exist = check_if_username_exist($uname);

	if($is_exist->num_rows == 0){
		$account_id = 	get_account_by_id($first_name,$last_name,$uname,$pword,$email,$phone_no);
		if($account_id){
			$accounts = get_account_by_id($account_id);
			$response['accounts'] = array();
			while($r = $accounts->fetch_assoc()){
				array_push($response['accounts'], $r);
			}
			$response['success'] = 1;
		}else{
			$response['success'] = 0;
			$response['message'] = "Fail Insert ID" . mysqli_error($GLOBALS['db']);
		}
	}else{
		$response['success'] = 0;
		$response['message'] = "Username Already Exists";
	}


	$data['data'] = json_encode($response);
	echo json_encode($data);

?>