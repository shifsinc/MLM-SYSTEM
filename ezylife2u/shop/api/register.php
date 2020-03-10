<?php
require_once('../connection/PDO_db_function.php');
$db = new DB_FUNCTIONS();

if(isset($_REQUEST['type'])||isset($_REQUEST['success'])){
	$type = $_REQUEST['type'];
	$success = $_REQUEST['success'];

    $postedToken = filter_input(INPUT_POST, 'token');
    if(!empty($postedToken)){
         $col = "*";
          $default_tb = "mv_default";
          $opt = 1;
          $default = $db->get($col,$default_tb,$opt);
          $default = $default[0];
          
        $time=date('Y-m-d H:i:s');   
    	if(isTokenValid($postedToken)){
    	if($type=="userregister"){
					if($success=="1"){
						if(isset($_POST['btnsubmituser'])){
							$username = $_POST['uname'];
							$username = preg_replace('/\s+/', '', $username);
							$password = $_POST['password'];
							$cpassword = $_POST['password'];
							$userfname = $_POST['fname'];
							$useremail = $_POST['email'];
							$usercontact = $_POST['phone'];
							$userupline = $_POST['upline'];
							$useric = $_POST['ic'];
							$userpass = $_POST['passport'];
							$b_name = $_POST['bname'];
							$b_ic = $_POST['bic'];
							$b_num = $_POST['bnum'];
							
							
							//password encrytion
							$key = 'mumuls1314';
							$iv = mcrypt_create_iv(
							mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
							MCRYPT_DEV_URANDOM
							);
							
							$password = base64_encode(
							$iv .
							mcrypt_encrypt(
							MCRYPT_RIJNDAEL_128,
							hash('sha256', $key, true),
							$password,
							MCRYPT_MODE_CBC,
							$iv
							)
							);
							
							$temp = explode(".", $_FILES["file"]["name"]);
							$extension = end($temp);
							$extension = strtolower($extension);
							if ($_FILES["file"]["error"] > 0)
							{
								
							}
							else 
							{
								
								$fileName = $temp[0].".".$temp[1];
								$temp[0] = rand(0, 3000); //Set to random number
								$fileName;
							}
							if (file_exists("img/userprofile/" . $_FILES["file"]["name"]))
							{
								
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "../img/userprofile/" . $newfilename);
								
								
							}
							
							$result5=$db->select('mv_user_id','mv_user','mv_user_id');
							$l='MV';
							foreach ($result5 as $data){
							    
								$code=$l.str_pad($data['mv_user_id']+1001, 5, '0', STR_PAD_LEFT);
								$wallet=$data['mv_user_id']+1;
							}
							
							$col = "max(mv_user_id) as user_id";
            	            $tb = "mv_user";
            	            $opt = 1;
            	            $user = $db->get($col,$tb,$opt);
            	            $user_id = $user[0]['user_id']+1;
            	            
							
							$result6=$db->select('mv_wallet_id','mv_wallet','mv_wallet_id');
							foreach ($result6 as $data1){
								$walletreceiver=$data1['mv_wallet_id']+1;
							}
							
							$getid = $db->where('mv_user_id','mv_user','mv_user_code',$userupline);
							if(empty($getid)){
								$uplineid = 0;
								}else{
								$getid = $getid[0];
								$uplineid=$getid['mv_user_id'];
							}
							
							if($uplineid == 0){
								$chk_user_limit = array();
								}else{
								$col = "*";
								$tb = "mv_user";
								$chkcol = "mv_user_referral";
								$opt = $uplineid;
								$chk_user_limit = $db->where($col,$tb,$chkcol,$opt);


                                //check user downline if full
                                $check_limit = count($chk_user_limit);

								if($check_limit < $default['mv_default_max_ref']){
								    
								    $uplineid = $uplineid;
								    
								}else if($check_limit >= $default['mv_default_max_ref']){
								    
								    	$no = 0;
                                    	$member = array();
                                    	
                                    	function GetMember($level=0, $parentID=null)
                                    	{   
                                    		global $db;
                                    		global $no;
                                    		global $member;
                                    			
                                    		// Create the query
                                    		$sql = "SELECT id FROM tree WHERE ";
                                    		$col = "*";
                                    		$tb = "mv_user";
                                    		$chkcol = "mv_user_referral";
                                    		if($parentID == null) {
                                    			$opt = null;
                                    		}
                                    		else {
                                    			$opt = intval($parentID);
                                    		}
                                    		// Execute the query and go through the results.
                                    		$result = $db->where($col,$tb,$chkcol,$opt);
                                    		if($result)
                                    		{
                                    			foreach($result as $row)
                                    			{
                                    				
                                    				if($row['mv_user_type']==1){ $utype = 'Admin'; }else{ $utype = 'User'; }
                                    				
                                    				// Get the current ID;
                                    				$currentID = $row['mv_user_id'];				
                                    							
                                    				$checklevel = 1;
                                    				$status = true;
                                    				$check_id = $currentID;
                                    				
                                    				//check member level
                                    				do{
                                    					
                                    					$check_upline = $db->where('mv_user_referral','mv_user','mv_user_id',$check_id);
                                    					$check_upline = $check_upline[0]['mv_user_referral'];
                                    					
                                    					if($check_upline == $your_id){
                                    										
                                    						$member[$no] = array("level"=>$checklevel-3,"id"=>$row['mv_user_id']);
                                    						$status = false;
                                    										
                                    						}else if($check_upline != $your_id){
                                    										
                                    						$status = true;
                                    						$check_id = $check_upline;
                                    						$checklevel++;					
                                    						
                                    					}
                                    					
                                    				}while($status);
                                    				
                                    				
                                    				// echo ' '.$member[$no]['level'];
                                    				// echo ' '.$member[$no]['id'];
                                    				
                                    				$no++;
                                    				// Print all children of the current ID
                                    				GetMember($level+1, $currentID); 			
                                    			}			
                                    		}
                                    		else {
                                    			//die("Failed to execute query! ($level / $parentID)");
                                    		}
                                    		
                                    	}
                                    	
                                    	GetMember(0,$uplineid);
                                    	
                                    	
                                    	// rearrange the user from high level to down
                                    	$userlevel = 1;
                                    	$check_status = true;
                                    	do{
                                    		$i=0;
                                    		
                                    		do{
                                    			
                                    			if( $member[$i]['level'] == $userlevel )
                                    			{
                                    				// echo ' '.$member[$i]['id'];
                                                    // check current user's downline is full
                    								$chk_downline = $db->where("*","mv_user","mv_user_referral",$member[$i]['id']);
                    								$chk_downline = count($chk_downline);
                    								
                    								if($chk_downline >= $default['mv_default_max_ref']){
                    								    
                    								    $check_status = true;
                    								    
                    								}else if($chk_downline < $default['mv_default_max_ref']){
                    								    
                    								    $check_status = false;
                    								    $uplineid = $member[$i]['id'];
                    								    
                    								}
                                    				
                                    			}
                                    			
                                    			$i++;
                                    						
                                    		}while( ($i < $no) && ($check_status) );

                                    		$userlevel = $userlevel +1;
                                    		
                                    	}while( ($userlevel <= $default['mv_default_max_ref']) && ($check_status) );
								    
								}
								
							}
							
							//double check for user limit
						    $col = "*";
							$tb = "mv_user";
							$chkcol = "mv_user_referral";
							$opt = $uplineid;
							$chk_user_limit = $db->where($col,$tb,$chkcol,$opt);
							
							$refname = $db->where($col,$tb,'mv_user_id',$opt);
							$refname = $refname[0]['mv_user_fullname'];
							
							if(count($chk_user_limit)<$default['mv_default_max_ref']){
								
								$col = "*";
								$tb = "mv_user";
								$chkcol = "mv_user_id";
								$opt = $_SESSION['id'];
								$cur_user = $db->where($col,$tb,$chkcol,$opt);
								
								$getcode = $db->where($col,$tb,$chkcol,$opt);
								
								$col="mv_user_name";
								$opt= 'mv_user_name = ?';
								$arr=array($username);
								
								$result=$db->advwhere($col,'mv_user',$opt,$arr);
								if(count($result)==0){
									
									$colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name","mv_beneficiary_ic","mv_beneficiary_phnum","mv_user_type");
									$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,1,0,$userpass,$b_name,$b_ic,$b_num,2);
									$result1=$db->insert1('mv_user',$colname,$array);
									
									$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
									$array2= array(0,1,0,0,0, $user_id);
									$result2=$db->insert1('mv_wallet',$colname2,$array2);
									
									
									
									if($result1 && $result2 ){
									    
									    //send mail
										require '../PHPMailer/PHPMailerAutoload.php';
                                        $mail = new PHPMailer;
                                        $mail->isSMTP();
                                        //Host Here
                                        $mail->Host = 'mail.mrvege777.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'system@ezylife2u.com';
                                        $mail->Password = 'i[qxHPuH2_EC';
                                        $mail->SMTPSecure = '';
                                        $mail->Port = '587';        	
                                        
                                        $mail->setFrom('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addReplyTo('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addAddress($useremail); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Register Successful';
                                        $mail->Body = 'Username:'.$username.'<br> Password:'.$cpassword.'<br> Your Referral Name:'.$refname.'<br> <br>Please login your account at this link below <br> http://ezylife2u.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
									    
									    
										echo "<script>alert(\"SUCCESSFUL and Your Referral Name is $refname\");
										
										window.location.href='../login.php';</script>";
									}
        							else{
										echo "<script>alert(\"fail\");
										window.location.href='../login.php';</script>";
									}
								}
								else{
									echo "<script>alert(\"name existing\");
									window.location.href='../login.php';</script>";
								}
								
							}
							else{
								echo "<script>alert(\"the maximum referrer is over 7\");
								window.location.href='../login.php';</script>";
							}
						}
					}
				}	if($type=="landingregister"){
					if($success=="1"){
					if(isset($_POST['btnsubmituser'])){
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$userupline = $_POST['upline'];
						$usercontact = $_POST['phone'];
						$useric = $_POST['ic'];
						$userpass = $_POST['passport'];
						$b_name = $_POST['bname'];
						$b_ic = $_POST['bic'];
						$b_num = $_POST['bnum'];
						$underaddstate=$_POST['under_addstate'];
						
					
						//password encrytion
							$key = 'mumuls1314';
							$iv = mcrypt_create_iv(
							mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
							MCRYPT_DEV_URANDOM
							);
							
							$password = base64_encode(
							$iv .
							mcrypt_encrypt(
							MCRYPT_RIJNDAEL_128,
							hash('sha256', $key, true),
							$password,
							MCRYPT_MODE_CBC,
							$iv
							)
							);
						
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
                        if ($_FILES["file"]["error"] > 0)
						{
		
						}
                        else 
						{
							
                            $fileName = $temp[0].".".$temp[1];
                            $temp[0] = rand(0, 3000); //Set to random number
                            $fileName;
						}
						if (file_exists("../img/userprofile/" . $_FILES["file"]["name"]))
						{
                            
						}
						else
						{
                            $temp = explode(".", $_FILES["file"]["name"]);
                			$newfilename = round(microtime(true)) . '.' . end($temp);
                			move_uploaded_file($_FILES["file"]["tmp_name"], "../img/userprofile/" . $newfilename);
							
						}
					    
				    	$result5=$db->select('mv_user_id','mv_user','mv_user_id');
				     	$l='MV';
					    foreach ($result5 as $data){
							    
                        $code=$l.str_pad($data['mv_user_id']+1001, 5, '0', STR_PAD_LEFT);
                        $wallet=$data['mv_user_id']+1;
                        }
                        
                         $col = "max(mv_user_id) as user_id";
            	            $tb = "mv_user";
            	            $opt = 1;
            	            $user = $db->get($col,$tb,$opt);
            	            $user_id = $user[0]['user_id']+1;
            	            
                        
                        $result6=$db->select('mv_wallet_id','mv_wallet','mv_wallet_id');
                        foreach ($result6 as $data1){
                            $walletreceiver=$data1['mv_wallet_id']+1;
                        }
				        
				        $getid = $db->where('mv_user_id','mv_user','mv_user_code',$userupline);
				        if(empty($getid)){
				            $uplineid = 0;
				        }else{
				            $getid = $getid[0];
				            $uplineid=$getid['mv_user_id'];
				        }
				        
				        if($uplineid == 0){
				            $chk_user_limit = array();
				        }else{
				            $col = "*";
    				        $tb = "mv_user";
    				        $chkcol = "mv_user_referral";
    				        $opt = $uplineid;
    				        $chk_user_limit = $db->where($col,$tb,$chkcol,$opt);
    				        
    				        
				        }
				        
				        if(count($chk_user_limit)<$default['mv_default_max_ref']){
				        
				       
				        
    				        $col = "*";
    				        $tb = "mv_user";
    				        $chkcol = "mv_user_id";
    				        $opt = $_SESSION['id'];
    				        $cur_user = $db->where($col,$tb,$chkcol,$opt);
    				    
    				        $getcode = $db->where($col,$tb,$chkcol,$opt);
    				        
    				        $col="mv_user_name";
    						$opt= 'mv_user_name = ?';
    						$arr=array($username);
                    	
                    		$result=$db->advwhere($col,'mv_user',$opt,$arr);
                    		if(count($result)==0){
    				        
    				            $colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name","mv_beneficiary_ic","mv_beneficiary_phnum","mv_user_type");
        						$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,1,0,$userpass,$b_name,$b_ic,$b_num,2);
        						$result1=$db->insert1('mv_user',$colname,$array);
                        	
                        		$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
        						$array2= array(0,1,0,0,0, $user_id);
        						$result2=$db->insert1('mv_wallet',$colname2,$array2);
        						
        							$colname4 = array("mv_user_id","mv_state_id");
							         	$array4 = array($user_id,$underaddstate);
							                $db->insert1('mv_user_state',$colname4,$array4);
        					
        					
										//insert to log
    									$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                						$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $table[0]['table_id'];
                        	            
    									$log_arr = array(1,$tb,$table_id,$time,$table_id);
    									$log = $db->insert1('mv_log',$log_col,$log_arr);
        					
        					
        						
        						if($result1 && $result2 ){
        						 echo "<script>alert(\"SUCCESSFUL\");
                                window.location.href='../../index.php';</script>";
                                
                                	//send mail
										require '../PHPMailer/PHPMailerAutoload.php';
                                        $mail = new PHPMailer;
                                        $mail->isSMTP();
                                        //Host Here
                                        $mail->Host = 'mail.mrvege777.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'system@ezylife2u.com';
                                        $mail->Password = 'i[qxHPuH2_EC';
                                        $mail->SMTPSecure = '';
                                        $mail->Port = '587';        	
                                        
                                        $mail->setFrom('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addReplyTo('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addAddress($useremail); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Register Successful';
                                        $mail->Body = 'Username:'.$username.'<br> Password:'.$cpassword.'<br> <br>Please login your account at this link below <br> http://ezylife2u.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
        						}
        						
        						
        						
        							else{
                    		     echo "<script>alert(\"fail\");
                     window.location.href='../../index.php';</script>";
                    		}
                    		}
                    		else{
                    		     echo "<script>alert(\"name existing\");
                     window.location.href='../../index.php';</script>";
                    		}
                    	
				        
				        }
					}
				}
				}
				else if($type=="merchantregister"){
					if($success=="1"){
					if(isset($_POST['btnsubmituser'])){
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$userupline = $_POST['upline'];
						$usercontact = $_POST['phone'];
						$useric = $_POST['ic'];
						$userpass = $_POST['passport'];
						$b_name = $_POST['bname'];
						$b_ic = $_POST['bic'];
						$b_num = $_POST['bnum'];
						$m_sname = $_POST['sname'];
    					$m_cname = $_POST['cname'];
    					$m_bdetail = $_POST['bdetail'];
    					$m_intro= $_POST['intro'];
    					$m_addr= $_POST['address'];
    					$m_link= $_POST['link'];
						
					
						//password encrytion
							$key = 'mumuls1314';
							$iv = mcrypt_create_iv(
							mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
							MCRYPT_DEV_URANDOM
							);
							
							$password = base64_encode(
							$iv .
							mcrypt_encrypt(
							MCRYPT_RIJNDAEL_128,
							hash('sha256', $key, true),
							$password,
							MCRYPT_MODE_CBC,
							$iv
							)
							);
						
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
                        if ($_FILES["file"]["error"] > 0)
						{
		
						}
                        else 
						{
							
                            $fileName = $temp[0].".".$temp[1];
                            $temp[0] = rand(0, 3000); //Set to random number
                            $fileName;
						}
						if (file_exists("../img/userprofile/" . $_FILES["file"]["name"]))
						{
                            
						}
						else
						{
                            $temp = explode(".", $_FILES["file"]["name"]);
                			$newfilename = round(microtime(true)) . '.' . end($temp);
                			move_uploaded_file($_FILES["file"]["tmp_name"], "../img/userprofile/" . $newfilename);
							
						}
					    
				    	$result5=$db->select('mv_user_id','mv_user','mv_user_id');
				     	$l='MV';
					    foreach ($result5 as $data){
							    
                        $code=$l.str_pad($data['mv_user_id']+1001, 5, '0', STR_PAD_LEFT);
                        $wallet=$data['mv_user_id']+1;
                        }
                        
                         $col = "max(mv_user_id) as user_id";
            	            $tb = "mv_user";
            	            $opt = 1;
            	            $user = $db->get($col,$tb,$opt);
            	            $user_id = $user[0]['user_id']+1;
            	            
                        
                        $result6=$db->select('mv_wallet_id','mv_wallet','mv_wallet_id');
                        foreach ($result6 as $data1){
                            $walletreceiver=$data1['mv_wallet_id']+1;
                        }
				        
				        $getid = $db->where('mv_user_id','mv_user','mv_user_code',$userupline);
				        if(empty($getid)){
				            $uplineid = 0;
				        }else{
				            $getid = $getid[0];
				            $uplineid=$getid['mv_user_id'];
				        }
				        
				        if($uplineid == 0){
				            $chk_user_limit = array();
				        }else{
				            $col = "*";
    				        $tb = "mv_user";
    				        $chkcol = "mv_user_referral";
    				        $opt = $uplineid;
    				        $chk_user_limit = $db->where($col,$tb,$chkcol,$opt);
    				        
    				        
				        }
				        
				        if(count($chk_user_limit)<$default['mv_default_max_ref']){
				        
				       
				        
    				        $col = "*";
    				        $tb = "mv_user";
    				        $chkcol = "mv_user_id";
    				        $opt = $_SESSION['id'];
    				        $cur_user = $db->where($col,$tb,$chkcol,$opt);
    				    
    				        $getcode = $db->where($col,$tb,$chkcol,$opt);
    				        
    				        $col="mv_user_name";
    						$opt= 'mv_user_name = ?';
    						$arr=array($username);
                    	
                    		$result=$db->advwhere($col,'mv_user',$opt,$arr);
                    		if(count($result)==0){
    				        
    				            $colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_status","mv_user_redeem","mv_user_passport","mv_merchant_shopname","mv_merchant_cname","mv_merchant_bank","mv_merchant_intro","mv_merchant_address","mv_merchant_link","mv_user_type");
        						$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,1,0,$userpass,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_addr,$m_link,4);
        						$result1=$db->insert1('mv_user',$colname,$array);
                        	
                        		$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
        						$array2= array(0,1,0,0,0, $user_id);
        						$result2=$db->insert1('mv_wallet',$colname2,$array2);
        					
        					
        						
        						if($result1 && $result2 ){
        						 echo "<script>alert(\"SUCCESSFUL\");
                                window.location.href='../../index.php';</script>";
                                
                                	//send mail
										require '../PHPMailer/PHPMailerAutoload.php';
                                        $mail = new PHPMailer;
                                        $mail->isSMTP();
                                        //Host Here
                                         $mail->Host = 'mail.mrvege777.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'system@ezylife2u.com';
                                        $mail->Password = 'i[qxHPuH2_EC';
                                        $mail->SMTPSecure = '';
                                        $mail->Port = '587';        	
                                        
                                        $mail->setFrom('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addReplyTo('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addAddress($useremail); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Register Successful';
                                        $mail->Body = 'Username:'.$username.'<br> Password:'.$cpassword.'<br> <br>Please login your account at this link below <br> http://ezylife2u.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
        						}
        							else{
                    		     echo "<script>alert(\"fail\");
                     window.location.href='../../index.php';</script>";
                    		}
                    		}
                    		else{
                    		     echo "<script>alert(\"name existing\");
                     window.location.href='../../index.php';</script>";
                    		}
                    	
				        
				        }
					}
				}
				}
				else if($type=="forgetpassword"){
				    if($success=="1"){
					if(isset($_POST['btnforgetuser'])){
						
						$username= $_POST['uname'];
						$uemail= $_POST['email'];
						
						$col = "*";
	                    $tablename = "mv_user";
	                    $opt = "mv_user_name = ? AND mv_user_email = ?";
	                    $arr = array($username,$uemail);
	                    $result = $db->advwhere($col,$tablename,$opt,$arr);
	                    if($result){
	                        
	                        	echo "<script>alert(\"Password is sent to your email\");
										window.location.href='../../index.php';</script>";
										
	                    $key = 'mumuls1314';
							
							$encpass = $result[0]['mv_user_pword'];
							$data = base64_decode($encpass);
							$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
							
							$decpass = rtrim(
							mcrypt_decrypt(
							MCRYPT_RIJNDAEL_128,
							hash('sha256', $key, true),
							substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
							MCRYPT_MODE_CBC,
							$iv
							),
							"\0"
							);
	                    
	                    	//send mail
										require '../PHPMailer/PHPMailerAutoload.php';
                                        $mail = new PHPMailer;
                                        $mail->isSMTP();
                                        //Host Here
                                       $mail->Host = 'mail.mrvege777.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'system@ezylife2u.com';
                                        $mail->Password = 'i[qxHPuH2_EC';
                                        $mail->SMTPSecure = '';
                                        $mail->Port = '587';        	
                                        
                                        $mail->setFrom('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addReplyTo('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addAddress($uemail); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Forget Password';
                                        $mail->Body = 'This is your account username and password<br> Username:'.$username.'<br> Password:'.$decpass.'<br><br> Any problem please access the link below <br> http://ezylife2u.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
	                    }
	                    else{
	                        	echo "<script>alert(\"email and username is not match\");
										window.location.href='../../index.php';</script>";
	                    }
						
				}
				    }
				}
        	    
    	}else{
    		echo "Token Expired. Please Try Again";
    	}
    }
    else{
    	echo "Token Is Required.";
    }
}
?>
