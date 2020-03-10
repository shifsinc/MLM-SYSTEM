<?php
require_once('../connection/PDO_db_function.php');
$db = new DB_FUNCTIONS();
require_once('../inc/level_controller.php');
if(isset($_REQUEST['type'])){
	$type = $_REQUEST['type'];
    $postedToken = filter_input(INPUT_POST, 'token');
    if(!empty($postedToken)){
        
    	if(isTokenValid($postedToken)){
    		if($type=='slcPac'){
    		    header('Location: ../itemgrid.php');
    		    if(isset($_POST['btnSelfSelect'])){
    		        $pac_type = 1;
    		    }
    		    if(isset($_POST['btnFoodBank'])){
    		        $pac_type = 2;
    		    }
    		    if(isset($_POST['btnRandomFood'])){
    		        $pac_type = 3;
    		    }
    		    $package_id = $_POST['package'];
    		    
    		    if($_SESSION['pac_id'] == NULL ){
    		        
    		        $_SESSION['pac_id'] = $package_id;
    		        $_SESSION['pac_type'] = $pac_type;
    		        
    		    }else if($_SESSION['pac_id'] != $package_id ){
    		        
		            unset($_SESSION['cart']);
    		        unset($_SESSION['pac_id']);
    		        unset($_SESSION['price']);
    		        
    		        $_SESSION['pac_id'] = $package_id;
    		        
    		    }
    		    
    		      
    		    
    		}else if($type=='addItems'){
        	    $item_id = $_POST['item_id'];
        	    $item_qty = $_POST['item_qty'];
        	    
        	    //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $max_ava_unit = $package[0]['mv_package_unit'];
        	    
        	    $package_ori_price = $package[0]['mv_package_price'];
        	    $package_user_id = $package[0]['mv_user_id'];
        	    
        	    $reload = 2;
        	    
        	    //get user state id
        	    $user_id = $_SESSION['id'];
        	    $user_state = $db->where("mv_state_id","mv_user_state","mv_user_id",$user_id);
                $user_state = $user_state[0]['mv_state_id'];
        	    
        	    //Get Item In Array
        	    $col = "*";
        	    $tb = "mv_item";
        	    $opt = 1;
        	    $item_list = $db->get($col,$tb,$opt);
        	    $item = array();
        	    foreach($item_list as $key){
        	        $item[$key['mv_item_id']] = array("amt"=>$key['mv_item_amt'],"unit"=>$key['mv_item_unit'],"status"=>$key['mv_item_status']);
        	    }
        	    //Check IF SESSION Exist
        	    if(isset($_SESSION['cart'])){
        	        $cart = $_SESSION['cart'];
        	        $used_unit = $cart['unit'];
        	        $adding_unit = $item_qty * $item[$item_id]['unit'];
        	        $total_unit = $used_unit + $adding_unit;
        	       // if($total_unit<=$max_ava_unit){
        	       //     if(isset($cart['item'][$item_id])){
        	       //         $item_qty = $item_qty + $cart['item'][$item_id];
            	   //     }else{
            	   //         $item_qty = $item_qty;
            	   //     }
            	   //     if($item[$item_id]['amt'] >= $item_qty){
            	   //         $json_arr = array('Status'=>true,'Unit'=>$total_unit);
            	   //         $_SESSION['cart']['item'][$item_id] = $item_qty;
            	   //         $_SESSION['cart']['unit'] = $total_unit;
            	   //     }else{
            	   //         $json_arr = array('Status'=>false,'Msg'=>'Stock Is Not Enough!');
            	   //     }
    	           // }else{
    	           //     $json_arr = array('Status'=>false,'Msg'=>'Exceeded Your Max Available Unit!');
    	           // }
    	           
    	                if($total_unit >= $package_ori_price){
    	                    
    	                    
							$tb = 'mv_package join mv_package_state on mv_package.mv_package_id = mv_package_state.mv_package_id';
							$col= "*";
							$opt= 'mv_package.mv_user_id =? AND mv_package_state.mv_state_id =? AND mv_package.mv_package_id !=? ORDER BY mv_package.mv_package_price ASC';
							$arr= array($package_user_id,$user_state,$_SESSION['pac_id']);
							$check_package = $db->advwhere($col,$tb,$opt,$arr);
    	                    
                            if(count($check_package) != 0){
                                

                                $no_of_package = count($check_package);
                                $status = true;
                                $no = 0;
                                
                                do{
                                    
                                    $this_package_price = $check_package[$no]['mv_package_price'];
                                    
                                    if($this_package_price > $package_ori_price){
                                        
                                        if($total_unit >= $this_package_price){
                                            
                                            $_SESSION['pac_id'] = $check_package[$no]['mv_package_id'];
                                            $status = false;
                                            $reload = 1;
                                            
                                        }else{
                                            
                                            $status = true;
                                            $no++;
                                        }
                                        
                                        if($no > $no_of_package){
                                            $status = false;
                                        }
                                        
                                    }else{
                                        
                                        $status = true;
                                        $no++;
                                        
                                        if($no > $no_of_package){
                                            $status = false;
                                        }
                                    }
                                    
                                    
                                }while($status);
                                
                            }

    	                    
    	                    
    	                }  
    	               

        	            if(isset($cart['item'][$item_id])){
        	                $item_qty = $item_qty + $cart['item'][$item_id];
            	        }else{
            	            $item_qty = $item_qty;
            	        }
            	        if(($item[$item_id]['amt'] >= $item_qty) && ($reload == 1)){
            	            $json_arr = array('Status'=>true,'Unit'=>$total_unit,'Reload'=>true);
            	            $_SESSION['cart']['item'][$item_id] = $item_qty;
            	            $_SESSION['cart']['unit'] = $total_unit;
            	            
            	        }else if(($item[$item_id]['amt'] >= $item_qty) && ($reload == 2)){
            	            $json_arr = array('Status'=>true,'Unit'=>$total_unit,'Reload'=>false);
            	            $_SESSION['cart']['item'][$item_id] = $item_qty;
            	            $_SESSION['cart']['unit'] = $total_unit;
            	            
            	        }else{
            	            $json_arr = array('Status'=>false,'Msg'=>'Stock Is Not Enough!');
            	        }

        	        
        	    }else{
        	        if($item[$item_id]['amt'] >= $item_qty){
        	            $total_unit = $item_qty * $item[$item_id]['unit'];
        	           // if($total_unit<=$max_ava_unit){
        	           //     $json_arr = array('Status'=>true,'Unit'=>$total_unit);
        	           //     $_SESSION['cart'] = array('item'=>array($item_id=>$item_qty),'unit'=>$total_unit);
        	           // }else{
        	           //     $json_arr = array('Status'=>false,'Msg'=>'Exceeded Your Max Available Unit!');
        	           // }
        	           
                            if($reload == 1){
                                
                                $json_arr = array('Status'=>true,'Unit'=>$total_unit,'Reload'=>true);
                                
                            }else{
                                
                                $json_arr = array('Status'=>true,'Unit'=>$total_unit,'Reload'=>false);
                            }
        	                
        	                $_SESSION['cart'] = array('item'=>array($item_id=>$item_qty),'unit'=>$total_unit);

        	            
        	        }else{
        	            $json_arr = array('Status'=>false,'Msg'=>'Stock Is Not Enough!');
        	        }
        	    }
        	    
        	     //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $package_price = $package[0]['mv_package_price'];
        	    $_SESSION['price'] = $package_price;
        	    
        	     $cart = $_SESSION['cart'];
        	    if($cart['unit'] > $package_price){
        	        $package_price = $cart['unit'];
        	        $_SESSION['price'] = $package_price;

        	    }
        	    
        	    $json_arr['Token'] = $token;
        	    echo json_encode($json_arr);
        	    

        	    
    		}else if($type=='editItems'){
        	    $item_id = $_POST['item_id'];
        	    $item_qty = $_POST['item_qty'];
        	    
        	    //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $max_ava_unit = $package[0]['mv_package_unit'];
        	    //Get Item In Array
        	    $col = "*";
        	    $tb = "mv_item";
        	    $opt = 1;
        	    $item_list = $db->get($col,$tb,$opt);
        	    $item = array();
        	    foreach($item_list as $key){
        	        $item[$key['mv_item_id']] = array("amt"=>$key['mv_item_amt'],"unit"=>$key['mv_item_unit'],"status"=>$key['mv_item_status']);
        	    }
        	    //Check IF SESSION Exist
    	        $cart = $_SESSION['cart'];
    	        $used_unit = $cart['unit'];
    	        $current_unit = $cart['item'][$item_id] * $item[$item_id]['unit'];
    	        $new_unit = $item_qty * $item[$item_id]['unit'];
    	        $total_unit = $used_unit - ($current_unit - $new_unit);
    	       // if($total_unit<=$max_ava_unit){
        	   //     if($item[$item_id]['amt'] >= $item_qty){
        	   //         $json_arr = array('Status'=>true,'Unit'=>$total_unit);
        	   //         $_SESSION['cart']['item'][$item_id] = $item_qty;
        	   //         $_SESSION['cart']['unit'] = $total_unit;
        	   //     }else{
        	   //         $json_arr = array('Status'=>false,'Msg'=>'Stock Is Not Enough!');
        	   //     }
	           // }else{
	           //     $json_arr = array('Status'=>false,'Msg'=>'Exceeded Your Max Available Unit!');
	           // }
	           

        	        if($item[$item_id]['amt'] >= $item_qty){
        	            $json_arr = array('Status'=>true,'Unit'=>$total_unit);
        	            $_SESSION['cart']['item'][$item_id] = $item_qty;
        	            $_SESSION['cart']['unit'] = $total_unit;
        	        }else{
        	            $json_arr = array('Status'=>false,'Msg'=>'Stock Is Not Enough!');
        	        }

           	     //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $package_price = $package[0]['mv_package_price'];
        	    $_SESSION['price'] = $package_price;
        	    
        	   
        	    if($cart['unit'] > $package_price){
        	        $package_price = $cart['unit'];
        	        $_SESSION['price'] = $package_price;

        	    }
        	        
        	        
        	    $json_arr['Token'] = $token;
        	    echo json_encode($json_arr);
        	    
        	    
    		}else if($type=='removeItems'){
        	    $item_id = $_POST['item_id'];
        	    
        	    //Get Item In Array
        	    $col = "*";
        	    $tb = "mv_item";
        	    $opt = 1;
        	    $item_list = $db->get($col,$tb,$opt);
        	    $item = array();
        	    foreach($item_list as $key){
        	        $item[$key['mv_item_id']] = array("amt"=>$key['mv_item_amt'],"unit"=>$key['mv_item_unit'],"status"=>$key['mv_item_status']);
        	    }
        	    //Check IF SESSION Exist
    	        $cart = $_SESSION['cart'];
    	        $used_unit = $cart['unit'];
    	        $current_unit = $cart['item'][$item_id] * $item[$item_id]['unit'];
    	        $total_unit = $used_unit - $current_unit;
    	        
	            $json_arr = array('Status'=>true,'Unit'=>$total_unit);
	            unset($_SESSION['cart']['item'][$item_id]);
	            $_SESSION['cart']['unit'] = $total_unit;
	            
        	     //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $package_price = $package[0]['mv_package_price'];
        	    $_SESSION['price'] = $package_price;
        	    
        	   
        	    if($cart['unit'] > $package_price){
        	        $package_price = $cart['unit'];
        	        $_SESSION['price'] = $package_price;

        	    }
        	        
        	    $json_arr['Token'] = $token;
        	    echo json_encode($json_arr);
    		}else if($type=='checkout'){
    		    header('Location: ../logo_cate.php');
        	    $item_id = $_POST['item_id'];
        	    $item_qty = $_POST['item_qty'];
        	    $order_address = $_POST['address1'];
        	    $order_state = $_POST['state'];
        	    $order_baddr = $_POST['address2'];
        	    $order_city = $_POST['city'];
        	    $order_postcode = $_POST['postcode'];
        	    
        	    //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $package_price = $package[0]['mv_package_price'];
        	    $package_user = $package[0]['mv_user_id'];
        	    $pacakge_delivery_fee = $package[0]['mv_package_deli'];
        	    $wholesaler_id = $package[0]['mv_user_id'];
        	    
        	    $tb = "mv_user";
        	    $chkcol = "mv_user_id";
        	    $opt = $package_user;
        	    $user = $db->where($col,$tb,$chkcol,$opt);
        	    $useremail=$user[0]['mv_user_email'];
        	    $_SESSION['price'] = $package_price;
        	    
        	    
        	    //Check IF SESSION Exist
        	    $cart = $_SESSION['cart'];
        	    if($cart['unit'] > $package_price){
        	        $package_price = $cart['unit'];
        	        $_SESSION['price'] = $package_price;

        	    }
        	    
        	    $col = "*";
			    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
			    $chkcol = "mv_user.mv_user_id";
			    $opt = $_SESSION['id'];
			    $user_det = $db->where($col,$tb,$chkcol,$opt);
			    if(empty($user_det)){
			        $remain_amt = 0;
			        $remain_spend = 0;
			    }else{
			        $remain_amt = $user_det[0]['mv_wallet_amt'];
			        $remain_spend = $user_det[0]['mv_spend'];
			    }
			    
			    if($remain_amt >= ($package_price + $pacakge_delivery_fee)){
        	    
        	        $err = 0;
        	        if($_SESSION['pac_type']==1 || $_SESSION['pac_type']==3){
        	    
                	    $max_ava_unit = $package[0]['mv_package_unit'];
                	    
                	    //Get Item In Array
                	    $col = "*";
                	    $tb = "mv_item";
                	    $opt = 1;
                	    $item_list = $db->get($col,$tb,$opt);
                	    $item = array();
                	    foreach($item_list as $key){
                	        $item[$key['mv_item_id']] = array("amt"=>$key['mv_item_amt'],"unit"=>$key['mv_item_unit'],"status"=>$key['mv_item_status']);
                	    }
                	    //Check IF SESSION Exist
            	        $cart = $_SESSION['cart'];
            	        $total_unit = 0;
            	        
            	        foreach($cart['item'] as $key=>$data){
            	            if($item[$key]['status']==0){
            	                $err = 2;
            	            }
            	            if($data > $item[$key]['amt']){
            	                $err = 3;
            	            }
            	        }
            	       // if($max_ava_unit < $cart['unit']){
            	       //     $err = 4;
            	       // }
            	        
            	        if($err == 0){
            	            
            	            $tb = "mv_order";
            	            $data = array("mv_order_date","mv_order_type","mv_order_price","mv_order_unit","mv_user_id","mv_package_id","mv_order_status","mv_order_addr","mv_order_state","mv_order_baddr","mv_order_city","mv_order_postcode","mv_order_pay_type");
            	            $arr = array($date,$_SESSION['pac_type'],($package_price+$pacakge_delivery_fee),$package[0]['mv_package_unit'],$_SESSION['id'],$_SESSION['pac_id'],0,$order_address,$order_state,$order_baddr,$order_city,$order_postcode,1);
            	            $db->insert1($tb,$data,$arr);
            	            
            	            $tablename="mv_user";
            	            $userid = $_SESSION['id'];
					        $data = "mv_user_addr = ? , mv_user_state = ? , mv_user_baddr = ? , mv_user_city = ? , mv_user_postcode = ?  WHERE mv_user_id = ?";
				            $array = array($order_address,$order_state,$order_baddr,$order_city,$order_postcode,$userid);
				            $result= $db->update($tablename,$data,$array);
				            
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
                                            
                                            $mail->Subject = 'New Order';
                                            $mail->Body = 'You have a new order <br> Package Name :'.$package[0]['mv_package_name'].'<br> Package Price:'.$package[0]['mv_package_price'].'<br> Date : '.$date.' <br>Please login your account at this link below <br> http://ezypartners.com/';
                                            if(!$mail->send()) {
                                                echo 'Message could not be sent.';
                                                echo 'Mailer Error: ' . $mail->ErrorInfo;
                                            } else {
                                                echo 'Message has been sent';
                                            }
            	            
            	            
            	            //get order id
            	            $col = "max(mv_order_id) as max_id";
            	            $tb = "mv_order";
            	            $opt = 1;
            	            $order = $db->get($col,$tb,$opt);
            	            $max_id = $order[0]['max_id'];
            	            
            	           foreach($cart['item'] as $key=>$data){
            	               
            	                $data = (int)$data;
            	               
                	           $remain_item = $item[$key]['amt'] - $data;
                	           
                	           $itemunit = $item[$key]['unit'];
                	           $itemid = $item[$key]['id'];
                	           
                	           $item_desc = $db->where('mv_item_desc','mv_item','mv_item_id',$key);
                	           $item_desc = $item_desc[0]['mv_item_desc'];
                	           
                	           
                	           //Update Item
                	           $tb = "mv_item";
                	           $tb_data = "mv_item_amt = ? WHERE mv_item_id = ?";
                	           $arr = array($remain_item,$key);
                	           $db->update($tb,$tb_data,$arr);
                	           
                	           //Insert Into Order
                	           $tb = "mv_order_item";
                	           $tb_data = array('mv_order_item_qty','mv_order_item_unit','mv_item_id','mv_order_id','mv_order_item_desc');
                	           $arr = array($data,$itemunit,$key,$max_id,$item_desc);
                	           $db->insert1($tb,$tb_data,$arr);
                	       } 
                	       
                	        
                	       
            	        }
    	            
        	        }else{
        	            $tb = "mv_order";
        	            $data = array("mv_order_date","mv_order_type","mv_order_price","mv_order_unit","mv_user_id","mv_package_id","mv_order_status","mv_order_addr","mv_order_baddr","mv_order_state","mv_order_postcode","mv_order_city","mv_order_pay_type");
        	            $arr = array($date,$_SESSION['pac_type'],($package_price+$pacakge_delivery_fee),$package[0]['mv_package_unit'],$_SESSION['id'],$_SESSION['pac_id'],0,'FoodBank','','','','',1);
        	            $db->insert1($tb,$data,$arr);
        	            
        	          
            	            
        	        }
        	        
        	        if($err == 0){
            	        
            	        
            	        
            	        //Edit User point
            	        $col = "*";
			            $tb = "mv_user";
			            $chkcol = "mv_user_id";
			            $opt = $_SESSION['id'];
			            $user_info = $db->where($col,$tb,$chkcol,$opt);
			            $remain_redeem = $user_info[0]['mv_user_redeem'] + $package[0]['mv_package_point'];
			            $remain_point  = $user_info[0]['mv_user_point'] + $package[0]['mv_package_point'];
            	        $tb = "mv_user";
            	        $data = "mv_user_point = ? , mv_user_redeem = ? WHERE mv_user_id = ?";
            	        $arr = array($remain_point,$remain_redeem,$_SESSION['id']);
            	        $db->update($tb,$data,$arr);
            	        
            	        //Add Transaction Record
            	        $tb = "mv_transaction";
            	        $data = array('mv_transaction_amt','mv_transaction_activity','mv_transaction_date','mv_transaction_status','mv_wallet_id','mv_user_id','mv_request_id');
            	        $arr = array(($package_price+$pacakge_delivery_fee),3,$date,1,0,$_SESSION['id'],0);
            	        $db->insert1($tb,$data,$arr);
            	        
            	        $user_spend = $remain_spend + ($package_price + $pacakge_delivery_fee);
            	        $remain_vcoin = $remain_amt - ($package_price + $pacakge_delivery_fee);
            	        $tb = "mv_wallet";
            	        $data = "mv_wallet_amt = ? , mv_spend =? WHERE mv_user_id = ?";
            	        $arr = array($remain_vcoin,$user_spend,$_SESSION['id']);
            	        $db->update($tb,$data,$arr);
            	        
            	        //user pay to wholeasaler
            	        $col = "*";
        			    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
        			    $chkcol = "mv_user.mv_user_id";
        			    $opt = $wholesaler_id;
        			    $wholesaler = $db->where($col,$tb,$chkcol,$opt);
        			    $wholesaler_wallet = $wholesaler[0];
        			    
            	        $wholesaler_wallet_amt = $wholesaler_wallet['mv_wallet_pending_amt'];
            	        
            	        // add balance to wholesaler's wallet
            	        $added_wholesaler_wallet_amt = $wholesaler_wallet_amt + ($package_price + $pacakge_delivery_fee);
            	        
            	        $tb = "mv_wallet";
            	        $data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
            	        $arr = array($added_wholesaler_wallet_amt,$wholesaler_id);
            	        $db->update($tb,$data,$arr);
            	        
            	        
            	        unset($_SESSION['pac_id']);
        	            unset($_SESSION['pac_type']);
        	            if(isset($_SESSION['cart'])){
        	                unset($_SESSION['cart']);
        	            }
        	        
        	        }
    	            
			    }else{
			        $err = 1;
			    }
    		}else if($type=='online_checkout'){
    		  //  header('Location: ../package.php');
        	    $item_id = $_POST['item_id'];
        	    $item_qty = $_POST['item_qty'];
        	    $order_address = $_POST['address1'];
        	    $order_state = $_POST['state'];
        	    $order_baddr = $_POST['address2'];
        	    $order_city = $_POST['city'];
        	    $order_postcode = $_POST['postcode'];
        	    
        	    //Get Package
        	    $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $_SESSION['pac_id'];
        	    $package = $db->where($col,$tb,$chkcol,$opt);
        	    $package_price = $package[0]['mv_package_price'];
        	    $pacakge_delivery_fee = $package[0]['mv_package_deli'];
        	    $wholesaler_id = $package[0]['mv_user_id'];
        	    $_SESSION['price'] = $package_price;
        	    
        	    
        	    //Check IF SESSION Exist
        	    $cart = $_SESSION['cart'];
        	    if($cart['unit'] > $package_price){
        	        $package_price = $cart['unit'];
        	        $_SESSION['price'] = $package_price;

        	    }
        	    
        	    $col = "*";
			    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
			    $chkcol = "mv_user.mv_user_id";
			    $opt = $_SESSION['id'];
			    $user_det = $db->where($col,$tb,$chkcol,$opt);
			    if(empty($user_det)){
			        $remain_amt = 0;
			        $remain_spend = 0;
			    }else{
			        $remain_amt = $user_det[0]['mv_wallet_amt'];
			        $remain_spend = $user_det[0]['mv_spend'];
			    }
			    
			    
        	    
        	        $err = 0;
        	        if($_SESSION['pac_type']==1 || $_SESSION['pac_type']==3){
        	    
                	    $max_ava_unit = $package[0]['mv_package_unit'];
                	    
                	    //Get Item In Array
                	    $col = "*";
                	    $tb = "mv_item";
                	    $opt = 1;
                	    $item_list = $db->get($col,$tb,$opt);
                	    $item = array();
                	    foreach($item_list as $key){
                	        $item[$key['mv_item_id']] = array("amt"=>$key['mv_item_amt'],"unit"=>$key['mv_item_unit'],"status"=>$key['mv_item_status']);
                	    }
                	    //Check IF SESSION Exist
            	        $cart = $_SESSION['cart'];
            	        $total_unit = 0; //no use
            	        
            	        foreach($cart['item'] as $key=>$data){
            	            if($item[$key]['status']==0){
            	                $err = 2;
            	            }
            	            if($data > $item[$key]['amt']){
            	                $err = 3;
            	            }
            	        }
            	       // if($max_ava_unit < $cart['unit']){
            	       //     $err = 4;
            	       // }
            	        
            	        if($err == 0){
            	            
            	            $tb = "mv_order";
            	            $data = array("mv_order_date","mv_order_type","mv_order_price","mv_order_unit","mv_user_id","mv_package_id","mv_order_status","mv_order_addr","mv_order_state","mv_order_baddr","mv_order_city","mv_order_postcode","mv_order_pay_type");
            	            $arr = array($date,$_SESSION['pac_type'],($package_price + $pacakge_delivery_fee),$package[0]['mv_package_unit'],$_SESSION['id'],$_SESSION['pac_id'],0,$order_address,$order_state,$order_baddr,$order_city,$order_postcode,2);
            	            $db->insert1($tb,$data,$arr);
            	            
            	            $tablename="mv_user";
            	            $userid = $_SESSION['id'];
					        $data = "mv_user_addr = ? , mv_user_state = ? , mv_user_baddr = ? , mv_user_city = ? , mv_user_postcode = ?  WHERE mv_user_id = ?";
				            $array = array($order_address,$order_state,$order_baddr,$order_city,$order_postcode,$userid);
				            $result= $db->update($tablename,$data,$array);
            	            
            	            
            	            //get order id
            	            $col = "max(mv_order_id) as max_id";
            	            $tb = "mv_order";
            	            $opt = 1;
            	            $order = $db->get($col,$tb,$opt);
            	            $max_id = $order[0]['max_id'];
            	            
            	           foreach($cart['item'] as $key=>$data){
            	               
            	                $data = (int)$data;
            	               
                	           $remain_item = $item[$key]['amt'] - $data;
                	           
                	           $itemunit = $item[$key]['unit'];
                	           $itemid = $item[$key]['id'];
                	           
                	           $item_desc = $db->where('mv_item_desc','mv_item','mv_item_id',$key);
                	           $item_desc = $item_desc[0]['mv_item_desc'];
                	           
                	           
                	           //Update Item
                	           $tb = "mv_item";
                	           $tb_data = "mv_item_amt = ? WHERE mv_item_id = ?";
                	           $arr = array($remain_item,$key);
                	           $db->update($tb,$tb_data,$arr);
                	           
                	           //Insert Into Order
                	           $tb = "mv_order_item";
                	           $tb_data = array('mv_order_item_qty','mv_order_item_unit','mv_item_id','mv_order_id','mv_order_item_desc');
                	           $arr = array($data,$itemunit,$key,$max_id,$item_desc);
                	           $db->insert1($tb,$tb_data,$arr);
                	       } 
                	       
                	        
                	       
            	        }
    	            
        	        }else{
        	            $tb = "mv_order";
        	            $data = array("mv_order_date","mv_order_type","mv_order_price","mv_order_unit","mv_user_id","mv_package_id","mv_order_status","mv_order_addr","mv_order_baddr","mv_order_state","mv_order_postcode","mv_order_city","mv_order_pay_type");
        	            $arr = array($date,$_SESSION['pac_type'],($package_price + $pacakge_delivery_fee),$package[0]['mv_package_unit'],$_SESSION['id'],$_SESSION['pac_id'],0,'FoodBank','','','','',2);
        	            $db->insert1($tb,$data,$arr);
        	            
        	          
            	            
        	        }
        	        
        	        if($err == 0){
            	        
            	        
            	        
            	        
            	        //Add Transaction Record
            	        $tb = "mv_transaction";
            	        $data = array('mv_transaction_amt','mv_transaction_activity','mv_transaction_date','mv_transaction_status','mv_wallet_id','mv_user_id','mv_request_id');
            	        $arr = array(($package_price+$pacakge_delivery_fee),3,$date,1,0,$_SESSION['id'],0);
            	        $db->insert1($tb,$data,$arr);

            	        $user_spend = $remain_spend + ($package_price+$pacakge_delivery_fee);
            	        $tb = "mv_wallet";
            	        $data = "mv_spend =? WHERE mv_user_id = ?";
            	        $arr = array($user_spend,$_SESSION['id']);
            	        $db->update($tb,$data,$arr);
            	        
            	        //user pay to wholeasaler
            	        $col = "*";
        			    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
        			    $chkcol = "mv_user.mv_user_id";
        			    $opt = $wholesaler_id;
        			    $wholesaler = $db->where($col,$tb,$chkcol,$opt);
        			    $wholesaler_wallet = $wholesaler[0];
        			    
            	        $wholesaler_wallet_amt = $wholesaler_wallet['mv_wallet_pending_amt'];
            	        
            	        // add balance to wholesaler's wallet
            	        $added_wholesaler_wallet_amt = $wholesaler_wallet_amt + ($package_price + $pacakge_delivery_fee);
            	        
            	        $tb = "mv_wallet";
            	        $data = "mv_wallet_pending_amt = ? WHERE mv_user_id = ?";
            	        $arr = array($added_wholesaler_wallet_amt,$wholesaler_id);
            	        $db->update($tb,$data,$arr);

            	        unset($_SESSION['pac_id']);
        	            unset($_SESSION['pac_type']);
        	            if(isset($_SESSION['cart'])){
        	                unset($_SESSION['cart']);
        	            }
        	        
        	        }
    	            
    	            echo "PAYMENT SUCCESSFUL";

    		}else if($type=="online_topup"){

						
		        	    $topup_amt = $_POST['topup'];

						$col = "*";
						$tb = "mv_user";
						$chkcol = "mv_user_id";
						$opt = $_SESSION['id'];
						$cur_user = $db->where($col,$tb,$chkcol,$opt);
						
						
						if($cur_user[0]['mv_user_type']==2){
		
                                $user_id = $_SESSION['id'];
			                 	//to get user wallet balance
			                 	$user = $db->where('*','mv_wallet','mv_user_id',$user_id);
			                 	$user_amt = $user[0]['mv_wallet_amt'];
			                 	
								
								if($topup_amt >= 0){
									
									
									$after_with_amt = $user_amt + $topup_amt;
									
									$tablename="mv_wallet";
									$data = "mv_wallet_amt = ?  WHERE mv_user_id = ?";
									$array = array($after_with_amt,$user_id);
									$result= $db->update($tablename,$data,$array);
									
			            	        //Add Transaction Record
                        	        $tb = "mv_transaction";
                        	        $data = array('mv_transaction_amt','mv_transaction_activity','mv_transaction_date','mv_transaction_status','mv_wallet_id','mv_user_id','mv_request_id');
                        	        $arr = array($topup_amt,10,$date,1,0,$_SESSION['id'],0);
                        	        $db->insert1($tb,$data,$arr);
            									
									$time=date('Y-m-d H:i:s'); 
									//insert to log
            						$log_col = array("mv_log_type","mv_log_table","mv_log_table_id","mv_log_datetime","mv_user_id");
            
            						$log_arr = array(1,'mv_wallet_online top up_view user id',$user_id,$time,$user_id);
            						$log = $db->insert1('mv_log',$log_col,$log_arr);
									
									
									}else{
									die("Amount cannot be negative");
								}
								

							
						}
						else{
							die("you are not user");
						}
						
						
					
				}
    		
    		else if($type=='removePackage'){
    		    header('Location: ../logo_cate.php');
    		    if(isset($_POST['btnRemovePackage'])){
    		        unset($_SESSION['cart']);
    		        unset($_SESSION['pac_id']);
    		        unset($_SESSION['pac_type']);
    		        unset($_SESSION['price']);
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
