<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
	$user = $db->where('*','mv_user','mv_user_id',$id);
    $user = $user[0];
    
    $user1 = $db->where('*','mv_wallet','mv_user_id',$id);
    $user1 = $user1[0];


    $addr = $user["mv_user_addr"];
    if( ($addr == NULL) || ($addr == "") )
    {
        $useraddr = "This is new member, no address yet.";
    }else
    {
        $useraddr = $user["mv_user_addr"];
    }
    
    
    
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
					<td>User Code</td>
					<td><?php echo $user["mv_user_code"]; ?></td>
				</tr>
				<tr>
					<td>Name</td>
					<td><?php echo $user["mv_user_fullname"]; ?></td>
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
    			    
    			?>
				
				<tr>
					<td>Referrer</td>
					<td><?php echo $result["mv_user_fullname"]; ?></td>
				</tr>
				<tr>
					<td>Referrer Code</td>
					<td><?php echo $result["mv_user_code"]; ?></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><i class="fa fa-map-marker"></i>  <?php echo $useraddr ?></td>
				</tr>
				<tr>
					<td>Phone number</td>
					<td><?php echo $user["mv_user_phnum"]; ?></td>
				</tr>
				
				<tr>
					<td>Image</td>
					<td>
						<div class="lightBoxGallery">
							<a href="img/userprofile/<?php echo $user["mv_user_image"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/userprofile/<?php echo $user["mv_user_image"]; ?>"></a>
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