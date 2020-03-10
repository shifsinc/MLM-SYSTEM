<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $item = $db->where('*','mv_item','mv_item_id',$id);
    $item = $item[0];

    $subid = $item["mv_sub_product_id"];
    
    $cate = $db->where('*','mv_sub_product','mv_sub_product_id',$subid);
    $cate = $cate[0];
    
    $cateid = $cate["mv_product_id"];
    $cate1 = $db->where('mv_product_name','mv_product','mv_product_id',$cateid);
    $cate1 = $cate1[0];
    


    
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Category Detials</h4>

</div>
<div class="modal-body">


    <div class="ibox-content">
    	<div class="col-lg-12">
    		<div class="contact-box ">
			
		    	<h2 class="m-b-xs"><strong><?php echo $item["mv_item_name"]; ?></strong></h2>
			

		    	<br>
		        	<table class="table">
		        	    
    			    	<thead>
    			    	</thead>
    			    	
    			    	<tbody>
    			    	    <?php
    						    
    						    $status = $item["mv_item_status"];
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
    			    	    
        					<tr>
            					<td>Category</td>
            					<td><?php echo $cate1["mv_product_name"]; ?></td>
            				</tr>
            				<tr>
            					<td>Sub-category</td>
            					<td><?php echo $cate["mv_sub_product_name"]; ?></td>
            				</tr>
            			    <tr>
            					<td>Inventory</td>
            					<td><?php echo $item["mv_item_amt"]; ?></td>
            				</tr>

            				<tr>
            					<td>Points</td>
            					<td><?php echo $item["mv_item_unit"]; ?></td>
            				</tr>
            					<tr>
            					<td>Wholesaler</td>
            					<?php 	$tb = 'mv_user';
							          	$getseller = $db->where('*',$tb,'mv_user_id',$item["mv_user_id"]); ?>
							          	
            					<td><?php echo $getseller[0]["mv_merchant_cname"]; ?></td>
            					
            				</tr>
            					<tr>
            					<td>State</td>
            					<td><?php 
            					$tb = 'mv_state JOIN mv_item_state ON mv_state.mv_state_id=mv_item_state.mv_state_id';
								$getstate = $db->where('*',$tb,'mv_item_state.mv_item_id',$id);
								foreach($getstate as $row){
            					echo $row["mv_state_name"].',';
            					} ?></td>
            				</tr>
            				
        					<tr>
            					<td>Image</td>
            					 <?php if($item['mv_item_img']!="") {?>
            					<td>
            					     
            						<div class="lightBoxGallery">
            							<a href="img/item/<?php echo $item["mv_item_img"]; ?>"  data-gallery=""><img class="d-block w-50" src="img/item/<?php echo $item["mv_item_img"]; ?>"></a>
            							<?php } 
            									else{
						?>
						<td>No Image</td>
						<?php
						}
					?>
            						</div>
            					</td>
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
						<?php echo $item["mv_item_desc"]; ?>
					</p>
					
					
					
				</div>
			</div>
		</div>
		
		
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
		
	</div>