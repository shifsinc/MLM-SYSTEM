<?php
	require_once("../connection/PDO_db_function.php");
	$db = new DB_Functions();
	
	
	$col = "*";
	$tb = "mv_default";
	$opt = 1;
	$default = $db->get($col,$tb,$opt);
	if($default){
		$default = $default[0];
		}else{
		exit('Default Setting Is Empty!');
	}
	
	if(isset($_REQUEST['type'])){
		$type = $_REQUEST['type'];
		
		if($type=='check_ref'){
			
			$ref_id = $_POST['ref_id'];
			
			if($ref_id == ''){
				$col = "*";
				$tb = "mv_user";
				$chkcol = "mv_user_referral";
				$opt = $_SESSION['id'];
				
				$ref_count = $db->where($col,$tb,$chkcol,$opt);
				
				$ref_count = count($ref_count);
    			
				if($ref_count<$default['mv_default_max_ref']){
					$status = true;
					$msg = "Referrer Code Is Available";
					}else{
					$status = false;
					$msg = "Referrer Has Reached The Maximum Referee";
				}
				}else{
				$col = "*";
				$tb = "mv_user";
				$chkcol = "mv_user_code";
				$opt = $ref_id;
				
				$result = $db->where($col,$tb,$chkcol,$opt);
				
				if(empty($result)){
					$status = false;
					$msg = "Referrer Code Is Not Exist";
					}else{
					
					$referrer_id = $result[0]['mv_user_id'];
					$referrer_name = $result[0]['mv_user_fullname'];
					
					$chkcol = "mv_user_referral";
					$ref_count = $db->where($col,$tb,$chkcol,$referrer_id);
					
					$ref_count = count($ref_count);
					
					if($ref_count<$default['mv_default_max_ref']){
						$status = true;
						$msg = "The user fullname is &nbsp".$referrer_name;
						}else{
						$status = false;
						$msg = "Referrer Has Reached The Maximum Referee";
					}
					
				}
			}
			
		}
		
		if($type=='check_user'){
			
			$user_id = $_POST['user_id'];
			
			$col = "*";
			$tb = "mv_user";
			$chkcol = "mv_user_name";
			$opt = $user_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Username Is Exist";
				}else{
				
				$status = true;
				$msg = "Username Is Available";
				
			}
		}
		
		if($type=='check_user_ajax'){
			
			$user_id = $_POST['user_id'];
			
			$col = "*";
			$tb = "mv_user";
			$chkcol = "mv_user_name";
			$opt = $user_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Username Is Exist";
				}else{
				
				$status = true;
				$msg = "Username Is Available";
				
			}
		}
		
		if($type=='check_category'){
			
			$category_id = $_POST['category_id'];
			
			$col = "*";
			$tb = "mv_product";
			$chkcol = "mv_product_name";
			$opt = $category_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = true;
				$msg = "category Is Available";
				}else{
				
				$status = false;
				$msg = "category  Is not Available";
				
			}
		}
		
		if($type=='check_item'){
			
			$item_id = $_POST['item_id'];
			
			$col = "*";
			$tb = "mv_item";
			$chkcol = "mv_item_name";
			$opt = $item_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Item Is not Available";
				}else{
				
				$status = true;
				$msg = "Item  Is Available";
				
			}
		}
		
		if($type=='check_item_ajax'){
			
			$item_id = $_POST['item_id'];
			
			$col = "*";
			$tb = "mv_item";
			$chkcol = "mv_item_name";
			$opt = $item_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Item Is not Available";
				}else{
				
				$status = true;
				$msg = "Item  Is Available";
				
			}
		}
		
		if($type=='check_categoryname'){
			
			$categoryname_id = $_POST['categoryname_id'];
			
			$col = "*";
			$tb = "mv_product";
			$chkcol = "mv_product_name";
			$opt = $categoryname_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Category Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Category Name Is Availeble";
				
			}
		}
		
		if($type=='check_categoryname_ajax'){
			
			$categoryname_id = $_POST['categoryname_id'];
			
			$col = "*";
			$tb = "mv_product";
			$chkcol = "mv_product_name";
			$opt = $categoryname_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Category Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Category Name Is Availeble";
				
			}
		}
		
		if($type=='check_subcategoryname'){
			
			$subcategoryname_id = $_POST['subcategoryname_id'];
			
			$col = "*";
			$tb = "mv_sub_product";
			$chkcol = "mv_sub_product_name";
			$opt = $subcategoryname_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Sub_Category Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Sub_Category Name Is Availeble";
				
			}
		}
		
		if($type=='check_subcategoryname_ajax'){
			
			$subcategoryname_id = $_POST['subcategoryname_id'];
			
			$col = "*";
			$tb = "mv_sub_product";
			$chkcol = "mv_sub_product_name";
			$opt = $subcategoryname_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Sub_Category Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Sub_Category Name Is Availeble";
				
			}
		}
		
		if($type=='check_packagename'){
			
			$packagename_id = $_POST['packagename_id'];
			
			$col = "*";
			$tb = "mv_package";
			$chkcol = "mv_package_name";
			$opt = $packagename_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Package Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Package Name Is Availeble";
				
			}
		}
		
		if($type=='check_packagename_ajax'){
			
			$packagename_id = $_POST['packagename_id'];
			
			$col = "*";
			$tb = "mv_package";
			$chkcol = "mv_package_name";
			$opt = $packagename_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			
			if(count($result) != 0){
				$status = false;
				$msg = "Package Name Is Exist";
				}else{
				
				$status = true;
				$msg = "Package Name Is Availeble";
				
			}
		}
		
			if($type=='check_refname'){
			
			$ref_id = $_POST['ref_id'];
			
				$col = "*";
				$tb = "mv_user";
				$chkcol = "mv_user_code";
				$opt = $ref_id;
			
			$result = $db->where($col,$tb,$chkcol,$opt);
			$referrer_name = $result[0]['mv_user_fullname'];
			if(count($result) != 0){
				$status = true;
				$msg = "The Referrer fullname is &nbsp".$referrer_name;
				
				}else{
				
				$status = false;
				$msg = "Referrer Code Is Not Exist";
				
				
			}
		}

		
		}else{
		$status = false;
		$msg = "Missing Validation Type";
	}
	$arr = array('Status'=>$status,'Msg'=>$msg);
	echo json_encode($arr);
?>