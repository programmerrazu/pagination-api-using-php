<?php 
	include_once 'db_config.php';

	$json = file_get_contents('php://input');

	$obj = json_decode($json);

 	/* $file = 'error.txt';
   	$current = file_get_contents($file);
   	$current .= $obj ."\n";
   	file_put_contents($file, $current); */

	$userRole = $obj->userRole;
	$firstName = $obj->firstName;
	$lastName = $obj->lastName;
	$jobCategory = $obj->jobCategory;
	$preferredJobLocation = $obj->preferredJobLocation;
	$m = $obj->m;
	$password = base64_encode($obj->password);
	// $gender= $obj->gender;
	// $age= $obj->age;
	// $nid= $obj->nid;
	// $p_id = rand(10000000, 99999999);
	$datetime = date('Y-m-d H:i:s');
	
	$sql = "select mobile from table where mobile = '$m'";
	$result = mysql_query($sql);
	if(mysql_num_rows($result) > 0) {
		$response['code'] = 202;
		$response['status'] = true;
		$response['message'] = 'Mobile number already exist';
		echo json_encode($response);
	} else {
		$query = "insert into table (user_role, first_name, last_name, job_category, preferred_job_location, mobile, password, date_time) 
		values('$userRole', '$firstName', '$lastName', '$jobCategory', '$preferredJobLocation', '$mobile', '$password', '$datetime')";		
		
		$result = mysql_query($query);
		// $insertid = mysql_insert_id();
 
 		if($result) {	
			$response['code'] = 200;
			$response['status'] = true;
			// $response['insertid'] = $insertid;
			// $response['status'] = 7;
			$response['message'] = 'Thank you for registration with Hospice Bangladesh.';
			echo json_encode($response);
  		} else {
			$response['code'] = 200;
			$response['status'] = false;
			$response['message'] ='Registration failed.';
			echo json_encode($response);
		} 
	}
 ?>