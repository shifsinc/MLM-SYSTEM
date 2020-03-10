<?php
	include_once('inc/init.php');
	$PageName = "invoice";
	require_once('inc/header.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
	$tb = 'mv_order JOIN mv_user ON mv_order.mv_user_id=mv_user.mv_user_id JOIN mv_package ON mv_package.mv_package_id=mv_order.mv_package_id';
    $order = $db->where('*',$tb,'mv_order_id',$id);
    $order = $order[0];
	
	
?>

<body class="white-bg">

			

		
					<div class="wrapper wrapper-content p-xl">
						<div class="ibox-content p-xl">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>From:</h5>
                                    <address>
                                        <strong>Ezy Life Enterprise</strong><br>
                                        <abbr title="Email">E:</abbr> Ezy2uchannel@gmail.com
									</address>
								</div>
								
                                <div class="col-sm-6 text-right">
                                    <h4>Invoice No.</h4>
                                    <?php 
                                        $now_id = $order['mv_order_id'];
                                        $order_id = 10000 + $now_id;
                                    ?>
                                    <h4 class="text-navy">EZY0<?php echo $order_id; ?></h4>
                                    <span>To:</span>
                                    <address>
                                        <strong><?php echo $order["mv_user_fullname"]; ?></strong><br>
                                        <?php echo $order["mv_order_addr"]; ?><br>
                                        <?php echo $order["mv_order_postcode"]." ". $order["mv_order_city"]; ?><br>
                                        
                                        <abbr title="Email">E:</abbr> <?php echo $order["mv_order_baddr"]; ?><br>
                                        <abbr title="Phone">P:</abbr> <?php echo $order["mv_user_phnum"]; ?>
									</address>
                                    <p>
                                        <span><strong>Order Date: </strong> <?php echo $order["mv_order_date"]; ?></span><br/>
                                        <span><strong>Invoice Print Date: </strong> <?php echo date("Y-m-d h:i:sa"); ?></span><br/>
                                        
									</p>
								</div>
							</div>
							
                            <div class="table-responsive m-t">
                                <table class="table invoice-table">
                                    <thead>
        								<tr>
        									<th>Item List</th>
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
        					</div><!-- /table-responsive -->
							
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

									
									<div class="well m-t"><strong>Comments</strong>
										Thank you for your purchase. (If your Total Points more than Package Original Price, the Total Points will be your Payment Price)
									</div>
								</div>
							</div>
					

					
			

			
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>

			
		
    <script type="text/javascript">
        window.print();
    </script>	
			
		</body>
	</html>
