<?php
	
	require_once('inc/init.php');
	
	//require_once("inc/level_controller.php");
	if(isset($_REQUEST['type'])&&isset($_REQUEST['tb'])||isset($_REQUEST['success'])){
		$type = $_REQUEST['type'];
		$tb = $_REQUEST['tb'];
		$success = $_REQUEST['success'];
	}
	$postedToken = filter_input(INPUT_POST, 'token');
	if(!empty($postedToken)){
		$your_id = $_SESSION['id'];
		$user = $db->where('*','mv_user','mv_user_id',$your_id);
		$user = $user[0];
		$id= $user['mv_user_id'];
		$time=date('Y-m-d H:i:s');   
		
		$col = "*";
		$default_tb = "mv_default";
		$opt = 1;
		$default = $db->get($col,$default_tb,$opt);
		$default = $default[0];
		
		if(isTokenValid($postedToken)){
			if($tb=="user"){
				if($type=="add"){
    					if($success=="1"){
    						if(isset($_POST['submit'])){
    							$username = $_POST['uname'];
    							$username = preg_replace('/\s+/', '', $username);
    							$password = $_POST['password'];
    							$cpassword = $_POST['cpassword'];
    							$userfname = $_POST['fname'];
    							$useremail = $_POST['email'];
    							$usercontact = $_POST['phone'];
    							$usertype = $_POST['typeid'];
    							$userupline = $_POST['upline'];
    							$useric = $_POST['ic'];
    							$usercredit = $_POST['credit'];
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
    							if (file_exists("img/userprofile/" . $_FILES["file"]["name"]))
    							{
    								
    							}
    							else
    							{
    								$temp = explode(".", $_FILES["file"]["name"]);
    								$newfilename = round(microtime(true)) . '.' . end($temp);
    								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
    								
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
    								if($cur_user[0]['mv_user_type']==1){
    									
    									
    									
    									}else if($cur_user[0]['mv_user_type']==2){
    									$usertype = 2;
    									$col = "*";
    									$tb = "mv_wallet";
    									$chkcol = "mv_wallet_id";
    									$opt = $cur_user[0]['mv_user_id'];
    									$sender_wallet = $db->where($col,$tb,$chkcol,$opt);
    									$sender_wallet_amount = $sender_wallet[0]['mv_wallet_amt'];
    									if($sender_wallet_amount >= $usercredit){
    										$remain_amount = $sender_wallet_amount - $usercredit;
    										$tb = "mv_wallet";
    										$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
    										$db->update($remain_amount,$sender_wallet[0]['mv_user_id']);
    										
    										}else{
    										$usercredit = 0;
    									}
    								}
    								$getcode = $db->where($col,$tb,$chkcol,$opt);
    								
    								$col="mv_user_name";
    								$opt= 'mv_user_name = ?';
    								$arr=array($username);
    								
    								$result=$db->advwhere($col,'mv_user',$opt,$arr);
    								if(count($result)==0){
    									
    									$colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_type","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name	","mv_beneficiary_ic","mv_beneficiary_phnum");
    									$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,$usertype,1,0,$userpass,$b_name,$b_ic,$b_num);
    									$result1=$db->insert1('mv_user',$colname,$array);
    									
    									$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
    									$array2= array($usercredit,1,0,0,0, $user_id);
    									$result2=$db->insert1('mv_wallet',$colname2,$array2);
    									
    									$colname3 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id");
    									$array3= array($usercredit,1,1,$time,$walletreceiver,0,0);
    									$result3=$db->insert1('mv_transaction',$colname3,$array3);
    									
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
                        	            
    									$log_arr = array(1,$tb,$table_id,$time,$id);
    									$log = $db->insert1('mv_log',$log_col,$log_arr);
    									
    									if($result1 && $result2 && $result3){
    										echo "<script>alert(\"SUCCESSFUL\");
    										window.location.href='userlist.php';</script>";
    										
    										//send mail
    										require 'PHPMailer/PHPMailerAutoload.php';
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
    										window.location.href='userlist.php';</script>";
    									}
    								}
    								else{
    									die("username existing");
    								}
    								
    							}
    						}
    					}
					}
					
					else if($type=="addmerchant"){
    					if($success=="1"){
    						if(isset($_POST['submit'])){
    							$username = $_POST['uname'];
    							$username = preg_replace('/\s+/', '', $username);
    							$password = $_POST['password1'];
    							$cpassword = $_POST['cpassword1'];
    							$userfname = $_POST['fname'];
    							$useremail = $_POST['email'];
    							$usercontact = $_POST['phone'];
    							$usertype = $_POST['typeid'];
    							$userupline = $_POST['upline'];
    							$useric = $_POST['ic'];
    							$usercredit = $_POST['credit'];
    							$userpass = $_POST['passport'];
    							$userstate = $_POST['statechecked'];
    							//print_r($userstate);
	                            $count = count($userstate);
                            	$i = 0;
                            	
                            	$closeday = $_POST['cday'];
					        	$starttime = $_POST['stime'];
					        	$endtime = $_POST['etime'];
    							$b_name = $_POST['bname'];
    							$b_ic = $_POST['bic'];
    							$b_num = $_POST['bnum'];
    							$m_sname = $_POST['sname'];
    							$m_cname = $_POST['cname'];
    							$m_bdetail = $_POST['bdetail'];
    							$m_intro= $_POST['intro'];
    							$m_addr= $_POST['address'];
    							$m_link= $_POST['link'];
    								$usercate = $_POST['under_cate'];
    							
    							
    							
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
    								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
    								
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
    								if($cur_user[0]['mv_user_type']==1){
    									
    									
    									
    									}else if($cur_user[0]['mv_user_type']==2){
    									$usertype = 2;
    									$col = "*";
    									$tb = "mv_wallet";
    									$chkcol = "mv_wallet_id";
    									$opt = $cur_user[0]['mv_user_id'];
    									$sender_wallet = $db->where($col,$tb,$chkcol,$opt);
    									$sender_wallet_amount = $sender_wallet[0]['mv_wallet_amt'];
    									if($sender_wallet_amount >= $usercredit){
    										$remain_amount = $sender_wallet_amount - $usercredit;
    										$tb = "mv_wallet";
    										$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
    										$db->update($remain_amount,$sender_wallet[0]['mv_user_id']);
    										
    										}else{
    										$usercredit = 0;
    									}
    								}
    								$getcode = $db->where($col,$tb,$chkcol,$opt);
    								
    								$col="mv_user_name";
    								$opt= 'mv_user_name = ?';
    								$arr=array($username);
    								
    								$result=$db->advwhere($col,'mv_user',$opt,$arr);
    								if(count($result)==0){
    									
    									$colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_type","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name	","mv_beneficiary_ic","mv_beneficiary_phnum","mv_merchant_shopname","mv_merchant_cname","mv_merchant_bank","mv_merchant_intro","mv_merchant_address","mv_merchant_link"
    									,"mv_merchant_close_day"
    									,"mv_merchant_start_time"
    									,"mv_merchant_end_time");
    									$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,$usertype,1,0,$userpass,$b_name,$b_ic,$b_num,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_addr,$m_link,$closeday,$starttime,$endtime);
    									$result1=$db->insert1('mv_user',$colname,$array);
    									
    									
    									$usercredit = 0; // this row is for user type 3 only
    									$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
    									$array2= array($usercredit,1,0,0,0, $user_id);
    									$result2=$db->insert1('mv_wallet',$colname2,$array2);
    									
    									$colname3 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id");
    									$array3= array($usercredit,1,1,$time,$walletreceiver,0,0);
    									$result3=$db->insert1('mv_transaction',$colname3,$array3);
    									
    									while($i<$count){
                                 		$stateid = $userstate[$i];
                                 		$colname4 = array("mv_user_id","mv_state_id");
                                 		$array4 = array($user_id,$stateid);
                                 	    $result4=$db->insert1('mv_user_state',$colname4,$array4);
                                 	 	$i++;
                                      	}
                                      		$colname5 = array("mv_user_id","mv_product_id");
                                 		$array5 = array($user_id,$usercate);
                                 	    $result5=$db->insert1('mv_user_product',$colname5,$array5);
    									
    									//insert to log
    									$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    									
    									$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $table[0]['table_id'];
                        	            
    									$log_arr = array(1,$tb,$table_id,$time,$id);
    									$log = $db->insert1('mv_log',$log_col,$log_arr);
    									
    									if($result1 && $result2 && $result3){
    										echo "<script>alert(\"SUCCESSFUL\");
    										window.location.href='userlist.php';</script>";
    										
    										//send mail
    										require 'PHPMailer/PHPMailerAutoload.php';
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
    										window.location.href='userlist.php';</script>";
    									}
    								}
    								else{
    									die("username existing");
    								}
    								
    							}
    						}
    					}
					}
					
					else if($type=="addseller"){
    					if($success=="1"){
    						if(isset($_POST['submit'])){
    							$username = $_POST['uname'];
    							$username = preg_replace('/\s+/', '', $username);
    							$password = $_POST['password2'];
    							$cpassword = $_POST['cpassword2'];
    							$userfname = $_POST['fname'];
    							$useremail = $_POST['email'];
    							$usercontact = $_POST['phone'];
    							$usertype = $_POST['typeid'];
    							$userupline = $_POST['upline'];
    							$useric = $_POST['ic'];
    							$usercredit = $_POST['credit'];
    							$userpass = $_POST['passport'];
    							$usermcate = $_POST['mcatechecked'];
    							$usericate = $_POST['icatechecked'];
    							$userstate = $_POST['statechecked'];
								$m_bdetail = $_POST['bdetail'];
								$m_cname = $_POST['cname'];
    							$b_name = $_POST['bname'];
    							$b_ic = $_POST['bic'];
    							$b_num = $_POST['bnum'];
    							//print_r($userstate);
	                            $count = count($userstate);
                            	$i = 0;
                            	
                            	//print_r($userstate);
	                            $count = count($usermcate);
                            	$j = 0;
                            	
                            	//print_r($userstate);
	                            $count = count($usericate);
                            	$k = 0;
                            	
                            
    							
    							
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
    								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
    								
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
    								if($cur_user[0]['mv_user_type']==1){
    									
    									
    									
    									}else if($cur_user[0]['mv_user_type']==2){
    									$usertype = 2;
    									$col = "*";
    									$tb = "mv_wallet";
    									$chkcol = "mv_wallet_id";
    									$opt = $cur_user[0]['mv_user_id'];
    									$sender_wallet = $db->where($col,$tb,$chkcol,$opt);
    									$sender_wallet_amount = $sender_wallet[0]['mv_wallet_amt'];
    									if($sender_wallet_amount >= $usercredit){
    										$remain_amount = $sender_wallet_amount - $usercredit;
    										$tb = "mv_wallet";
    										$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
    										$db->update($remain_amount,$sender_wallet[0]['mv_user_id']);
    										
    										}else{
    										$usercredit = 0;
    									}
    								}
    								$getcode = $db->where($col,$tb,$chkcol,$opt);
    								
    								$col="mv_user_name";
    								$opt= 'mv_user_name = ?';
    								$arr=array($username);
    								
    								$result=$db->advwhere($col,'mv_user',$opt,$arr);
    								if(count($result)==0){
    									
    									$colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_type","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name	","mv_beneficiary_ic","mv_beneficiary_phnum","mv_merchant_bank","mv_merchant_cname");
    									$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,$usertype,1,0,$userpass,$b_name,$b_ic,$b_num,$m_bdetail,$m_cname);
    									$result1=$db->insert1('mv_user',$colname,$array);
    									
    									
    									$usercredit = 0; // this row is for user type 3 only
    									$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
    									$array2= array($usercredit,1,0,0,0, $user_id);
    									$result2=$db->insert1('mv_wallet',$colname2,$array2);
    									
    									$colname3 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id");
    									$array3= array($usercredit,1,1,$time,$walletreceiver,0,0);
    									$result3=$db->insert1('mv_transaction',$colname3,$array3);
    									
    									while($i<$count){
                                 		$stateid = $userstate[$i];
                                 		$colname4 = array("mv_user_id","mv_state_id");
                                 		$array4 = array($user_id,$stateid);
                                 	    $result4=$db->insert1('mv_user_state',$colname4,$array4);
                                 	 	$i++;
                                      	}
                                      	
                                      		while($j<$count){
                                 		$mcateid = $usermcate[$j];
                                 		$colname4 = array("mv_user_id","mv_category_id");
                                 		$array4 = array($user_id,$mcateid);
                                 	    $result4=$db->insert1('mv_user_category',$colname4,$array4);
                                 	 	$j++;
                                      	}
                                      	
                                      		while($k<$count){
                                 		$icateid = $usericate[$k];
                                 		$colname4 = array("mv_user_id","mv_product_id");
                                 		$array4 = array($user_id,$icateid);
                                 	    $result4=$db->insert1('mv_user_product',$colname4,$array4);
                                 	 	$k++;
                                      	}
                                      
    							
    						
    									
    									//insert to log
    									$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    									
    									$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $table[0]['table_id'];
                        	            
    									$log_arr = array(1,$tb,$table_id,$time,$id);
    									$log = $db->insert1('mv_log',$log_col,$log_arr);
    									
        									if($result1 && $result2 && $result3 && $result4){
        										echo "<script>alert(\"SUCCESSFUL\");
        										window.location.href='userlist.php';</script>";
        										
        										//send mail
        										require 'PHPMailer/PHPMailerAutoload.php';
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
    										window.location.href='userlist.php';</script>";
    									}
    								}
    								else{
    									die("username existing");
    								}
    								
    							}
    						}
    					}
					}
					
					/*	else if($type=="testing"){
						    header('Location:userlist.php');
    						if(isset($_POST['submit'])){
    						$userstate = $_POST['statechecked'];
    						print_r($userstate);
	                        $count = count($userstate);
                         	$i = 0;
                         	while($i<$count){
		$stateid = $userstate[$i];
			$colname = array("mv_user_id","mv_state_id");
									$array = array(1,$stateid);
									$result1=$db->insert1('mv_user_state',$colname,$array);
		$i++;
	}
    							
    						}
    					
					}*/
					
					
					else if($type=="addmember"){
					if($success=="1"){
						
						if(isset($_POST['submit'])){
							$username = $_POST['uname'];
							$username = preg_replace('/\s+/', '', $username);
							$password = $_POST['password'];
							$cpassword = $_POST['cpassword'];
							$userfname = $_POST['fname'];
							$useremail = $_POST['email'];
							$usercontact = $_POST['phone'];
							$usertype = $_POST['typeid'];
							$userupline = $_POST['upline'];
							$useric = $_POST['ic'];
							$usercredit = $_POST['credit'];
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
							if (file_exists("img/userprofile/" . $_FILES["file"]["name"]))
							{
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
								
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
							
							
							if($userupline==''){
								$uplineid = $_SESSION['id'];
								}else{
								$getid = $db->where('mv_user_id','mv_user','mv_user_code',$userupline);
								if(empty($getid)){
									$uplineid = $_SESSION['id'];
									}else{
									$uplineid = $getid[0];
									$uplineid=$uplineid['mv_user_id'];
								}
							}
							
							$col = "*";
							$tb = "mv_user";
							$chkcol = "mv_user_referral";
							$opt = $uplineid;
							$chk_user_limit = $db->where($col,$tb,$chkcol,$opt);
							if(count($chk_user_limit)<$default['mv_default_max_ref']){
								
								$col = "*";
								$tb = "mv_user";
								$chkcol = "mv_user_id";
								$opt = $_SESSION['id'];
								$cur_user = $db->where($col,$tb,$chkcol,$opt);
								if($cur_user[0]['mv_user_type']==1){
									
									}else if($cur_user[0]['mv_user_type']==2){
									$usertype = 2;
									$col = "*";
									$tb = "mv_wallet";
									$chkcol = "mv_user_id";
									$opt = $cur_user[0]['mv_user_id'];
									$sender_wallet = $db->where($col,$tb,$chkcol,$opt);
									$sender_wallet_amount = $sender_wallet[0]['mv_wallet_amt'];
									if($sender_wallet_amount >= $usercredit){
										$remain_amount = $sender_wallet_amount - $usercredit;
										$tb = "mv_wallet";
										$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
										$array = array($remain_amount,$sender_wallet[0]['mv_user_id']);
										$db->update($tb,$data,$array);
										
										}else{
										$usercredit = 0;
									}
								}
								
								$col="mv_user_name";
								$opt= 'mv_user_name = ?';
								$arr=array($username);
								
								$result=$db->advwhere($col,'mv_user',$opt,$arr);
								if(count($result)==0){
									
									$colname = array("mv_user_name","mv_user_fullname","mv_user_email","mv_user_phnum","mv_user_pword","mv_user_createdate","mv_user_point","mv_user_image","mv_user_ic","mv_user_code","mv_user_referral","mv_user_type","mv_user_status","mv_user_redeem","mv_user_passport","mv_beneficiary_name	","mv_beneficiary_ic","mv_beneficiary_phnum");
									$array = array($username,$userfname,$useremail,$usercontact,$password,$time,100,$newfilename,$useric,$code,$uplineid,$usertype,1,0,$userpass,$b_name,$b_ic,$b_num);
									$result1=$db->insert1('mv_user',$colname,$array);
									
									$colname2 = array("mv_wallet_amt","mv_wallet_status","mv_wallet_pending_amt","mv_spend","mv_total_spend","mv_user_id");
									$array2= array($usercredit,1,0,0,0, $user_id);
									$result2=$db->insert1('mv_wallet',$colname2,$array2);
									
									$colname3 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id");
									$array3= array($usercredit,2,1,$time,$walletreceiver,$id,0);
									$result3=$db->insert1('mv_transaction',$colname3,$array3);
									
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
                    	            
									$log_arr = array(1,$tb,$table_id,$time,$id);
									$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									if($result1 && $result2 && $result3){
										echo "<script>alert(\"SUCCESSFUL\");
										window.location.href='member.php';</script>";
										
										//send mail
										require 'PHPMailer/PHPMailerAutoload.php';
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
										window.location.href='member.php';</script>";
									}
								}
								else{
									die("username existing");
								}
								}else{
								die("Your downline is already max, you are not able to add member at your downline. Please click BACK button.");
								
							}
						}
					}
					
				}
				else if($type=="requestvcoin"){
					header('Location:wallet.php');
					if(isset($_POST['btnsubmit'])){
						$transactionnum = $_POST['number'];
						$walletid = $_POST['walletid'];
						$b_type = $_POST['btype'];
						$a_number = $_POST['anumber'];
						$b_name = $_POST['bname'];
						$b_date = $_POST['bdate'];
						$temp = explode(".", $_FILES["file"]["name"]);
						
						$extension = end($temp);
						$extension = strtolower($extension);
						
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("img/receipt/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/receipt/" . $newfilename);
								
							}
						}
						
						$tablename="mv_request";
						$colname = array("mv_request_amt","mv_request_img","mv_request_datetime","mv_request_activity","mv_request_status","mv_user_id","mv_request_type","mv_request_number","mv_request_name","mv_request_bankdate");
						$array = array($transactionnum,$newfilename,$time,1,1,$id,$b_type,$a_number,$b_name,$b_date);
						$result = $db->insert1($tablename,$colname,$array);
						
						//insert to log
						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
						
						$col = "max(mv_request_id) as table_id"; //to get table id
        	            $tb = "mv_request";
        	            $opt = 1;
        	            $table = $db->get($col,$tb,$opt);
        	            $table_id = $table[0]['table_id'];
        	            
						$log_arr = array(1,$tb,$table_id,$time,$id);
						$log = $db->insert1('mv_log',$log_col,$log_arr);
					}
				}
				
				else if($type=="transfercredit"){
					header('Location:wallet.php');
					if(isset($_POST['btntransfer'])){
						
						
						$transferamt = $_POST['amt']; //amount to send
						$usercode = $_POST['usercode']; //receiver usercode
						$userid = $_SESSION['id']; //sender user id
						$userremark = $_POST['remark'];
						
						$col = "*";
						$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
						$chkcol = "mv_user_code";
						$opt = $usercode;
						$chkTargetUser = $db->where($col,$tb,$chkcol,$opt);
						if(empty($chkTargetUser)){
							die('User Code Is Not Exist');
							}else{
							$receiver_id = $chkTargetUser[0]['mv_user_id'];
							$receiver_wallet = $chkTargetUser[0]['mv_wallet_id'];
							if($receiver_id==$userid){
								die('Cannot Transfer To Urself');
								}else{
								$col = "*";
								$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
								$chkcol = "mv_user.mv_user_id";
								$opt = $userid;
								$senderWallet = $db->where($col,$tb,$chkcol,$opt);
								
								$senderBalance = $senderWallet[0]['mv_wallet_amt'];
								
								if($senderBalance >= $transferamt){
									$remainBalance = $senderBalance - $transferamt;
									$addedBalance = $chkTargetUser[0]['mv_wallet_amt'] + $transferamt;
									//Update Sender Info Here
									$tb = "mv_wallet";
									$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
									$arr = array($remainBalance,$userid);
									$db->update($tb,$data,$arr);
									//Update Receiver Info Here
									$tb = "mv_wallet";
									$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
									$arr = array($addedBalance,$receiver_id);
									$db->update($tb,$data,$arr);
									//Add Transaction Record
									$tb = "mv_transaction";
									$data = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id","mv_transaction_remark");
									$arr = array($transferamt,2,$date,1,$receiver_wallet,$userid,0,$userremark);
									$db->insert1($tb,$data,$arr);
									
									
									//insert to log
            						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
            						
            						$col = "max(mv_transaction_id) as table_id"; //to get table id
                    	            $tb = "mv_transaction";
                    	            $opt = 1;
                    	            $table = $db->get($col,$tb,$opt);
                    	            $table_id = $table[0]['table_id'];
                    	            
            						$log_arr = array(1,$tb,$table_id,$time,$id);
            						$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									
									}else{
									die('Not Enough Balance');
								}
								
							}
						}
					}
				}
				
					else if($type=="pendingmerchantbill"){
					header('Location:user_merchant.php');
					if(isset($_POST['btnmerchant'])){
						
						
						$transferamt = $_POST['amt']; //amount to send
						$usercode = $_POST['usercode']; //receiver usercode
						$userid = $_SESSION['id']; //sender user id
						
						//get sender details
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $userid;
						$getsendername = $db->where($col,$tb,$chkcol,$opt);
						$sendername = $getsendername[0]['mv_user_fullname'];
						
						
						$col = "*";
						$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
						$chkcol = "mv_user_code";
						$opt = $usercode;
						$chkTargetUser = $db->where($col,$tb,$chkcol,$opt);
						if(empty($chkTargetUser)){
							die('User Code Is Not Exist');
							}else{
							$receiver_id = $chkTargetUser[0]['mv_user_id'];
							$receiver_wallet = $chkTargetUser[0]['mv_wallet_id'];
							$receiver_email = $chkTargetUser[0]['mv_user_email'];
							if($receiver_id==$userid){
								die('Cannot Transfer To Urself');
								}else{
								$col = "*";
								$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
								$chkcol = "mv_user.mv_user_id";
								$opt = $userid;
								$senderWallet = $db->where($col,$tb,$chkcol,$opt);
								
								$senderBalance = $senderWallet[0]['mv_wallet_amt'];
								$senderSpend = $senderWallet[0]['mv_spend'];
								
								if($senderBalance >= $transferamt){
								    // sender remain balance
									$remainBalance = $senderBalance - $transferamt;
									// receiver total pending amount
									$addedBalance = $chkTargetUser[0]['mv_wallet_pending_amt'] + $transferamt;
									// sender spend amount
									$addedSpend = $senderSpend + $transferamt;
									//Update Sender Info Here
									$tb = "mv_wallet";
									$data = "mv_wallet_amt = ? , mv_spend = ? WHERE mv_user_id = ?";
									$arr = array($remainBalance,$addedSpend,$userid);
									$db->update($tb,$data,$arr);
									//Update Receiver Info Here
									$tb = "mv_wallet";
									$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
									$arr = array($addedBalance,$receiver_id);
									$db->update($tb,$data,$arr);
									//Add Transaction Record
									$tb = "mv_transaction";
									$data = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
									$arr = array($transferamt,8,$date,1,$receiver_wallet,$userid,0);
									$result = $db->insert1($tb,$data,$arr);
									
									
									//insert to log
            						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
            						
            						$col = "max(mv_transaction_id) as table_id"; //to get table id
                    	            $tb = "mv_transaction";
                    	            $opt = 1;
                    	            $table = $db->get($col,$tb,$opt);
                    	            $table_id = $table[0]['table_id'];
                    	            
            						$log_arr = array(1,$tb,$table_id,$time,$id);
            						$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									
        							if($result){
        							    
        							    $rebate =  $db->get('*','mv_default',1);
        							    $rebate_rate = $rebate[0]['mv_default_merchant_rebate'];
        							    
    							    	$level=0;
        								$parentID = $userid;
        								$buyerid = $userid;
        								$commission = $transferamt * ($rebate_rate / 100);
        								
        								
        								
        								
										//send mail
										require 'PHPMailer/PHPMailerAutoload.php';
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
                                        $mail->addAddress($receiver_email); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Payment Receipt Notice';
                                        $mail->Body = 'This is your receipt notice. (NO REPLY) <br><br> Amount : '.$transferamt.' Points <br> Date : '.$date.'<br> Customer Name : '.$sendername.'<br><br> Any problem please access the link below <br> https://ezypartners.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
        								
        								
        								
        								do{
         
        								        // Create the query
            									$col = "*";
            									$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
            									$chkcol = "mv_wallet.mv_user_id";
            									$opt = $parentID; 
            								    // Execute the query and go through the results.
            									$result = $db->where($col,$tb,$chkcol,$opt);
            								    
            								    
            								    if($result)
            									{
            										$row = $result[0];
            										$cur_user_status = $row['mv_user_status'];
            										if($cur_user_status == 1 && $level!=0){
            											$cur_vcoin = $row['mv_wallet_pending_amt'];
            											$new_vcoin = $cur_vcoin + $commission;
            											$tb_name = "mv_wallet";
            											$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
            											$arr = array($new_vcoin,$parentID);
            											$db->update($tb_name,$data,$arr);
            											
        												//Add Transaction Record
        	
                                                    	$wallet = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$parentID);
                                                    	$receiver_wallet = $wallet[0]['mv_wallet_id'];
                                                    	
                                                    	$tb = "mv_transaction";
                                                    	$data1 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
                                                    	$arr = array($commission,5,$date,1,$receiver_wallet,$buyerid,0);
                                                    	$db->insert1($tb,$data1,$arr);
            											
            										}
            										
            										    $parentID = $row['mv_user_referral'];
            									}
        								       
        							
        								    
        								    $level++;
        								     
        								}while($level < $default['mv_default_max_layer'] && ($parentID != NULL || $parentID != 0 || $parentID = '') );
        								
        								
        								//get rebate for user themselve
            				            $col = "*";
        								$tb = "mv_wallet";
        								$chkcol = "mv_user_id";
        								$opt = $buyerid; 
        								$result = $db->where($col,$tb,$chkcol,$opt);
        								$row = $result[0];
        								$cur_user_status = $row[0]['mv_user_status'];
        								
            							if($cur_user_status == 1){
            								$cur_vcoin = $row['mv_wallet_pending_amt'];
            								$new_vcoin = $cur_vcoin + $commission;
            								$tb_name = "mv_wallet";
            								$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
            								$arr = array($new_vcoin,$buyerid);
            								$db->update($tb_name,$data,$arr);
            								
            								//Add Transaction Record
            
                                        	$wallet = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$buyerid);
                                        	$receiver_wallet = $wallet[0]['mv_wallet_id'];
                                        	
                                        	$tb = "mv_transaction";
                                        	$data1 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
                                        	$arr = array($commission,5,$date,1,$receiver_wallet,$buyerid,0);
                                        	$db->insert1($tb,$data1,$arr);
            								
            							}
        							    
        							}	

									}else{
									die('Not Enough Balance');
								}
								
							}
						}
					}
				}
				
				else if($type=="redeemvcoin"){
					header('Location:wallet.php');
					if(isset($_POST['btnredeem'])){
						
						
						$user_point = $_POST['point']; //amount to send
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						if($cur_user[0]['mv_user_type']==1){
							
							
    				        }else if($cur_user[0]['mv_user_redeem']>=$user_point){
							$tablename="mv_request";
							$colname = array("mv_request_amt","mv_request_datetime","mv_request_activity","mv_request_status","mv_user_id");
							$array = array($user_point,$time,2,1,$id);
							$result = $db->insert1($tablename,$colname,$array);
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_request_id) as table_id"; //to get table id
            	            $tb = "mv_request";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
						}
						else{
							die("you are not user");
						}
						
						
					}
				}
				
				else if($type=="withdraw"){
					header('Location:wallet.php');
					if(isset($_POST['btnwithdraw'])){
						
						
						$v_coin = $_POST['vcoin']; //amount to send
						$b_type = $_POST['btype'];
						$a_number = $_POST['anumber'];
						$b_name = $_POST['bname'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						
						$col = "*";
						$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
						$chkcol = "mv_user.mv_user_id";
						$opt = $_SESSION['id'];
						$senderWallet = $db->where($col,$tb,$chkcol,$opt);
						
						$senderBalance = $senderWallet[0]['mv_wallet_amt'];
						
						if($cur_user[0]['mv_user_type']==1){
							
							
    				        }else if($senderBalance>=$v_coin){
							$tablename="mv_request";
							$colname = array("mv_request_amt","mv_request_datetime","mv_request_activity","mv_request_status","mv_user_id","mv_request_type","mv_request_number","mv_request_name");
							$array = array($v_coin,$time,3,1,$id,$b_type,$a_number,$b_name);
							$result = $db->insert1($tablename,$colname,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_wallet_id) as table_id"; //to get table id
            	            $tb = "mv_wallet";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
						}
						else{
							die("you are not user");
						}
						
						
					}
				}
				
				
				else if($type=="addcredit"){
					header('Location:userlist.php');
					if(isset($_POST['btnaddcredit'])){
						
						$transferamt = $_POST['addcoin'];
						$usercode = $_POST['usercode'];
						$userremark = $_POST['remark'];
						//$userid = $_POST['userid'];
						//$availableamt = $_POST['userbalance'];
						//$walletid = $_POST['walletid'];
						
						$tablename="mv_wallet";
						$tablename2="mv_transaction";
						//get wallet id be receiver
						$getid = $db->where('mv_user_id','mv_user','mv_user_code',$usercode);
						$getid = $getid[0];
						$uplineid=$getid['mv_user_id'];
						
						$getid2 = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$uplineid);
						$getid2= $getid2[0];
						$uplineid2=$getid2['mv_wallet_id'];
						//get wallet id be receiver
						$wallet = $db->where('*','mv_user','mv_user_code',$usercode);
						$wallet = $wallet[0];
						$tosenduserid = $wallet['mv_user_id'];
						
						$balance = $db->where('*','mv_wallet','mv_user_id',$tosenduserid);
						$balance = $balance[0];
						$tosendbalance = $balance['mv_wallet_amt'];
						
						
						
						
						
						//$aftertransfer = $availableamt - $transferamt;
						$tosendaftertransfer = $tosendbalance +  $transferamt;
						
						
						$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id","mv_transaction_remark");
						$array = array($transferamt,1,1,$time,$uplineid2,1,0,$userremark);
						$result = $db->insert1($tablename2,$colname,$array);
						
						
						// $data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
						// $array = array($aftertransfer,$id);
						// $result1= $db->update($tablename,$data,$array);
						
						$data1 = "mv_wallet_amt = ? WHERE mv_user_id = ?";
						$array1 = array($tosendaftertransfer,$tosenduserid);					
						$result2= $db->update($tablename,$data1,$array1);
						
						
						
						//insert to log
						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
						
						$col = "max(mv_transaction_id) as table_id"; //to get table id
        	            $tb = "mv_transaction";
        	            $opt = 1;
        	            $table = $db->get($col,$tb,$opt);
        	            $table_id = $table[0]['table_id'];
        	            
						$log_arr = array(2,$tb,$table_id,$time,$id);
						$log = $db->insert1('mv_log',$log_col,$log_arr);
					}
				}
				
				else if($type=="addpendingwallet"){
					header('Location:userlist.php');
					if(isset($_POST['btnaddpending'])){
						
						$transferamt = $_POST['addcoin'];
						$usercode = $_POST['usercode'];
						$userremark = $_POST['remark'];
						//$userid = $_POST['userid'];
						//$availableamt = $_POST['userbalance'];
						//$walletid = $_POST['walletid'];
						
						$tablename="mv_wallet";
						$tablename2="mv_transaction";
						//get wallet id be receiver
						$getid = $db->where('mv_user_id','mv_user','mv_user_code',$usercode);
						$getid = $getid[0];
						$receiver_id=$getid['mv_user_id'];
						
						$getid2 = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$receiver_id);
						$getid2= $getid2[0];
						$uplineid2=$getid2['mv_wallet_id'];
						
						
						//get wallet id be receiver
						$wallet = $db->where('*','mv_user','mv_user_code',$usercode);
						$wallet = $wallet[0];
						$tosenduserid = $wallet['mv_user_id'];
						
						$balance = $db->where('*','mv_wallet','mv_user_id',$tosenduserid);
						$balance = $balance[0];
						$tosendbalance = $balance['mv_wallet_pending_amt'];
						
						
						
						
						
						//$aftertransfer = $availableamt - $transferamt;
						$tosendaftertransfer = $tosendbalance +  $transferamt;
						
						
						$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_status","mv_transaction_date","mv_wallet_id","mv_user_id","mv_request_id","mv_transaction_remark");
						$array = array($transferamt,9,1,$time,$uplineid2,1,0,$userremark);
						$result = $db->insert1($tablename2,$colname,$array);
						
						
						// $data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
						// $array = array($aftertransfer,$id);
						// $result1= $db->update($tablename,$data,$array);
						
						$data1 = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
						$array1 = array($tosendaftertransfer,$tosenduserid);					
						$result2= $db->update($tablename,$data1,$array1);
						
						
						
						//insert to log
						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
						
						$col = "max(mv_transaction_id) as table_id"; //to get table id
        	            $tb = "mv_transaction";
        	            $opt = 1;
        	            $table = $db->get($col,$tb,$opt);
        	            $table_id = $table[0]['table_id'];
        	            
						$log_arr = array(2,$tb,$table_id,$time,$id);
						$log = $db->insert1('mv_log',$log_col,$log_arr);
					}
				}
				
				else if($type=="addsellercategory"){
					header('Location:catelist.php');
					if(isset($_POST['btnaddcategory'])){
						$productname=$_POST['cate_name'];
						$productdesc=$_POST['cate_desc'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("img/category/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/category/" . $newfilename);
								
							}
						}
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_product_name";
							$opt= 'mv_product_name = ?';
							$arr=array($productname);
							$result=$db->advwhere($col,'mv_product',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_product_name","mv_product_desc","mv_product_status","mv_product_img","mv_user_type");
								$array = array($productname,$productdesc,1,$newfilename,3);
								$db->insert1('mv_product',$colname,$array);
								
								
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_product_id) as table_id"; //to get table id
            	            $tb = "mv_product";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
					else if($type=="addmercategory"){
					header('Location:catelist.php');
					if(isset($_POST['btnaddcategory'])){
						$productname=$_POST['cate_name'];
						$productdesc=$_POST['cate_desc'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("img/category/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/category/" . $newfilename);
								
							}
						}
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_product_name";
							$opt= 'mv_product_name = ?';
							$arr=array($productname);
							$result=$db->advwhere($col,'mv_product',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_product_name","mv_product_desc","mv_product_status","mv_product_img","mv_user_type");
								$array = array($productname,$productdesc,1,$newfilename,4);
								$db->insert1('mv_product',$colname,$array);
								
								
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_product_id) as table_id"; //to get table id
            	            $tb = "mv_product";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
				else if($type=="addsubcategory"){
					header('Location:catelist.php');
					if(isset($_POST['btnaddsubcategory'])){
						$subproductname=$_POST['subcate_name'];
						$subproductdesc=$_POST['subcate_desc'];
						$undercate=$_POST['under_cate'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("img/sub_category/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/sub_category/" . $newfilename);
							}
						}
						$getproductid = $db->where('mv_product_id','mv_product','mv_product_name',$undercate);
				        if(empty($getproductid)){
				            $productid = 0;
							}else{
				            $getproductid = $getproductid[0];
				            $productid=$getproductid['mv_product_id'];
						}
				        
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_sub_product_name";
							$opt= 'mv_sub_product_name = ?';
							$arr=array($subproductname);
							$result=$db->advwhere($col,'mv_sub_product',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_sub_product_name","mv_sub_product_desc","mv_sub_product_img","mv_sub_product_status","mv_product_id");
								$array = array($subproductname,$subproductdesc,$newfilename,1,$productid);
								$db->insert1('mv_sub_product',$colname,$array);
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_sub_product_id) as table_id"; //to get table id
                	            $tb = "mv_sub_product";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $table[0]['table_id'];
                	            
        						$log_arr = array(1,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
				else if($type=="additem"){
					header('Location:itemlist.php');
					if(isset($_POST['btnadditem'])){
						$itemproductname=$_POST['item_name'];
						$itemproductdesc=$_POST['item_desc'];
						$itemproductamt=$_POST['item_amt'];
						$itemproductunit=$_POST['item_unit'];
						$underitemcate=$_POST['under_subcate'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/item/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/item/" . $newfilename);
								
							}
						}
						$getsubproductid = $db->where('mv_sub_product_id','mv_sub_product','mv_sub_product_name',$underitemcate);
				        if(empty($getsubproductid)){
				            $subproductid = 0;
							}else{
				            $getsubproductid = $getsubproductid[0];
				            $subproductid=$getsubproductid['mv_sub_product_id'];
						}
				        
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_item_name";
							$opt= 'mv_item_name = ?';
							$arr=array($itemproductname);
							$result=$db->advwhere($col,'mv_item',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_item_name","mv_item_desc","mv_item_img","mv_item_amt","mv_item_status","mv_item_unit","mv_sub_product_id");
								$array = array($itemproductname,$itemproductdesc,$newfilename,$itemproductamt,1,$itemproductunit,$subproductid);
								$db->insert1('mv_item',$colname,$array);
								
								
						    //insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_item_id) as table_id"; //to get table id
            	            $tb = "mv_item";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
					else if($type=="addcategory"){
					header('Location:category.php');
					if(isset($_POST['btnaddcategory'])){
						$categoryname=$_POST['category_name'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/sellercate/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/sellercate/" . $newfilename);
								
							}
						}
					
				        
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_category_name";
							$opt= 'mv_category_name = ?';
							$arr=array($categoryname);
							$result=$db->advwhere($col,'mv_category',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_category_name","mv_category_icon","mv_category_status");
								$array = array($categoryname,$newfilename,1);
								$db->insert1('mv_category',$colname,$array);
								
								
						    //insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_item_id) as table_id"; //to get table id
            	            $tb = "mv_item";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
					else if($type=="selleradditem"){
					header('Location:seller_item.php');
					if(isset($_POST['btnadditem'])){
						$itemproductname=$_POST['item_name'];
						$itemproductdesc=$_POST['item_desc'];
						$itemproductamt=$_POST['item_amt'];
						$itemproductunit=$_POST['item_unit'];
						$underitemcate=$_POST['under_subcate'];
						$userstate = $_POST['statechecked'];
    					//print_r($userstate);
	                    $count = count($userstate);
                        $i = 0;
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						
							$col = "max(mv_item_id) as item_id";
                	            $tb = "mv_item";
                	            $opt = 1;
                	            $user = $db->get($col,$tb,$opt);
                	            $item_id = $user[0]['item_id']+1;
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/item/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/item/" . $newfilename);
								
							}
						}
						$getsubproductid = $db->where('mv_sub_product_id','mv_sub_product','mv_sub_product_name',$underitemcate);
				        if(empty($getsubproductid)){
				            $subproductid = 0;
							}else{
				            $getsubproductid = $getsubproductid[0];
				            $subproductid=$getsubproductid['mv_sub_product_id'];
						}
				        
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==3){
							$col="mv_item_name";
							$opt= 'mv_item_name = ?';
							$arr=array($itemproductname);
							$result=$db->advwhere($col,'mv_item',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_item_name","mv_item_desc","mv_item_img","mv_item_amt","mv_item_status","mv_item_unit","mv_sub_product_id","mv_user_id");
								$array = array($itemproductname,$itemproductdesc,$newfilename,$itemproductamt,1,$itemproductunit,$subproductid,$id);
								$db->insert1('mv_item',$colname,$array);
								
									while($i<$count){
                                 		$stateid = $userstate[$i];
                                 		$colname4 = array("mv_item_id","mv_state_id");
                                 		$array4 = array($item_id,$stateid);
                                 	    $result4=$db->insert1('mv_item_state',$colname4,$array4);
                                 	 	$i++;
                                      	}
								
								
						    //insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_item_id) as table_id"; //to get table id
            	            $tb = "mv_item";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
				
				else if($type=="shopadditem"){
					header('Location:shopitem.php');
					if(isset($_POST['btnadditem'])){
						$itemproductname=$_POST['item_name'];
						$itemproductdesc=$_POST['item_desc'];
						$itemproductamt=$_POST['item_amt'];
						
						$itemproductunit=$_POST['item_unit'];
						$underitemcate=$_POST['under_subcate'];
						$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/item/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/item/" . $newfilename);
								
							}
						}
						$getsubproductid = $db->where('mv_sub_product_id','mv_sub_product','mv_sub_product_name',$underitemcate);
				        if(empty($getsubproductid)){
				            $subproductid = 0;
							}else{
				            $getsubproductid = $getsubproductid[0];
				            $subproductid=$getsubproductid['mv_sub_product_id'];
						}
				        
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==3){
							$col="mv_item_name";
							$opt= 'mv_item_name = ?';
							$arr=array($itemproductname);
							$result=$db->advwhere($col,'mv_item',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_item_name","mv_item_desc","mv_item_img","mv_item_amt","mv_item_status","mv_item_unit","mv_sub_product_id");
								$array = array($itemproductname,$itemproductdesc,$newfilename,$itemproductamt,1,$itemproductunit,$subproductid);
								$db->insert1('mv_item',$colname,$array);
								
								
						    //insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_item_id) as table_id"; //to get table id
            	            $tb = "mv_item";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $table[0]['table_id'];
            	            
    						$log_arr = array(1,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not wholesales');
						}
						
						
					}
				}
				
				else if($type=="addpackage"){
					header('Location:packagelist.php');
					if(isset($_POST['btnaddpackage'])){
						$packagename=$_POST['pack_name'];
						$packagedesc=$_POST['pack_desc'];
						$packageprice=$_POST['pack_price'];
						$packageunit=$_POST['pack_unit'];
						$packagepoint=$_POST['pack_point'];
						$packagecom=$_POST['pack_com'];
						$packagedeli=$_POST['pack_deli'];
						$packagecate=$_POST['categorychecked'];
						$packageuser=$_POST['under_addwholesaler'];
						$packagestate=$_POST['statechecked'];
						
						//print_r($packagecate);
	                            $count = count($packagecate);
                            	$i = 0;
                            	
                            	 $count1 = count($packagestate);
                            	$j = 0;
                            	
                            		$temp = explode(".", $_FILES["file"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["file"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/package/" . $_FILES["file"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/package/" . $newfilename);
								
							}
						}
						
						$column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_package_name";
							$opt= 'mv_package_name = ?';
							$arr=array($packagename);
							$result=$db->advwhere($col,'mv_package',$opt,$arr);
							
							if(count($result)==0){
								$colname = array("mv_package_name","mv_package_desc","mv_package_point","mv_package_status","mv_package_unit","mv_package_price","mv_package_commission","mv_package_deli","mv_package_logo","mv_user_id");
								$array = array($packagename,$packagedesc,$packagepoint,1,$packageunit,$packageprice,$packagecom,$packagedeli,$newfilename,$packageuser);
								$db->insert1('mv_package',$colname,$array);
								
						    $col = "max(mv_package_id) as package_id";
            	            $tb = "mv_package";
            	            $opt = 1;
            	            $package = $db->get($col,$tb,$opt);
            	            $package_id = $package[0]['package_id'];
								
									while($i<$count){
                                 		$productid = $packagecate[$i];
                                 		$colname4 = array("mv_package_id","mv_category_id");
                                 		$array4 = array($package_id,$productid);
                                 	    $result4=$db->insert1('mv_package_category',$colname4,$array4);
                                 	 	$i++;
                                      	}
                                      	
                                      		while($j<$count1){
                                 		$stateid = $packagestate[$j];
                                 		$colname4 = array("mv_package_id","mv_state_id");
                                 		$array4 = array($package_id,$stateid);
                                 	    $result4=$db->insert1('mv_package_state',$colname4,$array4);
                                 	 	$j++;
                                      	}
                                      
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_package_id) as table_id"; //to get table id
                	            $tb = "mv_package";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $table[0]['table_id'];
                	            
        						$log_arr = array(1,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
						
					}
				}
					else if($type=="editscategory"){
					header('Location:category.php');
					if(isset($_POST['btnsubmitcategory'])){
						$cateid=$_POST['btnsubmitcategory'];
						$categoryname = $_POST['cname'];
						
					
						$categorystatus = $_POST['status'];
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/sellercate/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_category_name";
							$opt= 'mv_category_name = ? AND mv_category_id != ?';
							$arr=array($categoryname,$cateid);
							$result=$db->advwhere($col,'mv_category',$opt,$arr);
							
							if(count($result)==0){
								if ((!($_FILES['file']['name']))){
									$tablename="mv_category";
					                $data = "mv_category_name = ? ,  mv_category_status = ? WHERE mv_category_id = ?";
				                  	$array = array($categoryname,$categorystatus,$cateid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								else{
									$tablename="mv_category";
					                $data = "mv_category_name = ? , mv_category_icon = ?  , mv_category_status = ? WHERE mv_category_id = ?";
				                  	$array = array($categoryname,$newfilename,$categorystatus,$cateid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_category_id) as table_id"; //to get table id
                	            $tb = "mv_category";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $pid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
					}
				}
				
				else if($type=="editcategory"){
					header('Location:catelist.php');
					if(isset($_POST['btnsubmitcategory'])){
						$cateid=$_POST['btnsubmitcategory'];
						$categoryname = $_POST['cname'];
						$categorydesc = $_POST['desc'];
						$categorystatus = $_POST['status'];
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/category/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						$getid = $db->where('*','mv_product','mv_product_id',$cateid);
						$getid = $getid[0];
						$pid=$getid['mv_product_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_product_name";
							$opt= 'mv_product_name = ? AND mv_product_id != ?';
							$arr=array($categoryname,$pid);
							$result=$db->advwhere($col,'mv_product',$opt,$arr);
							
							if(count($result)==0){
								if ((!($_FILES['file']['name']))){
									$tablename="mv_product";
					                $data = "mv_product_name = ? , mv_product_desc = ? , mv_product_status = ? WHERE mv_product_id = ?";
				                  	$array = array($categoryname,$categorydesc,$categorystatus,$pid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								else{
									$tablename="mv_product";
					                $data = "mv_product_name = ? , mv_product_img = ? , mv_product_desc = ? , mv_product_status = ? WHERE mv_product_id = ?";
				                  	$array = array($categoryname,$newfilename,$categorydesc,$categorystatus,$pid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_product_id) as table_id"; //to get table id
                	            $tb = "mv_product";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $pid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
					}
				}
				
			    
				else if($type=="editsubcategory"){
					header('Location:catelist.php');
					if(isset($_POST['btnsubmitsubcategory'])){
						$subcateid=$_POST['btnsubmitsubcategory'];
						$subcategoryname = $_POST['subcate_name'];
						$subcategorydesc = $_POST['subcate_desc'];
						$subcategorystatus = $_POST['status'];
						
						$undercate = $_POST['under_cate'];
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/sub_category/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						$getid = $db->where('*','mv_sub_product','mv_sub_product_id',$subcateid);
						$getid = $getid[0];
						$sid=$getid['mv_sub_product_id'];
						
						$getproductid = $db->where('mv_product_id','mv_product','mv_product_name',$undercate);
				        if(empty($getproductid)){
				            $productid = 0;
							}else{
				            $getproductid = $getproductid[0];
				            $productid=$getproductid['mv_product_id'];
						}
				        
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_sub_product_name";
							$opt= 'mv_sub_product_name = ? AND mv_sub_product_id != ?';
							$arr=array($subcategoryname,$sid);
							$result=$db->advwhere($col,'mv_sub_product',$opt,$arr);
							
							if(count($result)==0){
								if ((!($_FILES['file']['name']))){
									$tablename="mv_sub_product";
					                $data = "mv_sub_product_name = ? , mv_sub_product_desc = ? , mv_sub_product_status = ? , mv_product_id = ? WHERE mv_sub_product_id = ?";
				                  	$array = array($subcategoryname,$subcategorydesc,$subcategorystatus,$productid,$sid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								else{
									$tablename="mv_sub_product";
					                $data = "mv_sub_product_name = ? , mv_sub_product_img = ? , mv_sub_product_desc = ? , mv_sub_product_status = ? ,  mv_product_id = ? WHERE mv_sub_product_id = ?";
				                  	$array = array($subcategoryname,$newfilename,$subcategorydesc,$subcategorystatus,$productid,$sid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_sub_product_id) as table_id"; //to get table id
                	            $tb = "mv_sub_product";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $sid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
					}
				}
				
				else if($type=="edititem"){
					header('Location:itemlist.php');
					if(isset($_POST['btnsubmititem'])){
						$itemid=$_POST['btnsubmititem'];
						$itemname = $_POST['iname'];
						$itemdesc = $_POST['idesc'];
						$itemamt = $_POST['iamt'];
						$itemunit = $_POST['iunit'];
						$itemsubcate = $_POST['under_subcate'];
						$itemstatus = $_POST['status'];
						
						
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/item/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						$getid = $db->where('*','mv_item','mv_item_id',$itemid);
						$getid = $getid[0];
						$iid=$getid['mv_item_id'];
						
						$getsubproductid = $db->where('mv_sub_product_id','mv_sub_product','mv_sub_product_name',$itemsubcate);
				        if(empty($getsubproductid)){
				            $subproductid = 0;
							}else{
				            $getsubproductid = $getsubproductid[0];
				            $subproductid=$getsubproductid['mv_sub_product_id'];
						}
				        
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_item_name";
							$opt= 'mv_item_name = ? AND mv_item_id != ?';
							$arr=array($itemname,$iid);
							$result=$db->advwhere($col,'mv_item',$opt,$arr);
							
							if(count($result)==0){
								if ((!($_FILES['file']['name']))){
									$tablename="mv_item";
					                $data = "mv_item_name = ? , mv_item_desc = ? , mv_item_amt = ? , mv_item_unit = ? , mv_sub_product_id = ? , mv_item_status = ?  WHERE mv_item_id = ?";
				                  	$array = array($itemname,$itemdesc,$itemamt,$itemunit,$subproductid,$itemstatus,$iid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								else{
									$tablename="mv_item";
					                $data = "mv_item_name = ? , mv_item_img = ? , mv_item_desc = ? , mv_item_amt = ? , mv_sub_product_id = ? , mv_item_unit = ? , mv_item_status = ? WHERE mv_item_id = ?";
				                  	$array = array($itemname,$newfilename,$itemdesc,$itemamt,$subproductid,$itemunit,$itemstatus,$iid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_item_id) as table_id"; //to get table id
                	            $tb = "mv_item";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $iid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
						
					}
				}
				
				
				else if($type=="shopedititem"){
					header('Location:seller_item.php');
					if(isset($_POST['btnsubmititem'])){
						$itemid=$_POST['btnsubmititem'];
						$itemname = $_POST['iname'];
						$itemdesc = $_POST['idesc'];
						$itemamt = $_POST['iamt'];
						$itemunit = $_POST['iunit'];
						$itemsubcate = $_POST['under_subcate'];
						$itemstatus = $_POST['status'];
						
						
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/item/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						$getid = $db->where('*','mv_item','mv_item_id',$itemid);
						$getid = $getid[0];
						$iid=$getid['mv_item_id'];
						
						$getsubproductid = $db->where('mv_sub_product_id','mv_sub_product','mv_sub_product_name',$itemsubcate);
				        if(empty($getsubproductid)){
				            $subproductid = 0;
							}else{
				            $getsubproductid = $getsubproductid[0];
				            $subproductid=$getsubproductid['mv_sub_product_id'];
						}
				        
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==3){
							$col="mv_item_name";
							$opt= 'mv_item_name = ? AND mv_item_id != ?';
							$arr=array($itemname,$iid);
							$result=$db->advwhere($col,'mv_item',$opt,$arr);
							
							if(count($result)==0){
								if ((!($_FILES['file']['name']))){
									$tablename="mv_item";
					                $data = "mv_item_name = ? , mv_item_desc = ? , mv_item_amt = ? , mv_item_unit = ? , mv_sub_product_id = ? , mv_item_status = ?  WHERE mv_item_id = ?";
				                  	$array = array($itemname,$itemdesc,$itemamt,$itemunit,$subproductid,$itemstatus,$iid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								else{
									$tablename="mv_item";
					                $data = "mv_item_name = ? , mv_item_img = ? , mv_item_desc = ? , mv_item_amt = ? , mv_sub_product_id = ? , mv_item_unit = ? , mv_item_status = ? WHERE mv_item_id = ?";
				                  	$array = array($itemname,$newfilename,$itemdesc,$itemamt,$subproductid,$itemunit,$itemstatus,$iid);
				                 	$result2= $db->update($tablename,$data,$array);
								}
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_item_id) as table_id"; //to get table id
                	            $tb = "mv_item";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $iid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
							}
							
							}else if($cur_user[0]['mv_user_type']==2){
							die('you are not wholes');
						}
						
					}
				}
				
				else if($type=="editpackage"){
					header('Location:packagelist.php');
					if(isset($_POST['btnsubmitpackage'])){
						$packageid=$_POST['btnsubmitpackage'];
						$packagename = $_POST['pname'];
						$packagedesc = $_POST['pdesc'];
						$packageprice = $_POST['pprice'];
						$packageunit = $_POST['punit'];
						$packagepoint = $_POST['ppoint'];
						$packagecom = $_POST['pcom'];
						$packagedeli = $_POST['pdeli'];
						$packagestatus = $_POST['pstatus'];
						$underchangeuser=$_POST['under_changeuser'];
						$underaddstate=$_POST['under_addstate'];
						$underdeletestate=$_POST['under_deletestate'];
						
							if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/package/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						
						
						
						$getid = $db->where('*','mv_package','mv_package_id',$packageid);
						$getid = $getid[0];
						$pid=$getid['mv_package_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_package_name";
							$opt= 'mv_package_name = ? AND mv_package_id != ?';
							$arr=array($packagename,$pid);
							$result=$db->advwhere($col,'mv_package',$opt,$arr);
							//check state
							$col="mv_package_id,mv_state_id";
							$opt= 'mv_package_id = ? AND mv_state_id = ?';
							$arr=array($pid,$underaddstate);
							$result2=$db->advwhere($col,'mv_package_state',$opt,$arr);
							
							
							
						if($underaddstate==0){
						    
						}
						else{
					            			    if(count($result2)==0){
					            			      
					            			$colname = array("mv_package_id","mv_state_id");
					            	     	$array2 = array($pid,$underaddstate);
					            	        $result5=$db->insert1('mv_package_state',$colname,$array2);
					            			        
					            			    
					            			    }
						}
					            			    
					            	if($underdeletestate==0)	{
					            	    
					            	}	      else{
					            			 $col = 'mv_package_id = ? AND mv_state_id = ?';
					            	    	$arr = array($pid,$underdeletestate);
					            			$result4=$db->advdel('mv_package_state',$col,$arr);
					            	}
					            			        
					            			         
									
							
					            	if(count($result)==0){
					            	    	$tablename="mv_package";
					            		$data = "mv_package_name = ? , mv_package_desc = ? , mv_package_point = ? , mv_package_unit = ? , mv_package_price = ? , mv_package_status = ? , mv_package_commission = ? , mv_package_deli = ?  ,  mv_user_id = ?,  mv_package_logo = ?  WHERE mv_package_id = ?";
					            		$array = array($packagename,$packagedesc,$packagepoint,$packageunit,$packageprice,$packagestatus,$packagecom,$packagedeli,$underchangeuser,$newfilename,$pid);
					            		$result2= $db->update($tablename,$data,$array);
					            		
					            	}
					            	else{
					            	    die("name exist");
					            	}
	
							 
									        
									        
									
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_package_id) as table_id"; //to get table id
                	            $tb = "mv_package";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $pid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
									    
							
							
							
						}else if($cur_user[0]['mv_user_type']==2){
								die('you are not admin');
							}
					}
				}
				
				else if($type=="editpcate"){
					header('Location:packagelist.php');
					if(isset($_POST['btnsubmitpackage'])){
						$packageid=$_POST['btnsubmitpackage'];
						$underaddcate=$_POST['under_addcate'];
						$underdeletecate=$_POST['under_deletecate'];
						$getid = $db->where('*','mv_package','mv_package_id',$packageid);
						$getid = $getid[0];
						$pid=$getid['mv_package_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
						
							
							$col="mv_package_id,mv_category_id";
							$opt= 'mv_package_id = ? AND mv_category_id = ?';
							$arr=array($pid,$underaddcate);
							$result=$db->advwhere($col,'mv_package_category',$opt,$arr);
						
							    if($underaddcate == 0){
							        
							    }else{
									if(count($resul2)==0){ 
									    
									    	$colname = array("mv_package_id","mv_category_id");
							     	$array2 = array($pid,$underaddcate);
							        $result5=$db->insert1('mv_package_category',$colname,$array2);
									}  
							    }
							    
							     if($underdeletecate == 0){
							        
							    }else{
									     $col = 'mv_package_id = ? AND mv_category_id = ?';
							    	$arr = array($pid,$underdeletecate);
									$result4=$db->advdel('mv_package_category',$col,$arr);
							
							    }
									
							       
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_package_id) as table_id"; //to get table id
                	            $tb = "mv_package";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $pid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
							
						}else if($cur_user[0]['mv_user_type']==2){
								die('you are not admin');
							}
					}
				}
				
					else if($type=="editsuser"){
					header('Location:userlist.php');
					if(isset($_POST['btnsubmituser'])){
						$userid=$_POST['btnsubmituser'];
					
						$underaddcategory=$_POST['under_addcategory'];
						$underdeletecategory=$_POST['under_deletecategory'];
						$underaddicategory=$_POST['under_addicategory'];
						$underdeleteicategory=$_POST['under_deleteicategory'];
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
						
							$col3="mv_category_id,mv_user_id";
							$opt3= 'mv_category_id = ? AND mv_user_id = ?';
							$arr3=array($underaddcategory,$userid);
							$result=$db->advwhere($col3,'mv_user_category',$opt3,$arr3);
							
							$col3="mv_product_id,mv_user_id";
							$opt3= 'mv_product_id = ? AND mv_user_id = ?';
							$arr3=array($underaddicategory,$userid);
							$result2=$db->advwhere($col3,'mv_user_product',$opt3,$arr3);
							
							
						
							
						
							
							
							
						if($underaddcategory == 0){
						  
						}
							else{
							if(count($result)==0){
					
											$colname = array("mv_user_id","mv_category_id");
							               	$array3 = array($userid,$underaddcategory);
							                $db->insert1('mv_user_category',$colname,$array3);
							}
							}
						if($underdeletecategory == 0){
						  
						}
					    	else{
							                $col = 'mv_user_id = ? AND mv_category_id = ?';
							               	$arr = array($userid,$underdeletecategory);
											$result4=$db->advdel('mv_user_category',$col,$arr);
						}
						
						if($underaddicategory == 0){
						  
						}
							else{
							if(count($result2)==0){
					
											$colname = array("mv_user_id","mv_product_id");
							               	$array3 = array($userid,$underaddicategory);
							                $db->insert1('mv_user_product',$colname,$array3);
							}
							}
						if($underdeleteicategory == 0){
						  
						}
					    	else{
							                $col = 'mv_user_id = ? AND mv_product_id = ?';
							               	$arr = array($userid,$underdeleteicategory);
											$result4=$db->advdel('mv_user_product',$col,$arr);
						}
							                
						



										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
						}
						else if($cur_user[0]['mv_user_type']==2){
						die('you are not admin');
						}
					}
					
				    
					
				}
				
				else if($type=="edituser"){
					header('Location:userlist.php');
					if(isset($_POST['btnsubmituser'])){
						$userid=$_POST['btnsubmituser'];
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$usercontact = $_POST['phone'];
						$usertype = $_POST['typeid'];
						$userupline = $_POST['upline'];
						$useric = $_POST['ic'];
						$usercredit = $_POST['credit'];
						$userpending = $_POST['pendingwallet'];
						$userstatus = $_POST['ustatus'];
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
    					$underchangestate=$_POST['under_changestate'];
    					$underchangecategory=$_POST['under_changecategory'];
    					$underaddstate=$_POST['under_addstate'];
						$underdeletestate=$_POST['under_deletestate'];
						$underaddcategory=$_POST['under_addcategory'];
						$underdeletecategory=$_POST['under_deletecategory'];
						$closeday = $_POST['cday'];
						$starttime = $_POST['stime'];
						$endtime = $_POST['etime'];
						
						$usercodeid2=$db->where('*','mv_user','mv_user_id',$userid);
						$usercodeid2=$usercodeid2[0]['mv_user_code'];
						$usercodeid=$db->where('*','mv_user','mv_user_code',$userupline);
						$usercodeid=$usercodeid[0]['mv_user_id'];
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						$getid = $db->where('*','mv_user','mv_user_id',$userid);
						$getid = $getid[0];
						$uid=$getid['mv_user_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							$col="mv_user_name";
							$opt= 'mv_user_name = ? AND mv_user_id != ?';
							$arr=array($username,$uid);
							$result=$db->advwhere($col,'mv_user',$opt,$arr);
							
							$col2="mv_state_id,mv_user_id";
							$opt2= 'mv_state_id = ? AND mv_user_id = ?';
							$arr2=array($underaddstate,$uid);
							$result2=$db->advwhere($col2,'mv_user_state',$opt2,$arr2);
							
							$col3="mv_category_id,mv_user_id";
							$opt3= 'mv_category_id = ? AND mv_user_id = ?';
							$arr3=array($underaddcategory,$uid);
							$result3=$db->advwhere($col3,'mv_user_category',$opt3,$arr3);
							
							$col3="mv_user_id";
							$opt3= 'mv_user_id = ?';
							$arr3=array($uid);
							$exist=$db->advwhere($col3,'mv_user_state',$opt3,$arr3);
							
							$col3="mv_user_id";
							$opt3= 'mv_user_id = ?';
							$arr3=array($uid);
							$exist2=$db->advwhere($col3,'mv_user_product',$opt3,$arr3);
							
							
							
							$key = 'mumuls1314';
							
							$encpass = $cur_user[0]['mv_user_pword'];
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
							
							$getwallet = $db->where('mv_wallet_amt','mv_wallet','mv_user_id',$uid);
        					$ori_wallet = $getwallet[0]['mv_wallet_amt'];
        					
							
							if(count($result)==0){
							    if(count($result2)==0){
							     
							    if($userupline!=$usercodeid2){
								if($password==$cpassword ){
								    //user and admin
								    if($usertype==1 || $usertype==2){
									if ((!($_FILES['file']['name']))){
										
										
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
										
																				//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										
										
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? , mv_user_type = ? , mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ? , mv_beneficiary_name = ? , mv_beneficiary_ic = ? , mv_beneficiary_phnum = ? , mv_user_referral = ? , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ?  WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$usercontact,$usertype,$useric,$userstatus,$userpass,$b_name,$b_ic,$b_num,$usercodeid,$m_sname,$m_cname,$m_bdetail,$m_intro,$uid);
										$data2 = "mv_wallet_amt = ?  , mv_wallet_pending_amt =? WHERE mv_user_id = ?";
										$array2 = array($usercredit,$userpending,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
										if(count($exist)==0){
										    
										    if($underchangestate == NULL){
										        $underchangestate = 99;
										    }
										    
										    $colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underchangestate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										else{
										$data3 = "mv_state_id = ? WHERE mv_user_id = ?";
										$array3 = array($underchangestate,$uid);
										$result3= $db->update('mv_user_state',$data3,$array3);
										}
										
									}
									
									else{
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? , mv_user_type = ? , mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ? , mv_beneficiary_name = ? , mv_beneficiary_ic = ? , mv_beneficiary_phnum = ? , mv_user_referral = ? , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ?   WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$usertype,$useric,$userstatus,$userpass,$b_name,$b_ic,$b_num,$usercodeid,$m_sname,$m_cname,$m_bdetail,$m_intro,$uid);
										$data2 = "mv_wallet_amt = ? , mv_wallet_pending_amt =? WHERE mv_user_id = ?";
										$array2 = array($usercredit,$userpending,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
										if(count($exist)==0){
										    $colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underchangestate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										else{
										$data3 = "mv_state_id = ? WHERE mv_user_id = ?";
										$array3 = array($underchangestate,$uid);
										$result3= $db->update('mv_user_state',$data3,$array3);
										}
										
										
										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										
									}
								    }
								    //merchant
								    else if ($usertype==4){
								    	if ((!($_FILES['file']['name']))){
										
										
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
										
																		
										
										
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? ,  mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ?   , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ? , mv_merchant_link = ? ,  mv_merchant_address = ? , mv_merchant_start_time = ? , mv_merchant_end_time = ?, mv_merchant_close_day = ? WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$usercontact,$useric,$userstatus,$userpass,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_link,$m_addr,$starttime,$endtime,$closeday,$uid);
										$data2 = "mv_wallet_amt = ?  WHERE mv_user_id = ?";
										$usercredit=0;
										$array2 = array($usercredit,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
										if(count($exist2)==0){
										    $colname = array("mv_user_id","mv_product_id");
							               	$array = array($uid,$underchangecategory);
							                $db->insert1('mv_user_product',$colname,$array);
										}
										else{
										$tablename="mv_user_product";
										$data = "mv_product_id = ?  WHERE mv_user_id = ?";
										$array = array($underchangecategory,$uid);
										$result= $db->update($tablename,$data,$array);
										}
										
											
										
									
										
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array3 = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array3);
							                
										
												//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										
										
										

										
									}
									
									else{
									   
										
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? ,  mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ?  , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ? , mv_merchant_link = ? , mv_merchant_address = ? , mv_merchant_start_time = ? , mv_merchant_end_time = ?, mv_merchant_close_day = ?  WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$useric,$userstatus,$userpass,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_link,$m_addr,$starttime,$endtime,$closeday,$uid);
										$data2 = "mv_wallet_amt = ?  WHERE mv_user_id = ?";
										$usercredit=0;
										$array2 = array($usercredit,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
										$tablename="mv_user_product";
										$data = "mv_product_id = ?  WHERE mv_user_id = ?";
										$array = array($underchangecategory,$uid);
										$result= $db->update($tablename,$data,$array);
										
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array3 = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array3);
										
										
										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										
									}
								    }
								    // seller
								    else if ($usertype==3){
								    	if ((!($_FILES['file']['name']))){
										
										
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
										
										
										
										
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? ,  mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ? , mv_merchant_cname = ?  WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$usercontact,$useric,$userstatus,$userpass,$m_cname,$uid);
											$usercredit=0;
										$data2 = "mv_wallet_amt = ?  WHERE mv_user_id = ?";
										$array2 = array($usercredit,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
									
										
									
										
										
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array3 = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array3);
							                
							               
											
											
											
										
							                
							                										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										

										
									}
									
									else{
										$tablename="mv_user";
										$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? ,  mv_user_ic = ? , mv_user_status = ? , mv_user_passport = ?    WHERE mv_user_id = ?";
										$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$useric,$userstatus,$userpass,$uid);
											$usercredit=0;
										$data2 = "mv_wallet_amt = ?  WHERE mv_user_id = ?";
										$array2 = array($usercredit,$uid);
										$result= $db->update($tablename,$data,$array);
										$result2= $db->update('mv_wallet',$data2,$array2);
										
										if(count($exist2)==0){
										    $colname = array("mv_user_id","mv_product_id");
							               	$array = array($uid,$underchangecategory);
							                $db->insert1('mv_user_product',$colname,$array);
										}
										else{
										$tablename="mv_user_product";
										$data = "mv_product_id = ?  WHERE mv_user_id = ?";
										$array = array($underchangecategory,$uid);
										$result= $db->update($tablename,$data,$array);
										}
										
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array3 = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array3);
										
										
										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                        	            $tb = "mv_user";
                        	            
                        	            // for mv_user
                        	            $table_id = $uid;
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
                						
                						
                						
                						//for mv_wallet
                						$log_arr = array(2,"mv_wallet->check uid ".$ori_wallet." to ".$usercredit,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
										
									}
								    }
									
									
									
								}
							}
							die("Referral Cannot be yourself");
						
							    }
								die("state exist");
							
							}
							
							
						}
						else if($cur_user[0]['mv_user_type']==2){
						die('you are not admin');
						}
					}
					
				    
					
				}
				
				
				else if($type=="editprofileuser"){
					header('Location:userprofile.php');
					if(isset($_POST['btnsubmitprofile'])){
						$userid=$_POST['btnsubmitprofile'];
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$opassword = $_POST['opassword'];
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$usercontact = $_POST['phone'];
						$useric = $_POST['ic'];
						$userpass = $_POST['passport'];
						$b_name = $_POST['bname'];
						$b_ic = $_POST['bic'];
						$b_num = $_POST['bnum'];
						$underchangestate=$_POST['under_changestate'];
						
						
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						$getid = $db->where('*','mv_user','mv_user_id',$userid);
						$getid = $getid[0];
						$uid=$getid['mv_user_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							die('you are not admin');
							
							}else if($cur_user[0]['mv_user_type']==2){
							
							$col="mv_user_name";
							$opt= 'mv_user_name = ? AND mv_user_id != ?';
							$arr=array($username,$uid);
							$result=$db->advwhere($col,'mv_user',$opt,$arr);
							
							$col3="mv_user_id";
							$opt3= 'mv_user_id = ?';
							$arr3=array($uid);
							$exist=$db->advwhere($col3,'mv_user_state',$opt3,$arr3);
							
							$key = 'mumuls1314';
							
							$encpass = $cur_user[0]['mv_user_pword'];
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
							
							if(count($result)==0){
								
							    if($opassword==$decpass){
									if($password==$cpassword ){
										if ((!($_FILES['file']['name']))){
											
											
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
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_beneficiary_name = ? , mv_beneficiary_ic = ? , mv_beneficiary_phnum = ?  WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$usercontact,$useric,$userpass,$b_name,$b_ic,$b_num,$uid);
											$result= $db->update($tablename,$data,$array);
											
											if(count($exist)==0){
										    $colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underchangestate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										else{
										$data3 = "mv_state_id = ? WHERE mv_user_id = ?";
										$array3 = array($underchangestate,$uid);
										$result3= $db->update('mv_user_state',$data3,$array3);
										}
										}
										
										else{
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
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_beneficiary_name = ? , mv_beneficiary_ic = ? , mv_beneficiary_phnum = ?  WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$useric,$userpass,$b_name,$b_ic,$b_num,$uid);
											$result= $db->update($tablename,$data,$array);
											
											if(count($exist)==0){
										    $colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underchangestate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										else{
										$data3 = "mv_state_id = ? WHERE mv_user_id = ?";
										$array3 = array($underchangestate,$uid);
										$result3= $db->update('mv_user_state',$data3,$array3);
										}
										
										}
										
										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                						
                						$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $uid;
                        	            
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
        								
										
									}else{
									    die("confirm password is not same as password");
									}
									
									
								}else{
								    die("old password");
								}
								
							}else{
							    die("username exist");
							}
						}
						
						
					}
				}
				
					else if($type=="editprofilemer"){
					header('Location:merchantprofile.php');
					if(isset($_POST['btnsubmitprofile'])){
						$userid=$_POST['btnsubmitprofile'];
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$opassword = $_POST['opassword'];
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$usercontact = $_POST['phone'];
						$useric = $_POST['ic'];
						$userpass = $_POST['passport'];
						$closeday = $_POST['cday'];
						$starttime = $_POST['stime'];
						$endtime = $_POST['etime'];
						$m_sname = $_POST['sname'];
    					$m_cname = $_POST['cname'];
    					$m_bdetail = $_POST['bdetail'];
    					$m_intro= $_POST['intro'];
    					$m_addr= $_POST['address'];
    					$m_link= $_POST['link'];
    					$underaddstate=$_POST['under_addstate'];
						$underdeletestate=$_POST['under_deletestate'];
						
						
						
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						$getid = $db->where('*','mv_user','mv_user_id',$userid);
						$getid = $getid[0];
						$uid=$getid['mv_user_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							die('you are not admin');
							
							}else if($cur_user[0]['mv_user_type']==4){
							
							$col="mv_user_name";
							$opt= 'mv_user_name = ? AND mv_user_id != ?';
							$arr=array($username,$uid);
							$result=$db->advwhere($col,'mv_user',$opt,$arr);
							
							$col="mv_state_id,mv_user_id";
							$opt= 'mv_state_id = ? AND mv_user_id = ?';
							$arr=array($underaddstate,$uid);
							$result2=$db->advwhere($col,'mv_user_state',$opt,$arr);
							
							$key = 'mumuls1314';
							
							$encpass = $cur_user[0]['mv_user_pword'];
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
							
							if(count($result)==0){
							    	if(count($result2)==0){
							    if($opassword==$decpass){
									if($password==$cpassword ){
										if ((!($_FILES['file']['name']))){
											
											
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
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ? , mv_merchant_link = ? , mv_merchant_address = ? , mv_merchant_close_day = ? , mv_merchant_start_time = ? , mv_merchant_end_time = ? WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$usercontact,$useric,$userpass,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_link,$m_addr,$closeday,$starttime,$endtime,$uid);
											$result= $db->update($tablename,$data,$array);
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										
										else{
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
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_merchant_shopname = ? , mv_merchant_cname = ? , mv_merchant_bank = ? , mv_merchant_intro = ? , mv_merchant_link = ? , mv_merchant_address = ? , mv_merchant_close_day = ? , mv_merchant_start_time = ? , mv_merchant_end_time = ?  WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$useric,$userpass,$m_sname,$m_cname,$m_bdetail,$m_intro,$m_link,$m_addr,$closeday,$starttime,$endtime,$uid);
											$result= $db->update($tablename,$data,$array);
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array);
										}
										
										
										//insert to log
                						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                						
                						$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $uid;
                        	            
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);
        								
										
									}else{
									    die("confirm password is not same as password");
									}
									
									
								}else{
								    die("old password");
								}
							}
							    else{
							    die("state exist");
							    }
								
							}else{
							    die("username exist");
							}
						}
						
						
					}
				}
				
					else if($type=="editprofilesell"){
					header('Location:sellprofile.php');
					if(isset($_POST['btnsubmitprofile'])){
						$userid=$_POST['btnsubmitprofile'];
						$username = $_POST['uname'];
						$username = preg_replace('/\s+/', '', $username);
						$opassword = $_POST['opassword'];
						$password = $_POST['password'];
						$cpassword = $_POST['cpassword'];
						$userfname = $_POST['fname'];
						$useremail = $_POST['email'];
						$usercontact = $_POST['phone'];
						$useric = $_POST['ic'];
						$userpass = $_POST['passport'];
							$m_cname = $_POST['cname'];
						$underaddstate=$_POST['under_addstate'];
						$underdeletestate=$_POST['under_deletestate'];
						
					
						
						
						
						if(isset($_FILES["file"]))
						{
							if ($_FILES["file"]["error"] > 0)
							{
								echo "<script>alert('You do not have choose any image');</script>";
							}
							else 
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
							}
						} 
						else
						{
							$newfilename = $_POST['filename'];
						}
						$getid = $db->where('*','mv_user','mv_user_id',$userid);
						$getid = $getid[0];
						$uid=$getid['mv_user_id'];
						
	                    $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
						if($cur_user[0]['mv_user_type']==1){
							die('you are not admin');
							
							}else if($cur_user[0]['mv_user_type']==3){
							
							$col="mv_user_name";
							$opt= 'mv_user_name = ? AND mv_user_id != ?';
							$arr=array($username,$uid);
							$result=$db->advwhere($col,'mv_user',$opt,$arr);
							
							$col="mv_state_id,mv_user_id";
							$opt= 'mv_state_id = ? AND mv_user_id = ?';
							$arr=array($underaddstate,$uid);
							$result2=$db->advwhere($col,'mv_user_state',$opt,$arr);
							
							$key = 'mumuls1314';
							
							$encpass = $cur_user[0]['mv_user_pword'];
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
							
							if(count($result)==0){
							  
							    if(count($result2)==0){
							    if($opassword==$decpass){
									if($password==$cpassword ){
										if ((!($_FILES['file']['name']))){
											
											
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
											
											$col = 'mv_user_id = ? AND mv_state_id = ?';
							               	$arr = array($uid,$underdeletestate);
											$result4=$db->advdel('mv_user_state',$col,$arr);
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_merchant_cname = ?  WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$usercontact,$useric,$userpass,$m_cname,$uid);
											$result= $db->update($tablename,$data,$array);
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underaddstate);
							                $db->insert1('mv_user_state',$colname,$array);
							                
							              
							                
											
											
										}
										
										else{
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
											
											$tablename="mv_user";
											$data = "mv_user_name = ? , mv_user_pword = ? , mv_user_fullname = ? , mv_user_email = ? , mv_user_image = ? , mv_user_phnum = ? , mv_user_ic = ? , mv_user_passport = ? , mv_merchant_cname = ?   WHERE mv_user_id = ?";
											$array = array($username,$password,$userfname,$useremail,$newfilename,$usercontact,$useric,$userpass,$m_cname,$uid);
											$result= $db->update($tablename,$data,$array);
											
											$colname = array("mv_user_id","mv_state_id");
							               	$array = array($uid,$underaddstate);
							                $result3=$db->insert1('mv_user_state',$colname,$array);
							                
							                
										}
										
										
										//insert to log
                						/*$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
                						
                						$col = "max(mv_user_id) as table_id"; //to get table id
                        	            $tb = "mv_user";
                        	            $opt = 1;
                        	            $table = $db->get($col,$tb,$opt);
                        	            $table_id = $uid;
                        	            
                						$log_arr = array(2,$tb,$table_id,$time,$id);
                						$log = $db->insert1('mv_log',$log_col,$log_arr);*/
        								
										
									}else{
									    die("confirm password is not same as password");
									}
									
									
								}else{
								    die("old password");
								}
							    }
							    else{
							    die("state exist");
							    }
								
							}else{
							    die("username exist");
							}
							
						}
						
						
					}
				}
				
				else if($type=="pendingrequest"){
					header('Location:pending.php');
					if(isset($_POST['btnrequest'])){
						
						
						$requestid=$_POST['btnrequest'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						if($cur_user[0]['mv_user_type']==1){
							
							// update status 0 = approved, 1 = pending
							$tablename="mv_request";
							$data = "mv_request_status = ?   WHERE mv_request_id = ?";
							$array = array(0,$requestid);
							$result= $db->update($tablename,$data,$array);
							
							// get request_activity
							$activity = $db->where('mv_request_activity','mv_request','mv_request_id',$requestid);
							$request_activity = $activity[0]['mv_request_activity'];
							
							if($request_activity == 1){
								
								//to get request coin details
			                 	$request = $db->where('*','mv_request','mv_request_id',$requestid);
			                 	$request_amt = $request[0]['mv_request_amt'];
			                 	
			                 	//to get user wallet balance
			                 	$user = $db->where('*','mv_wallet','mv_user_id',$request[0]['mv_user_id']);
			                 	$user_amt = $user[0]['mv_wallet_amt'];
			                 	
								
								if($request_amt >= 0){
									
									
									$after_with_amt = $user_amt + $request_amt;
									
									$tablename="mv_wallet";
									$data = "mv_wallet_amt = ?   WHERE mv_user_id = ?";
									$array = array($after_with_amt,$request[0]['mv_user_id']);
									$result= $db->update($tablename,$data,$array);
									
									
									
									//insert to log
            						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
            						
            						$col = "max(mv_request_id) as table_id"; //to get table id
                    	            $tb = "mv_request";
                    	            $opt = 1;
                    	            $table = $db->get($col,$tb,$opt);
                    	            $table_id = $requestid;
                    	            
            						$log_arr = array(2,$tb,$table_id,$time,$id);
            						$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									
									}else{
									die("Amount cannot be negative");
								}
								
								
			                    }else{
								die("request_activity not Request V-Coins");
							}
							
							
							
						}
						else{
							die("you are not user");
						}
						
						
					}
				}
				
					else if($type=="pendingmerchant"){
					header('Location:userlist.php');
					if(isset($_POST['btnmerchant'])){
						
						
						$userid=$_POST['btnmerchant'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						if($cur_user[0]['mv_user_type']==1){
							
							// update status 0 = approved, 1 = pending
							$tablename="mv_user";
							$data = "mv_user_status = ?   WHERE mv_user_id = ?";
							$array = array(1,$userid);
							$result= $db->update($tablename,$data,$array);
							
							$tb="mv_user";
							$result2= $db->where('*',$tb,'mv_user_id',$userid);
							$username=$result2[0]['mv_user_name'];
							$useremail=$result2[0]['mv_user_email'];
							$password=$result2[0]['mv_user_pword'];
							
							$key = 'mumuls1314';
							
							$encpass = $password;
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
							
						
					
							
							if($result){
							    
							
                                	//send mail
										require 'PHPMailer/PHPMailerAutoload.php';
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
                                        
                                        $mail->Subject = 'Register Successfull';
                                        $mail->Body = 'Username:'.$username.'<br> Password:'.$decpass.'<br> <br>Your account have been activated <br> http://www.ezypartners.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
        						}
							
							
							
						}
						else{
							die("you are not user");
						}
						
						
					}
				}
				
					else if($type=="pendingmerchantsale"){
					header('Location:sale.php');
					if(isset($_POST['btnmerchant'])){
						
						
						$userid=$_POST['btnmerchant'];
						
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
							if (file_exists("img/merchantreceipt/" . $_FILES["file"]["name"]))
							{
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/merchantreceipt/" . $newfilename);
								
							}
							
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						$sale=$db->where('*','mv_wallet','mv_user_id',$userid);
						$pendingsale=$db->where('*','mv_wallet','mv_user_id',$userid);
						$walletid=$db->where('*','mv_wallet','mv_user_id',$userid);
						
						$totalsale=$sale[0]['mv_wallet_amt']+$pendingsale[0]['mv_wallet_pending_amt'];
						
						if($cur_user[0]['mv_user_type']==1){
								if ((!($_FILES['file']['name']))){
						
							$tablename="mv_wallet";
							$data = "mv_wallet_amt = ? ,mv_wallet_pending_amt = ?    WHERE mv_user_id = ?";
							$array = array($totalsale,0,$userid);
							$result= $db->update($tablename,$data,$array);
							
						
							$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
							$array = array($pendingsale[0]['mv_wallet_pending_amt'],6,$date,1,$walletid[0]['mv_wallet_id'],0,0);
							$db->insert1('mv_transaction',$colname,$array);
						
							
						
					
							
								}
								else
								{
							$tablename="mv_wallet";
							$data = "mv_wallet_amt = ? ,mv_wallet_pending_amt = ?    WHERE mv_user_id = ?";
							$array = array($totalsale,0,$userid);
							$result= $db->update($tablename,$data,$array);
							
						
							$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_transaction_img","mv_wallet_id","mv_user_id","mv_request_id");
							$array = array($pendingsale[0]['mv_wallet_pending_amt'],6,$date,1,$newfilename,$walletid[0]['mv_wallet_id'],0,0);
							$db->insert1('mv_transaction',$colname,$array);
								    
								}
							
							
							
						}
						else{
							die("you are not admin");
						}
						
						
					}
				}
				
				else if($type=="pendingsellersale"){
					header('Location:sale.php');
					if(isset($_POST['btnseller'])){
						
						
						$userid=$_POST['btnseller'];
						
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
							if (file_exists("img/merchantreceipt/" . $_FILES["file"]["name"]))
							{
							}
							else
							{
								$temp = explode(".", $_FILES["file"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/merchantreceipt/" . $newfilename);
								
							}
							
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						$sale=$db->where('*','mv_wallet','mv_user_id',$userid);
						$pendingsale=$db->where('*','mv_wallet','mv_user_id',$userid);
						$walletid=$db->where('*','mv_wallet','mv_user_id',$userid);
						
						$totalsale=$sale[0]['mv_wallet_amt']+$pendingsale[0]['mv_wallet_pending_amt'];
						
						if($cur_user[0]['mv_user_type']==1){
								if ((!($_FILES['file']['name']))){
						
							$tablename="mv_wallet";
							$data = "mv_wallet_amt = ? ,mv_wallet_pending_amt = ?    WHERE mv_user_id = ?";
							$array = array($totalsale,0,$userid);
							$result= $db->update($tablename,$data,$array);
							
						
							$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
							$array = array($pendingsale[0]['mv_wallet_pending_amt'],7,$date,1,$walletid[0]['mv_wallet_id'],0,0);
							$db->insert1('mv_transaction',$colname,$array);
						
							
						
					
							
								}
								else
								{
							$tablename="mv_wallet";
							$data = "mv_wallet_amt = ? ,mv_wallet_pending_amt = ?    WHERE mv_user_id = ?";
							$array = array($totalsale,0,$userid);
							$result= $db->update($tablename,$data,$array);
							
						
							$colname = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_transaction_img","mv_wallet_id","mv_user_id","mv_request_id");
							$array = array($pendingsale[0]['mv_wallet_pending_amt'],7,$date,1,$newfilename,$walletid[0]['mv_wallet_id'],0,0);
							$db->insert1('mv_transaction',$colname,$array);
								    
								}
							
							
							
						}
						else{
							die("you are not admin");
						}
						
						
					}
				}
				
				else if($type=="pendingwithdraw"){
					header('Location:pending.php');
					if(isset($_POST['btnwithdraw'])){
						
						
						$requestid=$_POST['btnwithdraw'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						if($cur_user[0]['mv_user_type']==1){
							
							
							// get request_activity
							$activity = $db->where('mv_request_activity','mv_request','mv_request_id',$requestid);
							$request_activity = $activity[0]['mv_request_activity'];
							
							if($request_activity == 3){
								
								$tablename="mv_request";
								$data = "mv_request_status = ?   WHERE mv_request_id = ?";
								$array = array(0,$requestid);
								$result= $db->update($tablename,$data,$array);
								
								//to get withdraw details
								$withdraw = $db->where('*','mv_request','mv_request_id',$requestid);
								$with_amt = $withdraw[0]['mv_request_amt'];
								
								//to get user wallet balance
								$user = $db->where('*','mv_wallet','mv_user_id',$withdraw[0]['mv_user_id']);
								$user_amt = $user[0]['mv_wallet_amt'];
								
								
								if($user_amt >= $with_amt){
									$after_with_amt = $user_amt - $with_amt;
				                 	
									$tablename="mv_wallet";
									$data = "mv_wallet_amt = ?   WHERE mv_user_id = ?";
									$array = array($after_with_amt,$withdraw[0]['mv_user_id']);
									$result= $db->update($tablename,$data,$array);
									
									//insert to log
            						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
            						
            						$col = "max(mv_request_id) as table_id"; //to get table id
                    	            $tb = "mv_request";
                    	            $opt = 1;
                    	            $table = $db->get($col,$tb,$opt);
                    	            $table_id = $requestid;
                    	            
            						$log_arr = array(2,$tb,$table_id,$time,$id);
            						$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									
				                 	}else{
									die("Wallet balance no enough");
								}
								
			                    }else{
								die("request_activity not Withdraw");
							}    
						}
						else{
							die("you are not user");
						}
						
						
					}
				}
				
				else if($type=="pendingredeem"){
					header('Location:pending.php');
					if(isset($_POST['btnredeem'])){
						
						
						$requestid=$_POST['btnredeem'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						if($cur_user[0]['mv_user_type']==1){
							
							// get request_activity
							$activity = $db->where('mv_request_activity','mv_request','mv_request_id',$requestid);
							$request_activity = $activity[0]['mv_request_activity'];
							
							if($request_activity == 2){
								
								$request=$db->where('*','mv_request','mv_request_id',$requestid);
								$userid=$request[0]['mv_user_id'];
								
								$user=$db->where('*','mv_user','mv_user_id',$userid);
								$remainuserpoint=$user[0]['mv_user_redeem'] - $request[0]['mv_request_amt'];
								
								$col = "*";
								$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
								$chkcol = "mv_user.mv_user_id";
								$opt = $userid;
								$wallet= $db->where($col,$tb,$chkcol,$opt);
								$remainwalletamt=$wallet[0]['mv_wallet_amt'] + $request[0]['mv_request_amt'];
								
								$tablename="mv_user";
								$data = "mv_user_redeem = ?   WHERE mv_user_id = ?";
								$array = array($remainuserpoint,$userid);
								$result= $db->update($tablename,$data,$array);
								
								$tablename="mv_wallet";
								$data = "mv_wallet_amt = ?   WHERE mv_user_id = ?";
								$array = array($remainwalletamt,$userid);
								$result= $db->update($tablename,$data,$array);
								
								$tablename="mv_request";
								$data = "mv_request_status = ?   WHERE mv_request_id = ?";
								$array = array(0,$requestid);
								$result= $db->update($tablename,$data,$array);
								
								$tb = "mv_transaction";
								$data = array('mv_transaction_amt','mv_transaction_activity','mv_transaction_date','mv_transaction_status','mv_wallet_id','mv_user_id','mv_request_id');
								$arr = array($request[0]['mv_request_amt'],4,$date,1,$wallet[0]['mv_wallet_id'],$userid,$request[0]['mv_request_id']);
								$db->insert1($tb,$data,$arr);
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_transaction_id) as table_id"; //to get table id
                	            $tb = "mv_transaction";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $request[0]['mv_request_id'];
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
			                    }else{
								die("request_activity not Redeem");
							} 
						}
						else{
							die("you are not admin");
						}
						
						
					}
				}
				
				else if($type=="changestatus"){
					header('Location:orderlist.php');
					if(isset($_POST['btnAction'])){
						
						// 0 = pending, 1 = approved, 2 = deliver, 3 = cancelled, 4 = complete
						
						$orderid = $_POST['btnAction'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
    				        $col = "*";
    				        $tb = "mv_order";
    				        $chkcol = "mv_order_id";
    				        $order = $db->where($col,$tb,$chkcol,$orderid);
    				        $status = $order[0]['mv_order_status'];
    				        $userid = $order[0]['mv_user_id'];
    				        
    				        $col = "*";
                            $tb_name = "mv_package";
                            $chkcol = "mv_package_id";
                            $opt = $order[0]['mv_package_id'];
                            $package = $db->where($col,$tb_name,$chkcol,$opt);
                            $commission = $package[0]['mv_package_commission'];
    				        
    				        if($status == 0){
								$tablename="mv_order";
								$data = "mv_order_status = ?   WHERE mv_order_id = ?";
								$array = array(1,$orderid);
								$result= $db->update($tablename,$data,$array);
    				            
								}else if($status == 1){
								
								// now wholesaler is get payment when complete order, so no need this.
								//to get all order item from that order
								// $tb = 'mv_order_item JOIN mv_order ON mv_order_item.mv_order_id = mv_order.mv_order_id';
								// $col="*";
								// $opt= 'mv_order_item.mv_order_id = ?';
								// $arr=array($orderid);
								// $orderlist = $db->advwhere($col,$tb,$opt,$arr);
								
								// foreach ($orderlist as $orderitem){
								    
								    
								//     // to get user id of that item
    				// 			    $col = "*";
        //                             $tb_name = "mv_item";
        //                             $chkcol = "mv_item_id";
        //                             $opt = $orderitem['mv_item_id'];  //item id
        //                             $item = $db->where($col,$tb_name,$chkcol,$opt);
                                    
        //                             $seller_id = $item[0]['mv_user_id'];
                                    
        //                             // qty of the item
        //                             $item_qty = $orderitem['mv_order_item_qty'];
                                    
        //                             // price(unit) per item
        //                             $item_price = $orderitem['mv_order_item_unit'];
                                    
        //                             // total price of the order item
        //                             $total_price = $item_qty * $item_price;
                                    
        //                             // get seller wallet
        //                             $seller_wallet = $db->where('*','mv_wallet','mv_user_id',$seller_id);
        //                             $seller_pending_wallet = $seller_wallet[0]['mv_wallet_pending_amt'];
        //                             $seller_wallet_id = $seller_wallet[0]['mv_wallet_id'];
                                    
        //                             // get added wallet amount
        //                             $new_pending_wallet = $seller_pending_wallet + $total_price;
                                    
        //                             // the item price add to seller's pending wallet
        //                             $tablename="mv_wallet";
    				// 				$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
    				// 				$array = array($new_pending_wallet,$seller_id);
    				// 				$result= $db->update($tablename,$data,$array);
    								
        //                         	$tb = "mv_transaction";
        //                         	$data1 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
        //                         	$arr = array($total_price,11,$date,1,$seller_wallet_id,$userid,0);
        //                         	$db->insert1($tb,$data1,$arr);
								// }
							    
    				            
								$tablename="mv_order";
								$data = "mv_order_status = ? , mv_order_deliverydate = ? WHERE mv_order_id = ?";
								$array = array(2,$time,$orderid);
								$result= $db->update($tablename,$data,$array);
								
								
								
								
								// function getPoint($level=0, $parentID=null)
								// {
								// 	global $db;
								// 	global $commission;
									
								// 	if($parentID != 0){
										
								// 		// Create the query
								// 		$col = "*";
								// 		$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_wallet_id";
								// 		$chkcol = "mv_wallet.mv_user_id";
								// 		$opt = intval($parentID);
								// 		// Execute the query and go through the results.
								// 		$result = $db->where($col,$tb,$chkcol,$opt);
								// 		if($result)
								// 		{
								// 			$row = $result[0];
								// 			$cur_user_status = $row['mv_user_status'];
								// 			if($cur_user_status == 1 && $level!=0){
								// 				$cur_vcoin = $row['mv_wallet_amt'];
								// 				$new_vcoin = $cur_vcoin + $commission;
								// 				$tb_name = "mv_wallet";
								// 				$data = "mv_wallet_amt = ? WHERE mv_user_id = ?";
								// 				$arr = array($new_vcoin,$parentID);
								// 				$db->update($tb_name,$data,$arr);
								// 			}
											
								// 			if($level < 8){
								// 				getPoint($level+1, $row['mv_user_referral']);
								// 			}
								// 		}
								// 		else {
								// 			//die("Failed to execute query! ($level / $parentID)");
								// 		}
                                        
								// 	}
									
								// }
								
								// getPoint(0,$order[0]['mv_user_id']);
								
								}else if($status == 2){
    				            
    				            $tablename="mv_order";
				                $data = "mv_order_status = ? WHERE mv_order_id = ?";
			                  	$array = array(4,$orderid);
			                 	$result= $db->update($tablename,$data,$array);
    				            
    				            $getemail = $db->where('*','mv_user','mv_user_id',$userid);
								$useremail= $getemail[0]['mv_user_email'];
								
									//send mail
										require 'PHPMailer/PHPMailerAutoload.php';
                                        $mail = new PHPMailer;
                                        $mail->isSMTP();
                                        $mail->Host = 'mail.mrvege777.com';
                                        $mail->SMTPAuth = true;
                                        $mail->Username = 'system@ezylife2u.com';
                                        $mail->Password = 'i[qxHPuH2_EC';
                                        $mail->SMTPSecure = '';
                                        $mail->Port = '587';        	
                                        
                                        $mail->setFrom('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addReplyTo('system@ezylife2u.com','Ezylife2u System');
                                        $mail->addAddress($order[0]['mv_order_baddr']); 
                                        
                                        
                                        $mail->isHTML(true);
                                        
                                        $mail->Subject = 'Your Order is Delivered';
                                        $mail->Body = 'Your Order Detail <br> Package Name:'.$package[0]['mv_package_name'].'<br>Package Price:'.$package[0]['mv_package_price'].'<br><br> Any problem please access the link below <br> http://ezylife2u.com/';
                                        if(!$mail->send()) {
                                            echo 'Message could not be sent.';
                                            echo 'Mailer Error: ' . $mail->ErrorInfo;
                                        } else {
                                            echo 'Message has been sent';
                                        }
								
								
								$level=0;
								$parentID = $order[0]['mv_user_id'];
								$buyerid = $order[0]['mv_user_id'];
								
								//get rebate for user themselve
    				            $col = "*";
								$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
								$chkcol = "mv_wallet.mv_user_id";
								$opt = $buyerid; 
								$result = $db->where($col,$tb,$chkcol,$opt);
								$row = $result[0];
								$cur_user_status = $row['mv_user_status'];
								
    							if($cur_user_status == 1){
    								$cur_vcoin = $row['mv_wallet_pending_amt'];
    								$new_vcoin = $cur_vcoin + $commission;
    								$tb_name = "mv_wallet";
    								$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
    								$arr = array($new_vcoin,$buyerid);
    								$db->update($tb_name,$data,$arr);
    								
    								//Add Transaction Record
    
                                	$wallet = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$buyerid);
                                	$receiver_wallet = $wallet[0]['mv_wallet_id'];
                                	
                                	$tb = "mv_transaction";
                                	$data1 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
                                	$arr = array($commission,5,$date,1,$receiver_wallet,$buyerid,0);
                                	$db->insert1($tb,$data1,$arr);
    								
    							}
								
								do{
 
								        // Create the query
    									$col = "*";
    									$tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
    									$chkcol = "mv_wallet.mv_user_id";
    									$opt = $parentID; 
    								    // Execute the query and go through the results.
    									$result = $db->where($col,$tb,$chkcol,$opt);
    								    
    								    
    								    if($result)
    									{
    										$row = $result[0];
    										$cur_user_status = $row['mv_user_status'];
    										if($cur_user_status == 1 && $level!=0){
    											$cur_vcoin = $row['mv_wallet_pending_amt'];
    											$new_vcoin = $cur_vcoin + $commission;
    											$tb_name = "mv_wallet";
    											$data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
    											$arr = array($new_vcoin,$parentID);
    											$db->update($tb_name,$data,$arr);
    											
												//Add Transaction Record
	
                                            	$wallet = $db->where('mv_wallet_id','mv_wallet','mv_user_id',$parentID);
                                            	$receiver_wallet = $wallet[0]['mv_wallet_id'];
                                            	
                                            	$tb = "mv_transaction";
                                            	$data1 = array("mv_transaction_amt","mv_transaction_activity","mv_transaction_date","mv_transaction_status","mv_wallet_id","mv_user_id","mv_request_id");
                                            	$arr = array($commission,5,$date,1,$receiver_wallet,$buyerid,0);
                                            	$db->insert1($tb,$data1,$arr);
    											
    										}
    										
    										    $parentID = $row['mv_user_referral'];
    									}
								       
							
								    
								    $level++;
								     
								}while($level < $default['mv_default_max_layer'] && ($parentID != NULL || $parentID != 0 || $parentID = '') );
    				            
    				            

    				            
    				            
    				            //send email write here
								
							}
    				        else{
								die("order status cannot be other");
							}
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_order_id) as table_id"; //to get table id
            	            $tb = "mv_order";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $orderid;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				else if($type=="cancelorder"){
					header('Location:orderlist.php');
					if(isset($_POST['btnCancel'])){
						
						
						$orderid = $_POST['btnCancel'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
    				        $col = "*";
    				        $tb = "mv_order";
    				        $chkcol = "mv_order_id";
    				        $order = $db->where($col,$tb,$chkcol,$orderid);
    				        $status = $order[0]['mv_order_status'];
    				        
    				        
    				        // admin can cancel order when the order is pending or approved
    				        if($status == 0 || $status == 1){
								
								//get pacakge point and price
								$package = $db->where("mv_package_point","mv_package","mv_package_id",$order[0]['mv_package_id']);
								$cancelpoint = $package[0]['mv_package_point'];
								$cancelprice = $order[0]['mv_order_price'];
								
								//get order user point and redeem
								$user = $db->where('*','mv_user','mv_user_id',$order[0]['mv_user_id']);
								$user_point = $user[0]['mv_user_point'];
								$user_redeem = $user[0]['mv_user_redeem'];
								
								//get order user wallet
								$wallet = $db->where('*','mv_wallet','mv_user_id',$order[0]['mv_user_id']);
								$user_wallet = $wallet[0]['mv_wallet_amt'];
								$user_spend = $wallet[0]['mv_spend'];
								
								
								$after_cancel_point = $user_point - $cancelpoint;
								$after_cancel_redeem = $user_redeem - $cancelpoint;
								$after_cancel_wallet = $user_wallet + $cancelprice;
								$after_cancel_spend = $user_spend - $cancelprice;
								
								//To restore item qty
								$col = "*";
								$tb = "mv_order_item";
								$opt = $orderid;
								$item_list = $db->where($col,$tb,'mv_order_id',$opt);
								foreach($item_list as $key){
									
									// item amount to cancel
									$cancel_qty = $key['mv_order_item_qty'];
									// item id that to cancel
									$cancel_id = $key['mv_item_id'];
									
									//get now item inventory
									$itemqty = $db->where($col,'mv_item','mv_item_id',$cancel_id);
									$inventory = $itemqty[0]['mv_item_amt'];
									
									$inventory_after_cancel = $inventory + $cancel_qty;
									
									$tablename="mv_item";
									$data = "mv_item_amt = ?   WHERE mv_item_id = ?";
									$array = array($inventory_after_cancel,$cancel_id);
									$result= $db->update($tablename,$data,$array);
									
								}
								
								// update point and redeem
								$tablename="mv_user";
								$data = "mv_user_point = ?, mv_user_redeem = ?  WHERE mv_user_id = ?";
								$array = array($after_cancel_point,$after_cancel_redeem,$order[0]['mv_user_id']);
								$result= $db->update($tablename,$data,$array);
								
								// update wallet
								$tablename="mv_wallet";
								$data = "mv_wallet_amt = ? , mv_spend =?  WHERE mv_user_id = ?";
								$array = array($after_cancel_wallet,$after_cancel_spend,$order[0]['mv_user_id']);
								$result= $db->update($tablename,$data,$array);
								
								$tablename="mv_order";
								$data = "mv_order_status = ?   WHERE mv_order_id = ?";
								$array = array(3,$orderid);
								$result= $db->update($tablename,$data,$array);
								
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_order_id) as table_id"; //to get table id
                	            $tb = "mv_order";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $orderid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
								
    				            
							}
    				        else{
								die("other status cannot to cancel order");
							}
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				
				else if($type=="usercancelorder"){
					header('Location:checkorder.php');
					if(isset($_POST['userbtnCancel'])){
						
						
						$orderid = $_POST['userbtnCancel'];
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type'] == 2){
							
							
    				        $col = "*";
    				        $tb = "mv_order";
    				        $chkcol = "mv_order_id";
    				        $order = $db->where($col,$tb,$chkcol,$orderid);
    				        $status = $order[0]['mv_order_status'];
    				        
    				        // user can cancel order when the order is pending
    				        if($status == 0){
								
								//get pacakge point and price
								$package = $db->where("mv_package_point","mv_package","mv_package_id",$order[0]['mv_package_id']);
								$cancelpoint = $package[0]['mv_package_point'];
								$cancelprice = $order[0]['mv_order_price'];
								
								//get order user point and redeem
								$user = $db->where('*','mv_user','mv_user_id',$order[0]['mv_user_id']);
								$user_point = $user[0]['mv_user_point'];
								$user_redeem = $user[0]['mv_user_redeem'];
								
								//get order user wallet
								$wallet = $db->where('*','mv_wallet','mv_user_id',$order[0]['mv_user_id']);
								$user_wallet = $wallet[0]['mv_wallet_amt'];
								$user_spend = $wallet[0]['mv_spend'];
								
								
								$after_cancel_point = $user_point - $cancelpoint;
								$after_cancel_redeem = $user_redeem - $cancelpoint;
								$after_cancel_wallet = $user_wallet + $cancelprice;
								$after_cancel_spend = $user_spend - $cancelprice;
								
								
								//To restore item qty
								$col = "*";
								$tb = "mv_order_item";
								$opt = $orderid;
								$item_list = $db->where($col,$tb,'mv_order_id',$opt);
								foreach($item_list as $key){
									
									// item amount to cancel
									$cancel_qty = $key['mv_order_item_qty'];
									// item id that to cancel
									$cancel_id = $key['mv_item_id'];
									
									//get now item inventory
									$itemqty = $db->where($col,'mv_item','mv_item_id',$cancel_id);
									$inventory = $itemqty[0]['mv_item_amt'];
									
									$inventory_after_cancel = $inventory + $cancel_qty;
									
									$tablename="mv_item";
									$data = "mv_item_amt = ?   WHERE mv_item_id = ?";
									$array = array($inventory_after_cancel,$cancel_id);
									$result= $db->update($tablename,$data,$array);
									
								}
								
								// update point and redeem
								$tablename="mv_user";
								$data = "mv_user_point = ?, mv_user_redeem = ?  WHERE mv_user_id = ?";
								$array = array($after_cancel_point,$after_cancel_redeem,$order[0]['mv_user_id']);
								$result= $db->update($tablename,$data,$array);
								
								// update wallet
								$tablename="mv_wallet";
								$data = "mv_wallet_amt = ? , mv_spend =? WHERE mv_user_id = ?";
								$array = array($after_cancel_wallet,$after_cancel_spend,$order[0]['mv_user_id']);
								$result= $db->update($tablename,$data,$array);
								
								$tablename="mv_order";
								$data = "mv_order_status = ?   WHERE mv_order_id = ?";
								$array = array(3,$orderid);
								$result= $db->update($tablename,$data,$array);
								
								//insert to log
        						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
        						
        						$col = "max(mv_order_id) as table_id"; //to get table id
                	            $tb = "mv_order";
                	            $opt = 1;
                	            $table = $db->get($col,$tb,$opt);
                	            $table_id = $orderid;
                	            
        						$log_arr = array(2,$tb,$table_id,$time,$id);
        						$log = $db->insert1('mv_log',$log_col,$log_arr);
    				            
							}
    				        else{
								die("You can only cancel this order when it is pending. And other status cannot to cancel order");
							}
							
    				        }else{
							die("you are not user");
						}
					}
				}
				
				
				else if($type=="editlayer"){
					header('Location:index.php');
					if(isset($_POST['btnEdit'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
							$new_max = $_POST['max_num'];
							
							// update wallet
							$tablename="mv_default";
							$data = "mv_default_max_layer = ? ";
							$array = array($new_max);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				
				
				else if($type=="editref"){
					header('Location:index.php');
					if(isset($_POST['btnEditRef'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
							$new_max = $_POST['max_num'];
							
							// update wallet
							$tablename="mv_default";
							$data = "mv_default_max_ref = ? ";
							$array = array($new_max);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				
				else if($type=="edit_merchant_rebate"){
					header('Location:index.php');
					if(isset($_POST['btnEditRebate'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
							$new_rebate_rate = $_POST['rebate_rate'];
							
							// update table
							$tablename="mv_default";
							$data = "mv_default_merchant_rebate = ? ";
							$array = array($new_rebate_rate);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				
				else if($type=="editanno"){

					if(isset($_POST['btnEditAnno'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
							
							
							$new_anno = $_POST['announcement'];
							
							// update default
							$tablename="mv_default";
							$data = "mv_default_anno = ? ";
							$array = array($new_anno);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
    						if($result){
    						    echo "<script>alert(\"Edit Successful\");
								window.location.href='index.php';</script>";
    						}
    						
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				else if($type=="editslide1"){

					if(isset($_POST['btnEditSlide1'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
					
					
						$temp = explode(".", $_FILES["fileslide1"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["fileslide1"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/landing/" . $_FILES["fileslide1"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["fileslide1"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["fileslide1"]["tmp_name"], "img/landing/" . $newfilename);
								
							}
						}


							// update default
							$tablename="mv_default";
							$data = "mv_pic1 = ? ";
							$array = array($newfilename);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
    						if($result){
    						    echo "<script>alert(\"Edit Successful\");
								window.location.href='index.php';</script>";
    						}
    						
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				else if($type=="editslide2"){

					if(isset($_POST['btnEditSlide2'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
					
					
						$temp = explode(".", $_FILES["fileslide2"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["fileslide2"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/landing/" . $_FILES["fileslide2"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["fileslide2"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["fileslide2"]["tmp_name"], "img/landing/" . $newfilename);
								
							}
						}


							// update default
							$tablename="mv_default";
							$data = "mv_pic2 = ? ";
							$array = array($newfilename);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
    						if($result){
    						    echo "<script>alert(\"Edit Successful\");
								window.location.href='index.php';</script>";
    						}
    						
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				else if($type=="editslide3"){

					if(isset($_POST['btnEditSlide3'])){
						
						
						
						
						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						if($cur_user[0]['mv_user_type']==1){
					
					
						$temp = explode(".", $_FILES["fileslide3"]["name"]);
						$extension = end($temp);
						$extension = strtolower($extension);
						if ($_FILES["fileslide3"]["error"] > 0)
						{
							echo "<script>alert('error');</script>";
						}
						else 
						{
							
							$fileName = $temp[0].".".$temp[1];
							$temp[0] = rand(0, 3000); //Set to random number
							$fileName;
							
							if (file_exists("/img/landing/" . $_FILES["fileslide3"]["name"]))
							{
								echo "<script>alert('exist');</script>";
							}
							else
							{
								$temp = explode(".", $_FILES["fileslide3"]["name"]);
								$newfilename = round(microtime(true)) . '.' . end($temp);
								move_uploaded_file($_FILES["fileslide3"]["tmp_name"], "img/landing/" . $newfilename);
								
							}
						}


							// update default
							$tablename="mv_default";
							$data = "mv_pic3 = ? ";
							$array = array($newfilename);
							$result= $db->update($tablename,$data,$array);
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_default_id) as table_id"; //to get table id
            	            $tb = "mv_default";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = 1;
            	            
    						$log_arr = array(2,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
    						
    						if($result){
    						    echo "<script>alert(\"Edit Successful\");
								window.location.href='index.php';</script>";
    						}
    						
							
							
    				        }else{
							die("you are not admin");
						}
					}
				}
				
				/*	else if($type=="deletecategory"){
					header('Location:catelist.php');
					if(isset($_POST['btndeletecategory'])){
					$productid=$_POST['btndeletecategory'];
					
					$getid = $db->where('*','mv_product','mv_product_id',$productid);
					$getid = $getid[0];
					$pid=$getid['mv_product_id'];
					
					$column = "*";
					$tb = "mv_user";
					$chkcol = "mv_user_id";
					$opt1 = $_SESSION['id'];
					$cur_user = $db->where($column,$tb,$chkcol,$opt1);
					
					if($cur_user[0]['mv_user_type']==1){
					
					$result=$db->del('mv_product','mv_product_id',$pid);
					}
					else if($cur_user[0]['mv_user_type']==2){
					die('you are not admin');
					}
					}
					}
					
					
					
					else if($type=="deleteuser"){
					header('Location:userlist.php');
					if(isset($_POST['btndeleteuser'])){
					$userid=$_POST['btndeleteuser'];
					
					$getid = $db->where('*','mv_user','mv_user_id',$userid);
					$getid = $getid[0];
					$uid=$getid['mv_user_id'];
					
					$column = "*";
					$tb = "mv_user";
					$chkcol = "mv_user_id";
					$opt1 = $_SESSION['id'];
					$cur_user = $db->where($column,$tb,$chkcol,$opt1);
					
					if($cur_user[0]['mv_user_type']==1){
					
					$result=$db->del('mv_user','mv_user_id',$uid);
					}
					else if($cur_user[0]['mv_user_type']==2){
					die('you are not admin');
					}
					}
					}
					
					else if($type=="deletesubcategory"){
					header('Location:catelist.php');
					if(isset($_POST['btndeletesubcategory'])){
					$subproductid=$_POST['btndeletesubcategory'];
					
					$getid = $db->where('*','mv_sub_product','mv_sub_product_id',$subproductid);
					$getid = $getid[0];
					$sid=$getid['mv_sub_product_id'];
					
					$column = "*";
					$tb = "mv_user";
					$chkcol = "mv_user_id";
					$opt1 = $_SESSION['id'];
					$cur_user = $db->where($column,$tb,$chkcol,$opt1);
					
					if($cur_user[0]['mv_user_type']==1){
					
					$result=$db->del('mv_sub_product','mv_sub_product_id',$sid);
					}
					else if($cur_user[0]['mv_user_type']==2){
					die('you are not admin');
					}
					}
				}*/
				
				
				else if($type=="deleteitem"){
					header('Location:itemlist.php');
					if(isset($_POST['btndeleteitem'])){
						$itemid=$_POST['btndeleteitem'];
						
						$getid = $db->where('*','mv_item','mv_item_id',$itemid);
						$getid = $getid[0];
						$iid=$getid['mv_item_id'];
						
	           	        $column = "*";
    				    $tb = "mv_user";
    				    $chkcol = "mv_user_id";
    				    $opt1 = $_SESSION['id'];
    				    $cur_user = $db->where($column,$tb,$chkcol,$opt1);
    				    
    				    if($cur_user[0]['mv_user_type']==1){
    				        
							$result=$db->del('mv_item','mv_item_id',$iid);
							
							
							
							//insert to log
    						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
    						
    						$col = "max(mv_item_id) as table_id"; //to get table id
            	            $tb = "mv_item";
            	            $opt = 1;
            	            $table = $db->get($col,$tb,$opt);
            	            $table_id = $iid;
            	            
    						$log_arr = array(3,$tb,$table_id,$time,$id);
    						$log = $db->insert1('mv_log',$log_col,$log_arr);
							
							
							
						}
    				    else if($cur_user[0]['mv_user_type']==2){
							die('you are not admin');
						}
					}
				}
				/*
			    	else if($type=="deletepackage"){
					header('Location:packagelist.php');
					if(isset($_POST['btndeletepackage'])){
					$packageid=$_POST['btndeletepackage'];
					
					$getid = $db->where('*','mv_package','mv_package_id',$packageid);
					$getid = $getid[0];
					$pid=$getid['mv_package_id'];
					
					$column = "*";
					$tb = "mv_user";
					$chkcol = "mv_user_id";
					$opt1 = $_SESSION['id'];
					$cur_user = $db->where($column,$tb,$chkcol,$opt1);
					
					if($cur_user[0]['mv_user_type']==1){
					
					$result=$db->del('mv_package','mv_package_id',$pid);
					}
					else if($cur_user[0]['mv_user_type']==2){
					die('you are not admin');
					}
					}
				}*/
				if($type=="userregister"){
					if($success=="1"){
						if(isset($_POST['btnsubmituser'])){
							$username = $_POST['uname'];
							$username = preg_replace('/\s+/', '', $username);
							$password = $_POST['password'];
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
								move_uploaded_file($_FILES["file"]["tmp_name"], "img/userprofile/" . $newfilename);
								
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
									
									
									
									if($result1 && $result2 ){
										echo "<script>alert(\"SUCCESSFUL\");
										window.location.href='login.php';</script>";
									}
        							else{
										echo "<script>alert(\"fail\");
										window.location.href='login.php';</script>";
									}
								}
								else{
									echo "<script>alert(\"name existing\");
									window.location.href='login.php';</script>";
								}
								
							}
							else{
								echo "<script>alert(\"the maximum referrer is over 7\");
								window.location.href='login.php';</script>";
							}
						}
					}
				}
				
			}
		}
		else{
			echo "Token Expired. Please Try Again";
		}
	}
	
	else{
		echo "Token Is Required.";
	}
	
	
?>
