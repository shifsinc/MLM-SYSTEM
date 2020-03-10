<?php
	include_once('inc/init.php');
	$PageName = "summry";
	require_once('inc/header.php');
	$db = new DB_Functions(); 
	
	$from = $_REQUEST['p'];
	$to = $_REQUEST['q'];


// 	echo 'p:'.$from;
// 	echo 'q:'.$to;
?>

<body class="white-bg">

			


						<div class="ibox-content p-xl">

							

								    
    									    <?php 
									        
                                            
								            $col = 'SUM(mv_order_item_qty)';
								            $tb = 'mv_order JOIN mv_order_item ON mv_order.mv_order_id = mv_order_item.mv_order_id ';
                							$opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? ';
                							$arr=array($from,$to,1);
                							$result=$db->advwhere($col,$tb,$opt,$arr);
                							$total_item = $result[0]['SUM(mv_order_item_qty)'];
				
											
											?>
								    
								    
								    
									
									<div class="ibox-content">
                                    	<div class="col-lg-12">
                                    		<div class="contact-box ">
                                			
                                		    	<h2 class="m-b-xs"><strong>Total Item</strong></h2>
                                			
                                
                                		    	<br>
                                		        	<table class="table">
                                		        	    
                                    			    	<thead>
                                    			    	</thead>
                                    			    	
                                    			    	<tbody>
                                    			    	    
                                    			    	    
                                        					<tr>
                                            					<td>Total Item Quantity</td>
                                            					<td><?php echo $total_item; ?></td>
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
                                									<th>Quantity</th>
                                						
                                								</tr>
                                							</thead>
                                                            <tbody>
                                								
                                								
                                								<?php 
                                								    
                                								    
                                								    
                                								    $i=1;

                                									
                                									$col = "SUM(mv_order_item_qty),mv_item_name";
                                            	                    $tb = 'mv_order_item JOIN mv_order ON mv_order_item.mv_order_id=mv_order.mv_order_id JOIN mv_item ON mv_item.mv_item_id = mv_order_item.mv_item_id ';
                                            	                    
                                            	                    $opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? GROUP BY mv_item_name ORDER BY mv_item.mv_item_name ASC';
                                        							$arr=array($from,$to,1);
                                        							$result=$db->advwhere($col,$tb,$opt,$arr);

                                            	                    
                                									foreach($result as $row){
                                								
                                								?>
                                								
                                								
                                								<tr>
                                								    
                                								    <?php 
                                								    
                                    								    
                                    								    $tb = 'mv_order_item JOIN mv_item ON mv_order_item.mv_item_id = mv_item.mv_item_id';
                                                                        $result = $db->where('mv_order_item_desc',$tb,'mv_item_name',$row["mv_item_name"]);
                                                                        $desc = $result[0];
                                								        
                                								    
                                								    ?>
                                								    
                                
                                								    
                                									<td><div><strong><?php echo $row["mv_item_name"]; ?></strong></div>

                                									
                                									
                                									
                                									<small><?php echo $desc["mv_order_item_desc"]; ?></small></td>
                                									<td><?php echo $row["SUM(mv_order_item_qty)"]; ?></td>
                                									

                                								</tr>
                                								
                                								<?php

                                            					} 
                                            					
                                            					?>
	
                                							</tbody>
                                						</table>
                                					</div>
                                					
                                					
                                					
                                					
                                					
                                				
                                					
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
