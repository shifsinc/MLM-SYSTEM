<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
	$user = $db->where('*','mv_user','mv_user_id',$id);
    $user = $user[0];
    
    $user1 = $db->where('*','mv_wallet','mv_user_id',$id);
    $user1 = $user1[0];
     $pointname = $db->get('mv_default_point_name','mv_default',1);
    $point = $pointname[0]['mv_default_point_name'];


    $addr = $user["mv_user_addr"];
    if( ($addr == NULL) || ($addr == "") )
    {
        $useraddr = "This is new member, no address yet.";
    }else
    {
        $useraddr = $user["mv_user_addr"];
    }
    
    $passport = $user["mv_user_passport"];
    if( ($passport == NULL) || ($passport == "") )
    {
        $userpass = "Please insert the passport number.";
    }else
    {
        $userpass = $user["mv_user_passport"];
    }
    
    $beneficiary_name = $user["mv_beneficiary_name"];
    if( ($beneficiary_name == NULL) || ($beneficiary_name == "") )
    {
        $beneficiaryname = "";
    }else
    {
        $beneficiaryname = $user["mv_beneficiary_name"];
    }
    
    $beneficiary_ic = $user["mv_beneficiary_ic"];
    if( ($beneficiary_ic == NULL) || ($beneficiary_ic == "") || ($beneficiary_ic == 0) )
    {
        $beneficiaryic = "";
    }else
    {
        $beneficiaryic = $user["mv_beneficiary_ic"];
    }
    
    $beneficiary_phnum = $user["mv_beneficiary_phnum"];
    if( ($beneficiary_phnum == NULL) || ($beneficiary_phnum == "") || ($beneficiary_phnum == 0) )
    {
        $beneficiaryphnum = "";
    }else
    {
        $beneficiaryphnum = $user["mv_beneficiary_phnum"];
    }
    
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">User Details</h4>
	
