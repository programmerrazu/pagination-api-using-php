<?php 
    include_once 'db_config.php';

    $sql = "select * from  table order by id DESC limit 9"; 

    $result = mysql_query($sql);

    if(!empty($result)) {
	
    	if(mysql_num_rows($result)) {
    	    
    	    $response['code'] = 200;
    	    $response['status'] = true;
	        $response['message']="All events found";
    		$response['event_list'] = array();
    		
    	    while($row=mysql_fetch_array($result)) {
    	  
                $event = array();
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
                $event['sdateyear'] = $sdateyear;
                $event['etime'] = $row['etime'];
                $event['eam'] = $row['eam'];
                $event['title'] = $row['title'];
                $event['venue'] = $row['venue'];
    	
                $sqlevent = mysql_query("select * from  table where id = '$id'");
                while ($rows_tckt = mysql_fetch_array($sqlevent)) {
                    $st = $rows_tckt['paidticket'];
                    if($st == 'Free' || $st == NULL) {
                        $event['fee'] = 'Free';	  
                    } else {
                        $event['fee'] = 'TK.'.$rows_tckt['paidticket'].' TK.'.$rows_tckt['paidprice'];
                    }
                }
    		    array_push($response['event_list'], $event);
    	    }
    	    echo json_encode($response);
        } else {
            $response['code'] = 400;
    	    $response['status'] = false;
            $response['message']="No events found";
            echo json_encode($response);
        }  
    }
 ?>