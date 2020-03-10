<?php 
   
	include_once('connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	$PageName = "cron.php";
	
	 
        $col="*";
        $tablename="mv_user";
    	$result=$db->getuser($col,$tablename);
    	
    	foreach ($result as $row){
    	    
    	    $user_id = $row['mv_user_id'];
    	    $user_type = $row['mv_user_type'];
    	    
    	    if($user_type == 2){
    	        
    	        //get user wallet
    	        $col = "*";
				$tb = "mv_wallet";
				$chkcol = "mv_user_id";
				$user_wallet = $db->where($col,$tb,$chkcol,$user_id);
				
				$user_wallet_amt = $user_wallet[0]['mv_wallet_amt'];
				$user_wallet_pending = $user_wallet[0]['mv_wallet_pending_amt'];
				$user_spend = $user_wallet[0]['mv_spend'];
				$user_total_spend = $user_wallet[0]['mv_total_spend'];
				
				if($user_spend >= 350){
				    
				    $added_user_wallet_amt = $user_wallet_amt + $user_wallet_pending;
				    $user_total_spend = $user_total_spend + $user_spend;
				    
				    $tablename='mv_wallet';
            	    $data='mv_wallet_amt = ? , mv_wallet_pending_amt = ? , mv_spend = ?, mv_total_spend = ? WHERE mv_user_id = ?';
            	    $array=array($added_user_wallet_amt,0,0,$user_total_spend,$user_id);
            	    $result=$db->update($tablename,$data,$array);
				    
				}
				else if($user_spend <= 350){
				     
				    $user_total_spend = $user_total_spend + 0;
				    
				    $tablename='mv_wallet';
            	    $data='mv_wallet_pending_amt = ? , mv_spend = ? , mv_total_spend = ? WHERE mv_user_id = ?';
            	    $array=array(0,0,$user_total_spend,$user_id);
            	    $result=$db->update($tablename,$data,$array);
				}
				
    
    	    }
    	    
    	    
    	}
    	
    // 	foreach ($result as $row){
    // 	$userpoint=$row['mv_user_point'];
    // 	$usertype=$row['mv_user_type'];
    // 	$userid=$row['mv_user_id'];
    // 	if($usertype==2)
    // 	{
    // 	if($userpoint<=99)
    // 	{
    // 	    $tablename='mv_user';
    // 	    $data='mv_user_point = ? , mv_user_status = ?  WHERE mv_user_id = ?';
    // 	    $array=array(0,0,$userid);
    // 	    $result=$db->update($tablename,$data,$array);
    // 	}
    // 	else if ($userpoint>=100)
    // 	{
    // 	 $tablename='mv_user';
    // 	    $data='mv_user_point = ?  WHERE mv_user_id = ?';
    // 	    $array=array(0,$userid);
    // 	    $result=$db->update($tablename,$data,$array);
    // 	}
    	
    // 	else
    // 	{
    // 	    die('Error');
    // 	}
    // 	}
    	
    // 	}
    
       // $col="*";
      //  $tablename="mv_item";
    //	$item=$db->get($col,$tablename,1);
    //	foreach ($item as $row){
  	 //   $item_id=$row['mv_item_id'];
    	    
    //	$tablename='mv_item';
    //  $data='mv_item_status = ? ,mv_user_id = ? WHERE mv_item_id = ?';
     //  $array=array(1,320,$item_id);
     //  $result=$db->update($tablename,$data,$array);
    	    
    //	}
    
    

?>