</div>
<div class="modal-body">
	
	
	<div class="ibox-content">
		<table class="table">
			<thead>
				<tr>
					<th>
					</th>
					<th>                                   
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>User Code</td>
					<td><?php echo $user["mv_user_code"]; ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo $user["mv_user_fullname"]; ?></td>
				</tr>
				<tr>
					<td>Username (login)</td>
					<td><?php echo $user["mv_user_name"]; ?></td>
				</tr>
				<tr>
					<td>Join Date</td>
					<td><?php echo $user["mv_user_createdate"]; ?></td>
				</tr>
				<?php
				    
				    $usertype = $user["mv_user_type"];
				    if($usertype == 1){
				        $show = "Admin";
				    }else if($usertype == 2){
				        $show = "User";
				    }else if($usertype == 3){
				        $show = "WholeSeller";
				    }else if($usertype == 4){
				        $show = "Merchant";
				    }
 
				?>
				<tr>
					<td>User Type</td>
					<td><?php echo $show; ?></td>
				</tr>
				<tr>
					<td>NRIC</td>
					<td><?php echo $user["mv_user_ic"]; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $user["mv_user_email"]; ?></td>
				</tr>
				
				<?php 
    			    $referrer = $user["mv_user_referral"];
    			    $result = $db->where('*','mv_user','mv_user_id',$referrer);
    			    $result = $result[0];
    			    
    			     $open = $user["mv_merchant_start_time"];
                                    $close = $user["mv_merchant_end_time"];
                                    
                                    $open = strtotime($open);
                                    $close = strtotime($close);
                                    
                                    $open = date('H:i', $open); 
                                    $close = date('H:i', $close);
    			    
    			?>
					<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<tr>
					<td>Referral</td>
					<td><?php echo $result["mv_user_fullname"]; ?></td>
				</tr>
				<tr>
					<td>Referral Code</td>
					<td><?php echo $result["mv_user_code"]; ?></td>
				</tr>
					<?php }?>
				<tr>
					<td>Address</td>
					<td><i class="fa fa-map-marker"></i>  <?php echo $useraddr ?></td>
				</tr>
				<tr>
					<td>Phone number</td>
					<td><?php echo $user["mv_user_phnum"]; ?></td>
				</tr>
				<tr>
					<td><?php echo $point; ?></td>
					<td><?php echo $user1["mv_wallet_amt"]; ?></td>
				</tr>
				<tr>
					<td>Pending Wallet</td>
					<td><?php echo $user1["mv_wallet_pending_amt"]; ?></td>
				</tr>
				<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<tr>
					<td>Percentage</td>
					<td><?php echo $user["mv_user_point"]; ?>%</td>
				</tr>
					<?php }?>
				<tr>
					<td>Passport</td>
					<td><?php echo $userpass; ?></td>
				</tr>
					<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<tr>
					<td>Beneficiary Name</td>
					<td><?php echo $beneficiaryname; ?></td>
				</tr>
				<tr>
					<td>Beneficiary NRIC</td>
					<td><?php echo $beneficiaryic; ?></td>
				</tr>
				<tr>
					<td>Beneficiary Phone Number</td>
					<td><?php echo $beneficiaryphnum; ?></td>
				</tr>
					<?php }?>
						<?php if ($user["mv_user_type"] == 3){ ?>
				<tr>
					<td>Main Category</td>
					<td><?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_category JOIN mv_user_category ON mv_category.mv_category_id=mv_user_category.mv_category_id';
											$result = $db->where('*',$tb,'mv_user_category.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_category_name"].',';
												}
												?></td>
				</tr>
					<tr>
					<td>Item Category</td>
					<td><?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_product JOIN mv_user_product ON mv_product.mv_product_id=mv_user_product.mv_product_id';
											$result = $db->where('*',$tb,'mv_user_product.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_product_name"].',';
												}
												?></td>
				</tr>
					<?php }?>
						<?php if ($user["mv_user_type"] == 4){ ?>
					<tr>
					<td>Category</td>
					<td><?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_product JOIN mv_user_product ON mv_product.mv_product_id=mv_user_product.mv_product_id';
											$result = $db->where('*',$tb,'mv_user_product.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_product_name"];
												}
												?></td>
				</tr>
				<tr>
					<td>Shop Name</td>
					<td><?php echo $user["mv_merchant_shopname"]; ?></td>
				</tr>
				
				<tr>
				    <tr>
					<td>Address</td>
					<td><?php echo $user["mv_merchant_address"]; ?></td>
				</tr>
				 <tr>
					<td>Operation Hour</td>
					<td><?php echo $open;  ?> - <?php echo $close; ?></td>
				</tr>
				 <tr>
					<td>Close day</td>
					<td><?php echo $user["mv_merchant_close_day"]; ?></td>
				</tr>
				<tr>
					<td>Web Link</td>
					<td><?php echo $user["mv_merchant_link"]; ?></td>
				</tr>
				<tr>
					<td>Bank Detail</td>
					<td><?php echo $user["mv_merchant_bank"]; ?></td>
				</tr>
				<tr>
					<td>Introduction</td>
					<td><?php echo $user["mv_merchant_intro"]; ?></td>
				</tr>
					<?php }?>
						<?php if ($user["mv_user_type"] == 4 | $user["mv_user_type"] == 3){ ?>
						<tr>
					<td>Company Name</td>
					<td><?php echo $user["mv_merchant_cname"]; ?></td>
				</tr>
						 <tr>
					<td>State</td>
					<td><?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
											$result = $db->where('*',$tb,'mv_user_state.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_state_name"].',';
												}
												?></td>
				</tr>
						<?php }?>
						<?php if ($user["mv_user_type"] == 1 | $user["mv_user_type"] == 2){ ?>
						 <tr>
					<td>State</td>
					<td><?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
											$result = $db->where('*',$tb,'mv_user_state.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_state_name"];
												}
												?></td>
				</tr>
						<?php }?>
				<tr>
					<td>Image</td>
					<td>
					     <?php if($user['mv_user_image']!="") {?>
						<div class="lightBoxGallery">
							<a href="img/userprofile/<?php echo $user["mv_user_image"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/userprofile/<?php echo $user["mv_user_image"]; ?>"></a>
							<?php }
						else{
						?>
						<img alt="image" class="rounded-circle" src="img/userprofile/img.jpg" style="width:48px;height:48px;"/>
						<?php
						}
					?>
						</div>
					</td>
				</tr>
				
			</tbody>
		</table>
	</div>
	
	
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
	
</div>