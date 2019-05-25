<?php 
    include_once 'db_config.php';

	$page = $_GET['page'];	
	$row_per_page = $_GET['row_per_page'];	
	 
	if($page && $row_per_page) {
	    
    	$total = mysql_num_rows(mysql_query("SELECT * from table"));
    	$page_limit = $total/$row_per_page; 
    
    	if($page_limit) {
    	
    		$start = ($page * $row_per_page) - $row_per_page; 
    		$sql = "SELECT * from table order by id DESC limit $start, $row_per_page";
    		$result = mysql_query($sql);
     
            if(mysql_num_rows($result)) {
    		    
    		    $response['code'] = 200;
    		    $response['status'] = true;
	            $response['message'] = "Ge All Event";
	            $response['event_list'] = array();
	            
                while($row = mysql_fetch_array($result)) {
                    
                        $id = $row['event_id'];
                        $event['event_id'] = (int)$row['event_id'];
                        $event['event_image'] = $row['event_image'];
                        
                        $sdate = $row['sdate'];
                        $sdate1 = date_create($sdate);
                        $sdate2 = date_format($sdate1,"d F ");
                        $sdateyear = date_format($sdate1,"Y");	
                        $event['stime'] = $row['stime'];
                    
                        $event['sam'] = $row['sam'];
                        $edate = $row['edate'];
                        $edate1 = date_create($edate);
                        $edate2 = date_format($edate1,"d F ");                
                        $event['sdate2'] = $sdate2;
                        $event['edate2'] = $edate2;
                        $event['sdateyear']=$sdateyear;
                        $event['etime'] = $row['etime'];
                        $event['eam'] = $row['eam'];
                        $event['title'] = $row['title'];
                        $event['venue'] = $row['venue'];
                        
                        $sqlevent = mysql_query("select * from  table where event_id='$id'");
	                    while ($rows_tckt = mysql_fetch_array($sqlevent)) {
	                        $st = $rows_tckt['paidticket'];
	                        if($st=='Free' || $st==NULL) {
		                        $event['fee'] = 'Free';	  
		                    } else {
	                            $event['fee'] =  'TK.'.$rows_tckt['paidticket'].'  TK.'.$rows_tckt['paidprice'].' |  ';
		                    }
	                    }
                        array_push($response['event_list'],$event);
    		    }
    			echo json_encode($response);
            } else {
                $response['code'] = 201;
    		    $response['status'] = false;
	            $response['message'] = "No event found";
    			echo json_encode($response);
            } 
    	} else {
            $response['code'] = 202;
            $response['status'] = false;
            $response['message'] = "No more event are availabe...";
            echo json_encode($response);
        }
	} else {
        $response['code'] = 400;
        $response['status'] = false;
        $response['message'] = "Invalid Request";
        echo json_encode($response);
    }
 ?>