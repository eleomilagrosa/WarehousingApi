<?php  
	include("function.php");

	$uname = addslashes($_POST['username']);
	$pword = addslashes($_POST['password']);
		
	$accounts = login_credentials($uname, $pword);

	if($accounts->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Username or Password does not exist";
	}else{
		$response['accounts'] = array();
		while($r = $accounts->fetch_assoc()){
			array_push($response['accounts'], $r);
		}
		$response['success'] = 1;
		$response['message'] = "Success";
	}
	$data['data'] = json_encode($response);
	echo json_encode($data);

?>