<?php
    include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$trans_id = $_REQUEST['p'];
	
	//echo 'ID:'.$trans_id;
	

    $user = $db->where('*','mv_transaction','mv_transaction_id',$trans_id);
    $user = $user[0];
	
	$the_id = $user["mv_user_id"];
    
    $user_name = $db->where('*','mv_user','mv_user_id',$the_id);
    $user_name= $user_name[0];
    
    $the_id2 = $user["mv_wallet_id"];
    $tb = 'mv_user INNER JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
	$user_name1 = $db->where('*',$tb,'mv_wallet_id',$the_id2);
    $user_name1 = $user_name1[0];
    
    $pointname = $db->get('mv_default_point_name','mv_default',1);
    $point = $pointname[0]['mv_default_point_name'];
  
    
    
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
					<td>Transaction Amount</td>
					<td class="<?php echo $color; ?>"><?php echo $user["mv_transaction_amt"]; ?></td>
				</tr>
				<tr>
				    <?php 
													
    				    $activity = $user["mv_transaction_activity"];
    				    if($activity == 1)
					    {
					        $showactivity = "Add ".$point." From admin";
					    }
					    else if($activity == 2)
					    {
					        $showactivity = "Transfer ".$point;
					    }
					     else if($activity == 3)
					    {
					        $showactivity = "Buy Package";
					    }
					     else if($activity == 4)
					    {
					        $showactivity = "Redeem ".$point;
					    }
					     else if($activity == 5)
					    {
					        $showactivity = "Rebate";
					    }
					     else if($activity == 6)
					    {
					        $showactivity = "Pay bill to Merchant";
					    }
					     else if($activity == 7)
					    {
					        $showactivity = "Pay bill to Wholesaler";
					    }
    				    
    				?>
					<td>Activity</td>
					<td><?php echo $showactivity; ?></td>
				</tr>
				<tr>
					<td>From</td>
					<td><?php echo $user_name["mv_user_fullname"]; ?></td>
				</tr>
			    <tr>
					<td>To</td>
					<td><?php echo $user_name1["mv_user_fullname"]; ?></td>
				</tr>
				<tr>
					<td>Transaction Data</td>
					<td><?php echo $user["mv_transaction_date"]; ?></td>
				</tr>
				<tr>
					<td>Transaction Remark</td>
					<td><?php echo $user["mv_transaction_remark"]; ?></td>
				</tr>
					<tr>
					<td>Bank Slip</td>
					<td>
					     <?php if($user['mv_transaction_img']!="") {?>
						<div class="lightBoxGallery">
							<a href="http://ezylife2u.com/shop/img/merchantreceipt/<?php echo $user["mv_transaction_img"]; ?>"  data-gallery=""><img class="d-block w-50" src="http://ezylife2u.com/shop/img/merchantreceipt/<?php echo $user["mv_transaction_img"]; ?>"></a>
							<?php }
						else{
						?>
						None
						<?php
						}
					?>
						</div>
					</td>
				</tr>
				<tr>
					<td>Transaction Status</td>
					<td><span class="label label-primary">Approved</span> (preview)</td>
				</tr>
			
			
				
			</tbody>
		</table>
	</div>
	
	
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
	
</div>