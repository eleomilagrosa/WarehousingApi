<?php  
	include("function.php");	

	$items = get_all_items();	
	
	if($items->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['items'] = array();
		while($r = $items->fetch_assoc()){
			array_push($response['items'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>