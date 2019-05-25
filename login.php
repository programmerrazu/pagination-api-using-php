<?php 
    include_once 'db_config.php';

    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    $m = $obj->m;
    $p = base64_encode($obj->p);
	
    $sql = "select * from table where m = '$m' and p = '$p'";
    $result = mysql_query($sql);

	if(mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_array($result)) {
		    $arr = array();
		    $arr['id'] = $row['id'];	
		    $arr['userRole'] = $row['user_role'];
      	    $arr['firstName'] = $row['first_name'];
      	    $arr['lastName'] = $row['last_name'];
      	    $arr['jobCategory'] = $row['job_category'];
      	    $arr['preferredJobLocation'] = $row['preferred_job_location'];
      	    $arr['mobile'] = $row['mobile'];
      	    $arr['userStatus'] = $row['status'];
      	    $arr['registrationDate'] = $row['date_time'];
		    $response['data'] = $arr;
	    }
	        $response['code'] = 200;
	        $response['status'] = true;
            $response['message']='Login successfully';   
	        echo json_encode($response);
	} else {
	    $response['code'] = 200;
	    $response['status'] = false;
        $response['message']='Invalid Mobile or Password';   
	    echo json_encode($response);
    }
 ?>