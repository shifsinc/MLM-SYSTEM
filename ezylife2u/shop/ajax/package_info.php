<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $pack = $db->where('*','mv_package','mv_package_id',$id);
    $pack = $pack[0];
	
    $point = $db->get('mv_default_point_name','mv_default',1);
    $point = $point[0]['mv_default_point_name'];
    
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Package Details</h4>
	
</div>
<div class="modal-body">
	
	
    <div class="ibox-content">
    	<div class="col-lg-12">
    		<div class="contact-box ">
				
		    	<h2 class="m-b-xs"><strong><?php echo $pack["mv_package_name"]; ?></strong></h2>
				
				
		    	<br>
				<table class="table">
					
					<thead>
					</thead>
					
					<tbody>
						
						<?php
							
							$status = $pack["mv_package_status"];
							if($status == 1)
							{
								$show = "Available";
								$color = "label label-primary";
							}else if($status == 0)
							{
								$show = "Not Available";
								$color = "label label-danger";
							}
    						
						?>
						
						<tr>
							<td>Status</td>
    						<td><span class="<?php echo $color; ?>"><?php echo $show; ?></span></td>
						</tr>
						<tr hidden>
							<td>Percentage</td>
							<td><?php echo $pack["mv_package_point"]; ?></td>
						</tr>
						<tr>
							<td><?php echo $point; ?></td>
							<td> <?php echo $pack["mv_package_price"]; ?></td>
						</tr>
						
						<tr hidden>
							<td>Max Points</td>
							<td><?php echo $pack["mv_package_unit"]; ?></td>
						</tr>
						<tr>
							<td>Commission</td>
							<td><?php echo $pack["mv_package_commission"]; ?></td>
						</tr>
						<tr>
							<td>Delivery Fee</td>
							<td><?php echo $pack["mv_package_deli"]; ?></td>
						</tr>
						<tr>
							<td>State </td>
							
							<td><?php
								
								$tb = 'mv_state JOIN mv_package_state ON mv_state.mv_state_id=mv_package_state.mv_state_id';
								$result = $db->where('*',$tb,'mv_package_state.mv_package_id',$id);
								foreach($result as $row){
									echo $row["mv_state_name"].',';
								}
							?></td>
						</tr>
						<tr>
							<td>Logo</td>
							<?php if($pack['mv_package_logo']!="") {?>
            					<td>
									
            						<div class="lightBoxGallery">
            							<a href="img/package/<?php echo $pack["mv_package_logo"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/package/<?php echo $pack["mv_package_logo"]; ?>"></a>
            							<?php } 
										else{
										?>
										<td>No Logo</td>
										<?php
										}
									?>
								</div>
							</td>
						</tr>
						<tr>
							<td>Category</td>
							
							<?php 
            					$col='mv_category join mv_package_category on mv_package_category.mv_category_id=mv_category.mv_category_id';
            					$catename=$db->where('*',$col,'mv_package_category.mv_package_id',$id); 
            					foreach($catename as $row)
            					{ ?>
            					
							<td><?php echo $row["mv_category_name"]; }?></td>
						</tr>
						<tr>
							<td>Wholesaler</td>
							<?php $username=$db->where('*','mv_user','mv_user_id',$pack["mv_user_id"]);?>
							<td><?php echo $username[0]["mv_merchant_cname"]; ?></td>
						</tr>
						
						<tr>
							<td></td>
							<td></td>
						</tr>
					</tbody>
					
				</table>	
				
				<h4>
					Description
				</h4>
				
				<p>
					<?php echo $pack["mv_package_desc"]; ?>
				</p>
				
				
				
			</div>
		</div>
	</div>
	
	
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
	
</div>