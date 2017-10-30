<?php  
	include("function.php");	

	$category = get_categories();	
	
	if($category->num_rows == 0){
		$response['success'] = 0;
		$response['message'] = "Failed to retrieve";
	}else{
		$response['category'] = array();
		while($r = $category->fetch_assoc()){
			$branch_categories = get_branch_categories_by_category_id($r['id']);
			if($branch_categories->num_rows != 0){
				$r['branch_categories'] = array();
				while($r_categories = $branch_categories->fetch_assoc()){
					array_push($r['branch_categories'], $r_categories);
				}
			}
			array_push($response['category'], $r);
		}
		$response['success'] = 1;
	}

	$data['data'] = json_encode($response);
	echo json_encode($data);

?>