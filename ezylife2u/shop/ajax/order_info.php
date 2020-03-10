<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	$onpage = $_REQUEST['q'];
	//echo 'ID:'.$id;
	$tb = 'mv_order JOIN mv_user ON mv_order.mv_user_id=mv_user.mv_user_id JOIN mv_package ON mv_package.mv_package_id=mv_order.mv_package_id';
    $order = $db->where('*',$tb,'mv_order_id',$id);
    $order = $order[0];
    
       $pointname = $db->get('mv_default_point_name','mv_default',1);
    $point = $pointname[0]['mv_default_point_name'];

    
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Order Details</h4>

</div>
<div class="modal-body">


    <div class="ibox-content">
    	<div class="col-lg-12">
    		<div class="contact-box ">
			
		    	<h2 class="m-b-xs"><strong><?php echo $order["mv_package_name"]; ?></strong></h2>
			

		    	<br>
		        	<table class="table">
		        	    
    			    	<thead>
    			    	</thead>
    			    	
    			    	<tbody>
    			    	    
    			    	    
        					<tr>
            					<td>Order User</td>
            					<td><?php echo $order["mv_user_fullname"]; ?></td>
            				</tr>
            				<tr>
            					<td>User Address</td>
            					<td><?php echo $order["mv_order_addr"]; ?><br>
            					<?php echo $order["mv_order_postcode"]; ?>
            					<?php echo $order["mv_order_city"]; ?><br>
            					</td>
            				</tr>
            					<tr>
            					<td>User State</td>
            					<td><?php echo $order["mv_order_state"]; ?></td>
            				</tr>
            					<tr>
            					<td>Billing Address</td>
            					<td><?php echo $order["mv_order_baddr"]; ?></td>
            				</tr>
            				<tr>
            					<td>Date</td>
            					<td><?php echo $order["mv_order_date"]; ?></td>
            				</tr>
            				<tr>
            					<td>Package Original Price</td>
            					<td><?php echo $order["mv_package_price"]; ?> <span class="badge badge-danger"><?php echo $point; ?></span></td>
            				</tr>
            				<tr>
            					<td>Delivery Fee</td>
            					<td><?php echo $order["mv_package_deli"]; ?></td>
            				</tr>
            				<?php
    						    
    						    $status = $order["mv_order_status"];
    						    if($status == 0)
    						    {
    						        $show = "Pending";
    						        $color = " text-danger";
    						        $print = "hidden";
    						    }else if($status == 1)
    						    {
    						        $show = "Approved";
    						        $color = " text-warning";
    						        $print = "hidden";
    						    }else if($status == 2)
    						    {
    						        $show = "Delivered";
    						        $color = " text-info";
    						        $print = "hidden";
    						    }else if($status == 3)
    						    {
    						        $show = "Cancelled";
    						        $color = " text-dark";
    						        $print = "hidden";
    						    }else if($status == 4)
    						    {   
    						        $show = "Complete";
    						        $color = " text-success";
    						        $print = "";
    						    }
    						    
    						    
    						    if($onpage == 1 || $onpage == 3){
    						        $print = "";
    						    }
    						?>
							

                            <tr>
            					<td>Status</td>
            					<td class="<?php echo $color; ?>"><?php echo $show; ?></td>
            				</tr>
        		
            			
        						<tr>
        							<td></td>
        							<td></td>
        						</tr>
						</tbody>
						
					</table>	
					<div class="table-responsive m-t">
                        <table class="table invoice-table">
                            <thead>
								<tr>
									<th>Item List</th>
									<th>Wholesaler</th>
									<th>Quantity</th>
									<th>Point</th>
									
									<th>Total Points</th>
								</tr>
							</thead>
                            <tbody>
								
								
								<?php 
								    
								    
								    
								    $i=1;
								    $totalunit = 0;
								// 	$tb = 'mv_order_item JOIN mv_order ON mv_order_item.mv_order_id=mv_order.mv_order_id';
								// 	$result = $db->where('*',$tb,'mv_order_item.mv_order_id',$id);
									
									$col = "*";
            	                    $tb = 'mv_order_item JOIN mv_order ON mv_order_item.mv_order_id=mv_order.mv_order_id JOIN mv_item ON mv_item.mv_item_id = mv_order_item.mv_item_id';
            	                    $opt = "mv_order_item.mv_order_id = ? ORDER BY mv_item.mv_item_name ASC";
            	                    $arr = array($id);
            	                    $result = $db->advwhere($col,$tb,$opt,$arr);
            	                    
            	                    
            	                    
									foreach($result as $row){
									    $iid=$row['mv_user_id'];
									    
									    	$col1 = "*";
            	                    $tb1 = 'mv_item JOIN mv_user ON mv_item.mv_user_id=mv_user.mv_user_id';
            	                    $opt1 = "mv_item.mv_user_id = ? ";
            	                    $arr1 = array($iid);
            	                    $result1 = $db->advwhere($col1,$tb1,$opt1,$arr1);
								
								?>
								
								
								<tr>
								    

								    
									<td><div><strong><?php echo $row["mv_item_name"]; ?></strong></div>
									<?php 
									
									    $mv_item = $row["mv_item_desc"];
									    $mv_order_item = $row["mv_order_item_desc"];
									    
									    $show = $mv_order_item;
									    
									    if($mv_order_item == ""){
									       $show = $mv_item;
									    }else{
									       $show = $mv_order_item;
									    }
									
									?>
									
									
									
									<small><?php echo $show; ?></small></td>
									<td><?php echo $result1[0]["mv_user_fullname"]; ?></td>
									<td><?php echo $row["mv_order_item_qty"]; ?></td>
									
									
									<td><?php echo $row["mv_order_item_unit"]; ?></td>
									<?php 

									    $total =  $row["mv_order_item_qty"] * $row["mv_order_item_unit"]; 

									?>
									<td><?php echo $total; ?></td>
								</tr>
								
								<?php
								    
								    $totalunit = $totalunit + $total;
							    	$i++; 
								
								} ?>
								
								
								
							</tbody>
						</table>
					</div>
                    <table class="table invoice-total">
                        <tbody>
						    <tr>
    							<td><strong>Package Original Price</strong></td>
    							<td><?php echo $order["mv_package_price"]; ?> <small></small></td>
							</tr>
							
							<tr>
								<td><strong>(All Item)Your Total Point</strong></td>
								<td><?php echo number_format((float)$totalunit, 2, '.', ''); ?> <small></small></td>
							</tr>
							<tr>
            					<td><strong>Delivery Fee</strong></td>
            					<td><?php echo $order["mv_package_deli"]; ?></td>
            				</tr>
							<tr>
								<td><strong>Payment Price :</strong></td>
								<td><?php echo $order["mv_order_price"]?> <small></small></td>
							</tr>
						</tbody>
					</table>
				
					
				</div>
			</div>
		</div>
		
		
	</div>
	<div class="modal-footer">
	    <a <?php echo $print; ?> href="invoice.php?p=<?php echo $id; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print Invoice </a>
		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
		
	</div>