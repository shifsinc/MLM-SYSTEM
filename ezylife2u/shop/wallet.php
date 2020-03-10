<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "wallet";
	require_once('inc/header.php');
	
	$pointname = $db->get('mv_default_point_name','mv_default',1);
    $pointname = $pointname[0]['mv_default_point_name'];
?>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<body>
<script
src="https://www.paypal.com/sdk/js?client-id=Ae6O52Q1_c9wcBDjVbvudcqYhE5_rEbtGNd_LKuEe2sZ6xbyu76hbrwZLgS3yd6ckN9_UJgSzuAgEn4P&currency=MYR&disable-card=amex">
</script>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			

			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Wallet</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Wallet</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="wrapper wrapper-content">

				<div class="row">
			    	<div class="col-md-10 text-center">
						
					</div> 

					<div class="col-md-3 text-center" style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#withdraw"><i class="fa fa-send"></i> &nbsp;Withdraw &nbsp;</a>
						
					</div>
					
					
					<div class="col-md-3 text-center" style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#transfer"><i class="fa fa-send"></i> &nbsp;Transfer <?php echo $pointname; ?> &nbsp;</a>
						
					</div>
					<div class="col-md-3 text-center" style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#topup"><i class="fa fa-arrow-up"></i> &nbsp;Request <?php echo $pointname; ?> &nbsp;</a>
						
					</div>
					<div class="col-md-3 text-center" style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#online_topup"><i class="fa fa-arrow-up"></i> &nbsp; Online Top up &nbsp;</a>
						
					</div>
					
				</div>
		
				<br>
				
	
				<div class="row">
					
					<?php   
					
					    $thisid = $user["mv_user_id"];
					    $wallet = $db->where('*','mv_wallet','mv_user_id',$thisid);
					    $wallet = $wallet[0];
					    
					    
					    $thisid = $user["mv_user_id"];
					    $point = $db->where('*','mv_user','mv_user_id',$thisid);
					    $point = $point[0];
					?>
					
                    <div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-primary">
                                
                                <h5>Wallet</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $wallet["mv_wallet_amt"]; ?> <span class="badge badge-danger "><?php echo $pointname; ?></span></h1>
                                
                                <small>Total Balance</small>
							</div>
						</div>
						
					</div>
					<div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-primary">
                                
                                <h5>Pending Wallet</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $wallet["mv_wallet_pending_amt"]; ?> <span class="badge badge-danger "><?php echo $pointname; ?></span></h1>
                                
                                <small>In this month</small>
							</div>
						</div>
						
					</div>
					<div class="col-lg-4">
                        <div class="ibox ">
                            <div class="ibox-title bg-primary">
                                
                                <h5>Your Spend</h5>
							</div>
                            <div class="ibox-content">
                                <h1 class="no-margins"> <?php echo $wallet["mv_spend"]; ?> <span class="badge badge-danger "><?php echo $pointname; ?></span></h1>
                                
                                <small>In this month</small>
							</div>
						</div>
						
					</div>

					
				</div>
		
				
				
				<div class="modal inmodal" id="transfer" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">

					    	<form role="form" id="form" action="soap_func.php?type=transfercredit&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Transfer <?php echo $pointname; ?></h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Amount</label> <input type="number" placeholder="Enter amount" class="form-control" name="amt"></div>
									
									<div class="form-group"><label>User Code</label> <input type="text" placeholder="Enter user code" class="form-control" name="usercode" id="chkRefname"></div>
									
										<div class="form-group"><label>Remark (Optional)</label> <input type="text" placeholder="Enter remark" class="form-control" name="remark" ></div>
									
									<input type="text" hidden class="form-control" value="<?php echo $thisid ?>" name="userid"/>
									<input type="text" hidden class="form-control" value="<?php echo $wallet["mv_wallet_amt"] ?>" name="userbalance"/>
                                    <input type="text" hidden class="form-control" value="<?php echo $wallet["mv_wallet_id"] ?>" name="walletid"/>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btntransfer"><strong>Transfer</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				

				
				
				<div class="modal inmodal" id="topup" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_request" action="soap_func.php?type=requestvcoin&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Request <?php echo $pointname; ?></h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label><?php echo $pointname; ?></label> <input type="number" placeholder="Enter amount" class="form-control" name="number"></div>
									<div class="form-group"><label>Name</label> <input type="text" placeholder="Enter Name" class="form-control" name="bname"></div>
									<div class="form-group"><label>Bank Type</label> <input type="text" placeholder="Enter Bank Type" class="form-control" name="btype"></div>
									<div class="form-group"><label>Account Number</label> <input type="text" placeholder="Enter Account Number" class="form-control" name="anumber"></div>
									<div class="form-group"><label>Date and Time(Bank in)</label> <input type="datetime-local" placeholder="Enter Account Number" class="form-control" name="bdate"></div>
									<div class="form-group"><label>Receipt</label> 
									<div class="custom-file">
										<input id="logo" id="myfile" type="file" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
										<label for="logo" class="custom-file-label">Choose file...</label>
									</div>
									</div>
									<br><br>
								    
								    
								    <div class="contact-box ">
								    <table class="table">
		        	    
                			    	<thead>
                			    	</thead>
                			    	
                			    	<tbody>
                			    	   
                			    	 
                    					<tr>
                        					<td>Account Name</td>
                        					<td>: Ezy Life Enterprise</td>
                        				</tr>
                        				<tr>
                        					<td>Account Number</td>
                        					<td>: 8009942070</td>
                        				</tr>
                        				<tr>
                        					<td>Bank Type</td>
                        					<td>: CIMB BERHAD</td>
                        				</tr>

            						</tbody>
            						
            					</table>
								 </div>
								 
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnsubmit"><strong>Request</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
					<!--div class="modal inmodal" id="redeem" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_redeem" action="soap_func.php?type=redeemvcoin&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Redeem V-Coin</h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Point</label> <input type="number" placeholder="Enter point" class="form-control" name="point"></div>
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnredeem"><strong>Redeem</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div-->
				
				<div class="modal inmodal" id="withdraw" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_withdraw" action="soap_func.php?type=withdraw&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Withdraw</h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label><?php echo $pointname; ?></label> <input type="number" placeholder="Enter <?php echo $pointname; ?>" class="form-control" name="vcoin"></div>
									<div class="form-group"><label>Name</label> <input type="text" placeholder="Enter Name" class="form-control" name="bname"></div>
									<div class="form-group"><label>Bank Type</label> <input type="text" placeholder="Enter Bank Type" class="form-control" name="btype"></div>
									<div class="form-group"><label>Account Number</label> <input type="text" placeholder="Enter Account Number" class="form-control" name="anumber"></div>
									<?php  $getfee = $db->get('*','mv_default',1);
									$handlingfee=$getfee[0]['mv_default_withdraw'];?>
									<div class="form-group"><label>Note: Company will charge <?php echo $handlingfee; ?>% handling fee</label></div>
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnwithdraw"><strong>Withdraw</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				
				<div class="modal inmodal" id="online_topup" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">

					    	<form role="form" id="form_online_topup"  enctype="multipart/form-data">
									<input type="hidden" name="token" id='token' value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Online Top Up</h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group">
									    <label><span class="text-danger"> *If you choose to pay online, you will be charged 5% by the customer. </span></label>
									    
									    <label>Amount</label> <input type="number" placeholder="Enter amount" class="form-control" name="topup_amt" id="topup_amt"></div>
									
									<div id="paypal-button-container" ></div>
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<!--<button type="submit" class="btn btn-primary" name="btntransfer"><strong>Top Up</strong></button>-->
								</div>
								
							</form>
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
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											    
											    
											    $walletid = $db->where('*','mv_wallet','mv_user_id',$thisid);
                                                $walletid = $walletid[0];
											    $getwalletid = $walletid["mv_wallet_id"];
											    
											    $col = "*";
                                                $tb = "mv_transaction";
                                                $chkcol = "mv_wallet_id = ? OR mv_user_id = ? AND mv_transaction_activity !=?" ;
                                                $arr = array($getwalletid,$thisid,11);
											    $result = $db->advwhere($col,$tb,$chkcol,$arr);
											    
												
												$i=1;
											
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<?php 
													
													    $activity = $row["mv_transaction_activity"];
													    if($activity == 1)
                                					    {
                                					        $showactivity = "Add ".$pointname." From admin";
                                					    }
                                					    else if($activity == 2)
                                					    {
                                					        $showactivity = "Transfer ".$pointname;
                                					    }
                                					     else if($activity == 3)
                                					    {
                                					        $showactivity = "Buy Package";
                                					    }
                                					     else if($activity == 4)
                                					    {
                                					        $showactivity = "Redeem ".$pointname;
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
													<td width=20%>
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
												<th></th>
											</tr>
										</tfoot>
							
										
										

										
									</table>
								</div>
								
							</div>
							

							
						</div>
						
						
						<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content animated fadeIn">
								    
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
			</div>
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
    
    <!-- paypal api -->
    <script src="js/api/paypal.js"></script>
    
    <!-- Page-Level Scripts -->
    <script>
    
    	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
    
    
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                "order": [[ 3, "desc" ]],
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
		
		$('.custom-file-input').on('change', function() {
			let fileName = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').addClass("selected").html(fileName);
		}); 
		
		$(document).ready(function(){
			
			$("#form").validate({
				rules: {
					password: {
						required: true,
						minlength: 3
					},
					url: {
						required: true,
						url: true
					},
					number: {
						required: true,
						number: true
					},
					file: {
						required: true, 
					},
					usercode: {
						required: true, 
					},
					amt: {
						required: true,
						number: true,
						min: 0,
						max: <?php echo $wallet["mv_wallet_amt"]; ?>
					},
					max: {
						required: true,
						maxlength: 4
					}
				},
				messages: {
					amt: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",
						max: "Your amount cannot be more than your balance."
					       },
					addcoin: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",

					       }
				    
				}
			});
			
			
		
			
			$("#form2").validate({
				rules: {
					
					
					usercode: {
						required: true, 
						notEqual: 'MV00068'
					},
					addcoin: {
						required: true,
						number: true,
						min: 0,
    
					}
				},
				messages: {
					addcoin: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",
                        notEqual:"Amount can not be zero"
					       }
				    
				}
			});
				$("#form_redeem").validate({
				rules: {
					point: {
						required: true, 
					    min: 0,
					    max: <?php echo $point["mv_user_redeem"]; ?>
				},
				messages: {
					point: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",
						max: "Your amount cannot be more than your balance."
						
					       }
				}
				}
			});
			
			$("#form_withdraw").validate({
				rules: {
					vcoin: {
						required: true, 
					    min: 0,
					    max: <?php echo $wallet["mv_wallet_amt"]; ?>
				},
				btype: {
						required: true, 
					    
				},
				anumber: {
						required: true, 
					    
				},
				messages: {
					vcoin: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",
						max: "Your amount cannot be more than your balance."
						
					       }
				}
				}
			});
			
				$("#form_request").validate({
				rules: {
					number: {
						required: true, 
					    min: 0,
					  
				},
				    	file: {
						required: true, 
					  
					  
				},
				messages: {
					number: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",
						
						
					       }
				}
				}
			});
			
			
				$('#chkRef').change(function(){
            		var refid = $(this).val();
            		var thisparent = $(this).parent();
            		if(refid == ""){
            			$('#ref_note').remove();
            		}else{
            			$('#ref_note').remove();
            			$.post('api/validation.php', { ref_id: refid, type: 'check_ref' }, function(data){
            				console.log(data);
            				data = JSON.parse(data);
            				if(data.Status){
            					thisparent.append('<label id="ref_note" class="text-success">'+data.Msg+'</label>');
            				}else{
            					thisparent.append('<label id="ref_note" class="text-danger">'+data.Msg+'</label>');
            				}
            			});
            		}
            	});
            	
            	$('#chkRefname').change(function(){
            		var refid = $(this).val();
            		var thisparent = $(this).parent();
            		if(refid == ""){
            			$('#ref_note').remove();
            		}else{
            			$('#ref_note').remove();
            			$.post('api/validation.php', { ref_id: refid, type: 'check_refname' }, function(data){
            				console.log(data);
            				data = JSON.parse(data);
            				if(data.Status){
            					thisparent.append('<label id="ref_note" class="text-success">'+data.Msg+'</label>');
            				}else{
            					thisparent.append('<label id="ref_note" class="text-danger">'+data.Msg+'</label>');
            				}
            			});
            		}
            	});
			
			
			
		});
		
		
		
	</script>
	
	
<script>
  paypal.Buttons({
    
    createOrder: function(data, actions) {
        var topup_amt = $('#topup_amt').val() * 1.05;  
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: topup_amt
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // Capture the funds from the transaction
      return actions.order.capture().then(function(details) {
        // Show a success message to your buyer
        alert('Transaction completed by ' + '<?php echo $user['mv_user_fullname']; ?>');
        
        var token = $('#token').val();
		var topup_amt = $('#topup_amt').val();

        $.ajax({

            type: "POST",
            url: 'api/cart.php',
            data: {type: 'online_topup', token: token, topup: topup_amt},
            success: function(data){
                alert(data);
                // window.location.href = "checkorder.php";
            }
            
            
        });

        window.location.href='package.php';
        
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
        
        
      });
      
    }
  }).render('#paypal-button-container');
  
  
  
  
</script>
	
	
	
</body>

</html>
