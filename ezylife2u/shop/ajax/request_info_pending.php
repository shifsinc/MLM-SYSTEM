<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
	$user = $db->where('*','mv_request','mv_request_id',$id);
    $user = $user[0];
    
    $this_id = $user["mv_user_id"];
    
    $user1 = $db->where('*','mv_user','mv_user_id',$this_id);
    $user1 = $user1[0];
    
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">User Detials</h4>
	  
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
					<td>User Name</td>
					<td><?php echo $user1["mv_user_fullname"]; ?></td>
				</tr>
				<tr>
					<td>User Code</td>
					<td><?php echo $user1["mv_user_code"]; ?></td>
				</tr>
				<tr>
					<td>Request Amount</td>
					<td><?php echo $user["mv_request_amt"]; ?></td>
				</tr>
				<tr>
					<td>Date</td>
					<td><?php echo $user["mv_request_datetime"]; ?></td>
				</tr>
				
				    
    						   
    					
				
				
				<?php
				    
				     $status = $user["mv_request_status"];
				    if($status == 0)
				    {
				        $show = "Approved";
				        $color = "label label-success";
				    }else if($status == 1)
				    {
				        $show = "Pending";
				        $color = "label label-warning";
				    }
				
					
				    $activity = $user["mv_request_activity"];
				    if($activity == 1)
				    {
				        $showactivity = "Request V-Coin";
				    }
				    else if($activity == 2)
				    {
				        $showactivity = "Redeem Point";
				    }
				     else if($activity == 3)
				    {
				        $showactivity = "Withdraw V-Coin";
				    }
	    
				    $img = $user["mv_request_img"];
				    
				    if($img != NULL || $img != ''){
				        $hidden = '';
				    }else{
				        $hidden = 'hidden';
				    }
				    
				    
				?>
				<tr>
					<td>Status</td>
					<td><span class="<?php echo $color; ?>"><?php echo $show ?></span></td>
				</tr>
				
				<tr>
					<td>Activity</td>
					<td><?php echo $showactivity ?></td>
				</tr>
				
				<tr <?php echo $hidden;?>>
					<td>Image</td>
					<td>
						<div class="lightBoxGallery">
							<a href="img/receipt/<?php echo $user["mv_request_img"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/receipt/<?php echo $user["mv_request_img"]; ?>"></a>
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