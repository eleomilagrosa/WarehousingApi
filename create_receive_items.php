<?php  
	include("function.php");

	$barcode = addslashes($_POST['barcode']);
	$desc = addslashes($_POST['desc']);
	$quantity = addslashes($_POST['quantity']);
	$item_id = addslashes($_POST['item_id']);
	$receiving_session_id = addslashes($_POST['receiving_session_id']);
	$user_id = addslashes($_POST['user_id']);
	$notes = addslashes($_POST['notes']);

	$receiving_items_id = create_receive_items($barcode,$desc,$quantity,$item_id,$receiving_session_id,$user_id,$notes);

	if($receiving_session_id){
		$receiving_items = get_receiving_item_by_id($receiving_items_id);
		if($receiving_items->num_rows == 0){
			$response['success'] = 0;
			$response['message'] = "Failed to retrieve id";
		}else{
			$response['receiving_items'] = array();
			while($r = $receiving_items->fetch_assoc()){
				array_push($response['receiving_items'], $r);
			}
			$response['success'] = 1;
		}
	}else{
		$response['success'] = 0;
		$response['message'] = "Fail Insert ID" . mysqli_error($GLOBALS['db']);
	}	

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>