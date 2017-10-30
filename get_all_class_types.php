<?php  
	include("function.php");	

	$class_types = get_all_class_types();	
	
	if($class_types->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['class_types'] = array();
		while($r = $class_types->fetch_assoc()){
			array_push($response['class_types'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>