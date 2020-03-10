<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "Transaction";
	require_once('inc/header.php');
	
	
?>

<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			<?php 
			    if($onpage == 1){
	
			 ?>

			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Transaction</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Transaction</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="wrapper wrapper-content">

				<?php   
					
					    $thisid = $user["mv_user_id"];
					    $wallet = $db->where('*','mv_wallet','mv_user_id',$thisid);
					    $wallet = $wallet[0];
					    
					?>
				
				
				
				
					<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							
							<div class="ibox-title">
								<h5>Merchant Transaction history</h5>
								
							</div>
							
							

							
							<div class="ibox-content">
								
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    
									    
									
										<thead>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>User Type</th>
												<th>From</th>
												<th>To</th>
												<th>Shop Name</th>
											
												<th ></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											    
											     $walletid = $db->where('*','mv_wallet','mv_user_id',$thisid);
                                                $walletid = $walletid[0];
											    $getwalletid = $walletid["mv_wallet_id"];
											    
											    $col = "*";
                                                $tb = "mv_transaction";
                                                $chkcol = "mv_wallet_id = ? OR mv_user_id = ? " ;
                                                $arr = array($getwalletid,$thisid);
											    $col = 'mv_transaction_activity = ? OR mv_transaction_activity = ?';
											    $array = array(6,8);
											    $result = $db->advwhere('*','mv_transaction',$col,$array);
											    
												
												$i=1;
											
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<?php 
													
													    $activity = $row["mv_transaction_activity"];
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
													        $showactivity = "Bank in to Merchant";
													    }
													     else if($activity == 7)
													    {
													        $showactivity = "Bank in to Wholesaler";
													    }
													     else if($activity == 8)
													    {
													        $showactivity = "Pay Bill to Merchant";
													    }
													    else if($activity == 11)
													    {
													        $showactivity = "Seller earn per Item";
													    }
													    
													    
													?>
													<td><?php echo $showactivity; ?></td>
													<td><?php echo $row["mv_transaction_amt"]; ?></td>
													<td><?php echo $row["mv_transaction_date"]; ?></td>
												
													
													<?php 
													    $the_id = $row["mv_user_id"];
													    
													    $user_name = $db->where('*','mv_user','mv_user_id',$the_id);
                                                        $user_name= $user_name[0];
                                                        
                                                        $the_id2 = $row["mv_wallet_id"];
                                                        $tb = 'mv_user  JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
											        	$user_name1 = $db->where('*',$tb,'mv_wallet.mv_wallet_id',$the_id2);
                                                        $user_name1 = $user_name1[0];
                                                        
                                                      
                                                        
                                                        if($user_name1["mv_user_type"]==3)
                                                        {
                                                            $type ="WholeSaler";
                                                        }
                                                        else if($user_name1["mv_user_type"]==4)
                                                        {
                                                            $type ="Merchant";
                                                        }
                                                        
													?>
														<td><?php echo $type; ?></td>
														<?php if($activity == 6 OR $activity == 7){ ?>
													<td>Admin</td>
													<?php } else { ?>
														<td><?php echo $user_name["mv_user_fullname"]; ?></td>
														<?php }  ?>
														<?php if($activity == 6 OR $activity == 7){ ?>
													<td><?php echo $user_name1["mv_user_fullname"]; ?></td>
													<?php } else { ?>
														<td><?php echo $user_name1["mv_user_fullname"]; ?></td>
														<?php }  ?>
													<td><?php echo $user_name1["mv_merchant_shopname"]; ?></td>
												
													<td >
														<a data-remote="ajax/user_wallet_info.php?p=<?php echo $row['mv_transaction_id']; ?>" class="btn btn-primary text-light" data-toggle="modal" data-target="#myModal">View More</a>
                                                        
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										
										
										<tfoot>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>User Type</th>
												<th>From</th>
												<th>To</th>
												<th>Shop Name</th>
											
												<th ></th>
											</tr>
										</tfoot>
							
										
										

										
									</table>
								</div>
								
							</div>
							

							
						</div>
						
						
						
						
					
						
						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							
							<div class="ibox-title">
								<h5>Wholesaler Transaction history</h5>
								
							</div>
							
							

							
							<div class="ibox-content">
								
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    
									    
									
										<thead>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>User Type</th>
												<th>From</th>
												<th>To</th>
	
											
												<th ></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											    
											     $walletid = $db->where('*','mv_wallet','mv_user_id',$thisid);
                                                $walletid = $walletid[0];
											    $getwalletid = $walletid["mv_wallet_id"];
											    
											    $col = "*";
                                                $tb = "mv_transaction";
                                                $chkcol = "mv_wallet_id = ? OR mv_user_id = ? " ;
                                                $arr = array($getwalletid,$thisid);
											    $col = 'mv_transaction_activity = ? OR mv_transaction_activity = ?';
											    $array = array(7,11);
											    $result = $db->advwhere('*','mv_transaction',$col,$array);
											    
												
												$i=1;
											
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<?php 
													
													    $activity = $row["mv_transaction_activity"];
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
													        $showactivity = "Bank in to Merchant";
													    }
													     else if($activity == 7)
													    {
													        $showactivity = "Bank in to Wholesaler";
													    }
													     else if($activity == 8)
													    {
													        $showactivity = "Pay Bill to Merchant";
													    }

													    else if($activity == 11)
													    {
													        $showactivity = "Seller earn per Item";
													    }
													    
													    
													?>
													<td><?php echo $showactivity; ?></td>
													<td><?php echo $row["mv_transaction_amt"]; ?></td>
													<td><?php echo $row["mv_transaction_date"]; ?></td>
												
													
													<?php 
													    $the_id = $row["mv_user_id"];
													    
													    $user_name = $db->where('*','mv_user','mv_user_id',$the_id);
                                                        $user_name= $user_name[0];
                                                        
                                                        $the_id2 = $row["mv_wallet_id"];
                                                        $tb = 'mv_user  JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
											        	$user_name1 = $db->where('*',$tb,'mv_wallet.mv_wallet_id',$the_id2);
                                                        $user_name1 = $user_name1[0];
                                                        
                                                      
                                                        
                                                        if($user_name1["mv_user_type"]==3)
                                                        {
                                                            $type ="WholeSaler";
                                                        }
                                                        else if($user_name1["mv_user_type"]==4)
                                                        {
                                                            $type ="Merchant";
                                                        }
                                                        
													?>
														<td><?php echo $type; ?></td>
														<?php if($activity == 6 OR $activity == 7){ ?>
													    <td>Admin</td>
													    <?php } else { ?>
														<td><?php echo $user_name["mv_user_fullname"]; ?></td>
														<?php }  ?>
														<?php if($activity == 6 OR $activity == 7){ ?>
													    <td><?php echo $user_name1["mv_user_fullname"]; ?></td>
													    <?php } else { ?>
														<td><?php echo $user_name1["mv_user_fullname"]; ?></td>
														<?php }  ?>
														
												    	<!--<td><?php echo $user_name1["mv_merchant_shopname"]; ?></td>-->
												
													<td >
														<a data-remote="ajax/user_wallet_info.php?p=<?php echo $row['mv_transaction_id']; ?>" class="btn btn-primary text-light" data-toggle="modal" data-target="#myModal">View More</a>
                                                        
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										
										
										<tfoot>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>User Type</th>
												<th>From</th>
												<th>To</th>
			
											
												<th ></th>
											</tr>
										</tfoot>
							
										
										

										
									</table>
								</div>
								
							</div>
							

							
						</div>
						
						
						
						
					
						
						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							
							<div class="ibox-title">
								<h5>Transaction history</h5>
								
							</div>
							
							

							
							<div class="ibox-content">
								
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    
									    
									
										<thead>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>From</th>
												<th>To</th>
												<th>Remark</th>
												<th ></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											    
											     $walletid = $db->where('*','mv_wallet','mv_user_id',$thisid);
                                                $walletid = $walletid[0];
											    $getwalletid = $walletid["mv_wallet_id"];
											    
											    $col = "*";
                                                $tb = "mv_transaction";
                                                $chkcol = "mv_wallet_id = ? OR mv_user_id = ? " ;
                                                $arr = array($getwalletid,$thisid);
											   
											    $result = $db->get('*','mv_transaction',1);
											    
												
												$i=1;
											
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<?php 
													
													    $activity = $row["mv_transaction_activity"];
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
													    else if($activity == 8)
													    {
													        $showactivity = "Pay Bill to Merchant";
													    }
													    else if($activity == 9)
													    {
													        $showactivity = "Add Pending Wallet From Admin";
													    }
													    else if($activity == 10)
													    {
													        $showactivity = "Online Top Up";
													    }
													    
													    
													    
													?>
													<td><?php echo $showactivity; ?></td>
													<td><?php echo $row["mv_transaction_amt"]; ?></td>
													<td><?php echo $row["mv_transaction_date"]; ?></td>
													
													<?php 
													    $the_id = $row["mv_user_id"];
													    
													    $user_name = $db->where('*','mv_user','mv_user_id',$the_id);
                                                        $user_name= $user_name[0];
                                                        
                                                        $the_id2 = $row["mv_wallet_id"];
                                                        $tb = 'mv_user INNER JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
											        	$user_name1 = $db->where('*',$tb,'mv_wallet_id',$the_id2);
                                                        $user_name1 = $user_name1[0];
                                                        
													?>
													
													<td><?php echo $user_name["mv_user_fullname"]; ?></td>
													<td><?php echo $user_name1["mv_user_fullname"]; ?></td>
													<td><?php echo $row["mv_transaction_remark"]; ?></td>
													<td >
														<a data-remote="ajax/user_wallet_info.php?p=<?php echo $row['mv_transaction_id']; ?>" class="btn btn-primary text-light" data-toggle="modal" data-target="#myModal">View More</a>
                                                        
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										
										
										<tfoot>
											<tr>
												<th>No</th>
												<th>Activity</th>
												<th>Amount</th>
												<th>Date</th>
												<th>From</th>
												<th>To</th>
												<th>Remark</th>
												<th></th>
											</tr>
										</tfoot>
							
										
										

										
									</table>
								</div>
								
							</div>
							

							
						</div>
						
						
						
						
					
						
						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
				
				
				<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content animated fadeIn">
								    
								</div>
							</div>
						</div>
			</div>
			
			
			<?php  
			    }
			    else
			    {
			        echo "YOU ARE NOT ADMIN, U CANNOT LANDING THIS PAGE";
			    }
			?>
			<!-- Content write here END -->
			<?php require_once('inc/footer.php'); ?>
		</div>
		
		
		
		
		<?php require_once('inc/right_nav.php'); ?>
	</div>
	
    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
	
    <script src="js/plugins/dataTables/datatables.min.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
	
    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
	
	<!-- blueimp gallery -->
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
	
	
	
	<!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>
    
    <!-- Sweetalert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    
	
    <!-- Page-Level Scripts -->
    <script>
    
    	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
    
    
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
				{ extend: 'copy'},
				{extend: 'csv'},
				{extend: 'excel', title: 'ExampleFile'},
				{extend: 'pdf', title: 'ExampleFile'},
				
				{extend: 'print',
					customize: function (win){
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');
						
						$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
					}
				}
                ]
				
			});
			
		});

		
		
	</script>
	
	
	
</body>
<?php
	
?>
</html>
