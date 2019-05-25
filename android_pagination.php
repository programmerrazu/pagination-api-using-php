<?php 
    include_once 'db_config.php';

	$page = $_GET['page'];	
	$row_per_page = $_GET['row_per_page'];	
	$response = array();
	 
	if($page && $row_per_page) {
	    
    	$total = mysql_num_rows(mysql_query("SELECT * from table"));
    	$page_limit = $total/$row_per_page; 
    
    	// if($page <= $page_limit) {
    	if($page_limit) {
    	
    		// $start = ($page - 1) * $row_per_page; 
    		$start = ($page * $row_per_page) - $row_per_page; 
    		$sql = "SELECT * from table order by id DESC limit $start, $row_per_page";
    		$result = mysql_query($sql);
     
            if(mysql_num_rows($result)) {
                
                $event = array();
                array_push($response, array(
    		        'code' => 200,
    		        'status' => true,
    		        'message' => 'Ge All Event'
    		        ));
    		        
                while($row = mysql_fetch_array($result)) {
                    
                        $id = $row['event_id'];
                        $sqlevent = mysql_query("select * from  table where event_id='$id'");
                        while ($rows_tckt = mysql_fetch_array($sqlevent)){
                            $st = $rows_tckt['paidticket'];
                            if($st == 'Free' || $st == NULL) {
                               $fee = 'Free';	  
                            } else {
                                $fee =  'TK.'.$rows_tckt['paidticket'].'  TK.'.$rows_tckt['paidprice'];
                            }
                        }
                        
                        //$event['event_id'] = $row['event_id'];
                        //$event['event_image'] = $row['event_image'];
                        
                        $sdate = $row['sdate'];
                        $sdate1 = date_create($sdate);
                        $sdate2 = date_format($sdate1,"d F ");
                        $sdateyear = date_format($sdate1,"Y");	
                        // $event['stime'] = $row['stime'];
                    
                        // $event['sam'] = $row['sam'];
                        $edate = $row['edate'];
                        $edate1 = date_create($edate);
                        $edate2 = date_format($edate1,"d F ");                
                        // $event['sdate2'] = $sdate2;
                        // $event['edate2'] = $edate2;
                        // $event['sdateyear']=$sdateyear;
                        // $event['etime'] = $row['etime'];
                        // $event['eam'] = $row['eam'];
                        // $event['title'] = $row['title'];
                        // $event['venue'] = $row['venue'];
                        
                         array_push($event, array(
                             'event_id' => $row['event_id'], 
                             'event_image' => $row['event_image'],
                             'stime' => $row['stime'],
                             'sam' => $row['sam'],
                             'sdate2' => $sdate2,
                             'edate2' => $edate2,
                             'sdateyear' => $sdateyear,
                             'etime' => $row['etime'],
                             'eam' => $row['eam'],
                             'title' => $row['title'],
                             'venue' => $row['venue'],
                             'fee' =>  $fee
                             ));
    		    }
    		    array_push($response, array('data' => $event));
    			echo json_encode($response);
            } else {
                 array_push($response, array(
    		        'code' => 200,
    		        'status' => false,
    		        'message' => 'No events found'
    		        ));
    			echo json_encode($response);
            } 
    	} else {
    	     array_push($response, array(
    		        'code' => 202,
    		        'status' => false,
    		        'message' => 'No event are availabe...'
    		        ));
		    echo json_encode($response);
        }
	} else {
	     array_push($response, array(
    		        'code' => 400,
    		        'status' => false,
    		        'message' => 'Invalid Request'
    		        ));
		echo json_encode($response);
    }
 ?>