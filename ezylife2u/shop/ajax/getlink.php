<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $user1 = $db->where('*','mv_user','mv_user_id',$id);
    $user1= $user1[0];
    
   
?>

    <div class="modal-header">
    
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    		
    		<h4 class="modal-title">Copy this link</h4>
    	</div>
    	<div class="modal-body">
		
    	
        <?php 
        
            $col = "*";
        	$tb = "mv_default";
        	$opt = 1;
        	$default = $db->get($col,$tb,$opt);
        	$default = $default[0];
        	
        	// get maximum downline
            $max_downline = $default['mv_default_max_ref'];
            
            
            // check number of user's downline
        	$col = "*";
        	$tb = "mv_user";
        	$chkcol = "mv_user_referral";
        	$opt = $user1['mv_user_id'];
    
            $result = $db->where($col,$tb,$chkcol,$opt);
            
            if(count($result) < $max_downline){
            
                //if downline less then max_downline

                //create code
                $userid = $user1['mv_user_id'];
                
                $key = 'mumuls1314';
    			$iv = mcrypt_create_iv(
    			mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
    			MCRYPT_DEV_URANDOM
    			);
    			
    			$userid = base64_encode(
    			$iv.
    			mcrypt_encrypt(
    			MCRYPT_RIJNDAEL_128,
    			hash('sha256', $key, true),
    			$userid,
    			MCRYPT_MODE_CBC,
    			$iv
    			)
    			);
    			
    			$userid = str_replace("+", "_", $userid);
    			
    			
    			echo "<a href=http://ezylife2u.com/shop/register.php?p=$userid >http://ezylife2u.com/shop/register.php?p=$userid</a>";
                
        	
            }else{
                
                $check_ref_status = false;
                
                echo "Number of this user's downlie is FULL, please choose other user.";
            }
        
            


        ?>
        
        
        
    		
    	</div>
    	<div class="modal-footer">
    		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    	</div>

    	