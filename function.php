<?php
	require_once 'connection.php';

	$GLOBALS['db'] = mysqli_connect($GLOBALS['host'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database'],$GLOBALS['port']);
	$GLOBALS['db']->query("SET NAMES 'UTF8'");

	// $id = "2";
	// $secret = "3X3dxxH7tLs5ZcP3dIb18U0NQaCAd9tbBc80XANz";
	
	$id = $_SERVER['HTTP_ID'];
	$secret = $_SERVER['HTTP_SECRET'];

	$client = mysqli_query($GLOBALS['db'],"Select * from oauth_clients where id = $id and secret = '$secret'");
	if($client->num_rows == 0){ 
	    header("HTTP/1.1 401 Unauthorized" . "Select * from oauth_clients where id = $id and secret = '$secret'");
		exit;
	}

	function check_if_username_exist($uname){
		return mysqli_query($GLOBALS['db'],"Select * from accounts where username = '$uname'");
	}

	function create_account($first_name,$last_name,$username,$password,$email,$phone_no){
		$result = mysqli_query($GLOBALS['db'],"insert into accounts (`first_name`,`last_name`,`username`,`password`,`email`,`phone_no`,`account_type_id`,`date_created`) values ('$first_name','$last_name','$username',md5('$password'),'$email','$phone_no','1',now())");
		if($result){
			return mysqli_insert_id($GLOBALS['db']);
		}else{
			return $result;
		}
	}

	function get_account_by_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from accounts where id = $id");
	}
	
	function update_account($id,$first_name,$last_name,$email,$phone_no){		
		mysqli_query($GLOBALS['db'],"update accounts set first_name = '$first_name',last_name = '$last_name',email = '$email',phone_no = '$phone_no' where id = $id");
	}
	function delete_account($id){
		mysqli_query($GLOBALS['db'],"update accounts set is_deleted = 1 where id = $id");
	}
	function update_account_status_id($id,$account_type_id){
		mysqli_query($GLOBALS['db'],"update accounts set account_type_id = '$account_type_id' where id = $id");
	}


	function login_credentials($username, $password){
		return mysqli_query($GLOBALS['db'],"Select * from accounts where username = '$username' and password = md5('$password') and is_deleted = 0");
	}

	function change_password($id,$password){
 		mysqli_query($GLOBALS['db'],"update accounts set `password` = md5('$password') where id = $id");
	}


	function create_receive_session($user_id){
		$result = mysqli_query($GLOBALS['db'],"insert into receiving_session (`user_id`,`receive_no`,`date_opened`) values ('$user_id',". date("YmdHis") . ",now())");
		if($result){
			return mysqli_insert_id($GLOBALS['db']);
		}else{
			return $result;
		}
	}
	function close_receive_session($id){
		mysqli_query($GLOBALS['db'],"update receiving_session set date_closed = now() where id = $id");
	}
	function get_receiving_session_by_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from receiving_session where id = $id");
	}

	function create_receive_items($barcode,$desc,$quantity,$item_id,$receiving_session_id,$user_id,$notes){
		$result = mysqli_query($GLOBALS['db'],"insert into receiving_items (`barcode`,`desc`,`quantity`,`class_type_id`,`item_id`,`receiving_session_id`,`date_created`,`user_id`,`notes`) values ('$barcode','$desc','$quantity','$item_id','$receiving_session_id',now(),'$user_id','$notes')");
		if($result){
			return mysqli_insert_id($GLOBALS['db']);
		}else{
			return $result;
		}
	}
	function get_receiving_item_by_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from receiving_items where id = $id");
	}
	function get_stations($station_name){
		return mysqli_query($GLOBALS['db'],"Select * from stations where station_name like '%$station_name%'");
	}

	function create_station($station_name,$station_prefix,$station_address,$station_number,$station_description){
		$query = "insert into stations(`station_name`,`station_prefix`,`station_address`,`station_number`,`station_description`,`date_created`) values('$station_name','$station_prefix','$station_address','$station_number','$station_description',now())";
		$result = mysqli_query($GLOBALS['db'],$query);
		if($result){
			return mysqli_insert_id($GLOBALS['db']);
		}else{
			return $result;
		}
	}
	function update_station($id,$station_name,$station_prefix,$station_address,$station_number,$station_description){
		mysqli_query($GLOBALS['db'],"update stations set station_name = '$station_name',station_prefix = '$station_prefix',station_address = '$station_address',station_number = '$station_number',station_description = '$station_description' where id = $id");
	}
	function delete_station($id){
		 mysqli_query($GLOBALS['db'],"update stations set is_deleted = 1 where id = $id");
	}
	function get_station_by_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from stations where id = $id");
	}

	function get_accounts_to_be_approved($name,$date,$direction){
		if($direction == 1){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NULL and (first_name like '%$name%' or last_name like '%$name%') and date_modified <= '$date' ORDER BY date_modified DESC limit 10");
		}else if($direction == 2){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NULL and (first_name like '%$name%' or last_name like '%$name%') and date_modified >= '$date' ORDER BY date_modified DESC");
		}else if($direction == 0){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NULL and (first_name like '%$name%' or last_name like '%$name%') ORDER BY date_modified DESC limit 10");
		}
	}

	function get_accounts($name,$date,$direction){
		if($direction == 1){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 1 and (first_name like '%$name%' or last_name like '%$name%') and date_modified <= '$date' ORDER BY date_modified DESC limit 10");
		}else if($direction == 2){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 1 and (first_name like '%$name%' or last_name like '%$name%') and date_modified >= '$date' ORDER BY date_modified DESC");
		}else if($direction == 0){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 1 and (first_name like '%$name%' or last_name like '%$name%') ORDER BY date_modified DESC limit 10");
		}
	}
	function get_admins($name,$date,$direction){
		if($direction == 1){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 2 and (first_name like '%$name%' or last_name like '%$name%') and date_modified <= '$date' ORDER BY date_modified DESC limit 10");
		}else if($direction == 2){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 2 and (first_name like '%$name%' or last_name like '%$name%') and date_modified >= '$date' ORDER BY date_modified DESC");
		}else if($direction == 0){
			return mysqli_query($GLOBALS['db'],"Select * from accounts where date_approved IS NOT NULL and account_type_id = 2 and (first_name like '%$name%' or last_name like '%$name%') ORDER BY date_modified DESC limit 10");
		}
	}

	function get_open_receiving(){
		return mysqli_query($GLOBALS['db'],"Select * from receiving_session where date_closed is null");
	}
	function get_close_receiving(){
		return mysqli_query($GLOBALS['db'],"Select * from receiving_session where date_closed is not null");
	}

	function get_receiving_items_by_session_id($receiving_session_id){
		return mysqli_query($GLOBALS['db'],"Select * from receiving_items where receiving_session_id = $receiving_session_id");
	}
	function get_receiving_results($receiving_session){
		if($receiving_session->num_rows == 0){
			$response['success'] = 0;
			$response['message'] = "Failed to retrieve id";
		}else{
			$response['receiving_session'] = array();
			while($r = $receiving_session->fetch_assoc()){
				$receiving_items = get_receiving_items_by_session_id($r['id']);
				if($receiving_items->num_rows != 0){
					$r['receiving_items'] = array();
					while($items_per_session = $receiving_items->fetch_assoc()){
						array_push($r['receiving_items'], $items_per_session);
					}
				}
				$images = get_images("receiving_session",$r['id']);
				if($images->num_rows != 0){
					$r['images'] = array();
					while($r_images = $images->fetch_assoc()){
						array_push($r['images'], $r_images);
					}
				}
				array_push($response['receiving_session'], $r);
			}
			$response['message'] = "Success";
			$response['success'] = 1;
		}
		return $response;
	}
	function get_images($meta_data,$id){
		return mysqli_query($GLOBALS['db'],"Select * from images where meta_data = '$meta_data' and meta_data_id = $id");
	}
	function update_receiving_session($id,$station_id,$ref_no){		
		mysqli_query($GLOBALS['db'],"update receiving_session set branch_id = '$station_id', ref_no = '$ref_no' where id = $id");
	}

	function get_all_items(){
		return mysqli_query($GLOBALS['db'],"Select * from items");
	}
	function get_all_locations(){
		return mysqli_query($GLOBALS['db'],"Select * from locations");
	}
	function get_all_class_types(){
		return mysqli_query($GLOBALS['db'],"Select * from class_types");
	}

	function get_categories(){
		return mysqli_query($GLOBALS['db'],"Select * from `category`");
	}
	function get_branch_categories_by_category_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from `branch_categories` where category_id = $id");
	}
	function add_image($meta_data,$meta_data_id,$label,$image){
		$result = mysqli_query($GLOBALS['db'],"insert into images (`meta_data`,`meta_data_id`,`label`,`image`) values ('$meta_data','$meta_data_id','$label','$image')");
		if($result){
			return mysqli_insert_id($GLOBALS['db']);
		}else{
			return $result;
		}
	}

	function get_image_by_id($id){
		return mysqli_query($GLOBALS['db'],"Select * from images where id = $id");
	}
?>