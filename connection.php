<?php

	// $host = 'fusiotec.com';
	// $username = 'sunilman_dev';
	// $password = 'eleojasmil123';
	// $database = 'sunilman_servicecenter';
	// $port = 3306;
	// $check_connection = 'false';

	$host = '192.168.1.21';
	$username = 'admin';
	$password = '21posincbibiza4012006';
	$database = 'warehousing';
	$port = 2121;
	$check_connection = 'false';

	// if(!$_SERVER['REQUEST_METHOD'] === 'POST'){
		// echo "POST NOT EMPTY";
		// $host = $_POST['host'];
		// $username = $_POST['username'];
		// $password = $_POST['password'];
		// $database = $_POST['db_name'];
		// $port = $_POST['port'];
		// $check_connection = 'false';

	// }else{
	// 	// echo "POST EMPTY";
	// }

	if($check_connection == "true")
		if(mysqli_connect_error()){
				echo json_encode(array(false));
			die();
		}else{
				echo json_encode(array(true));
			die();
		}
 ?>
