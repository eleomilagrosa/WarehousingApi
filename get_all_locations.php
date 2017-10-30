<?php  
	include("function.php");	

	$locations = get_all_locations();	
	
	if($locations->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['locations'] = array();
		while($r = $locations->fetch_assoc()){
			array_push($response['locations'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>