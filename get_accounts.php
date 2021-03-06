<?php  
	include("function.php");
	
	$get_list_type = addslashes($_GET['get_list_type']);		

	if($get_list_type == 1){
		$accounts = get_accounts($_GET['name'],$_GET['date'],$_GET['direction']);
	}else if($get_list_type == 2){
		$accounts = get_accounts_to_be_approved($_GET['name'],$_GET['date'],$_GET['direction']);
	}else if($get_list_type == 3){
		$accounts = get_admins($_GET['name'],$_GET['date'],$_GET['direction']);
	}
	
	if($accounts->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['accounts'] = array();
		while($r = $accounts->fetch_assoc()){
			array_push($response['accounts'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>