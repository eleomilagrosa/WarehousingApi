<?php  
	include("function.php");	
		
	$meta_data = addslashes($_POST['meta_data']);
	$meta_data_id = addslashes($_POST['meta_data_id']);
	$label = "";

	$basepath = 'images/'. $meta_data. $meta_data_id . '/';
	$file_path =  $basepath . basename($_FILES['uploaded_file']['name']);

	if (!file_exists($basepath)) {
    	mkdir($basepath, 0777, true);
	}

    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
    	$image_id = add_image($meta_data,$meta_data_id,$label,$file_path);
		if($image_id){
			$images = get_image_by_id($image_id);
			if($images->num_rows == 0){
				$response['success'] = 0;
				$response['message'] = "Failed to retrieve id";
			}else{
				$response['images'] = array();
				while($r = $images->fetch_assoc()){
					array_push($response['images'], $r);
				}
				$response['success'] = 1;
			}
		}else{
			$response['success'] = 0;
			$response['message'] = "Fail Insert ID" . mysqli_error($GLOBALS['db']);
		}
    } else{
		$response['success'] = 0;
		$response['message'] = "Failed To Upload" . mysqli_error($GLOBALS['db']);
    }

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>