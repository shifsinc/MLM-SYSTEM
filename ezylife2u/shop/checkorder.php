<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "checkorder";
	require_once('inc/header.php');
	
	
?>

<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->

			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Your Order</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Order</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				

				<br>
				
				
				

				
				<div class="row">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Your Order</h5>
								
								
							</div>
							<div class="ibox-content">
							   
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									     

										<thead>
										<tr>
											<th>No</th>
										
											<th>Package</th>
											
											<th>Payment Price</th>
											<th>Date</th>
											<th>Wholesaler</th>
											<th>Pay Method</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
   
								            $i=1;
								            $thisid = $user["mv_user_id"];

											
                                            $col='*';
                                            $tb='mv_order JOIN mv_user ON mv_order.mv_user_id=mv_user.mv_user_id JOIN mv_package ON mv_package.mv_package_id=mv_order.mv_package_id';
                                            $opt='mv_order.mv_order_status != ? AND mv_order.mv_user_id =?';
                                            $arr=array(9,$thisid);
                                            $result=$db->advwhere($col,$tb,$opt,$arr);
											foreach($result as $row){
											?>
											
										<tr>
											<td><?php echo $i; ?></td>
										
											<td><?php echo $row["mv_package_name"]; ?></td>
											
												<?php
    						    
                    						    $package = $row["mv_order_type"];
                    						    if($package == 1)
                    						    {
                    						        $showpacakge = "Self Select";
                    						        $color = " text-success";
                    						        
                    						    }else if($package == 2)
                    						    {
                    						        $showpacakge = "Food Bank";
                    						        $color = " text-warning";
                    						       
                    						    }else if($package == 3)
                    						    {
                    						        $showpacakge = "Random";
                    						        $color = " text-danger";
                    						       
                    						    }
                    						    $wholesaler_id = $row["mv_user_id"];
											    $wholesaler = $db->where('*','mv_user','mv_user_id',$wholesaler_id);
											    $wholesaler_cname = $wholesaler[0]['mv_merchant_cname'];
                    						
                    						
                    						?>
											<!--<td class="<?php echo $color; ?>"><?php echo $showpacakge; ?></td>-->
											<td><?php echo $row["mv_order_price"]; ?> <?php echo $point; ?> </td>

											
											<td><?php echo $row["mv_order_date"]; ?></td>
											<td><?php echo $wholesaler_cname; ?></td>
											<?php
    						    
                    						    $status = $row["mv_order_status"];
                    						    if($status == 0)
                    						    {
                    						        $show = "Pending";
                    						        $color = " text-danger";
                    						        $link = "myModal";
                    						        $remote= 'data-remote="ajax/order_cancel_user.php?p='.$row['mv_order_id'].'"';
                    						        $hidden = "";
                    						        
                    						    }else if($status == 1)
                    						    {
                    						        $show = "Approved";
                    						        $color = " text-warning";
                    						        $link = "apporved";
                    						        $remote= "";
                    						        $hidden = "hidden";
                    						        
                    						    }else if($status == 2)
                    						    {
                    						        $show = "Delivered";
                    						        $color = " text-info";
                    						        $link = "delivered";
                    						        $remote= "";
                    						        $hidden = "hidden";
                    						    }
                    						    else if($status == 3)
                    						    {
                    						        $show = "Cancelled";
                    						        $color = " text-dark";
                    						        $hidden = "hidden";
                    						    }
                    						    else if($status == 4)
                    						    {
                    						        $show = "Complete";
                    						        $color = " text-success";
                    						        $link = "complete";
                    						        $remote= "";
                    						        $hidden = "hidden";
                    						    }
                    						
			        						    $pay_type = $row["mv_order_pay_type"];
                    						    if($pay_type == 2){
                    						        
                    						        $show_paytype = 'Card';
                    						        $show_paytype_color = 'text-warning';
                    						        
                    						    }else{
                    						        $show_paytype = 'Points';
                    						        $show_paytype_color = 'text-info';
                    						    }
                    						?>
                    						
											<td class="<?php echo $show_paytype_color; ?>"><?php echo $show_paytype; ?></td>
											<td class="<?php echo $color; ?>"><?php echo $show; ?></td>
											<td class="text-center">
											    <div class="btn-group">
												<a data-remote="ajax/order_info.php?p=<?php echo $row['mv_order_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a <?php echo $remote; ?> <?php echo $hidden; ?> class="btn btn-white btn-xs" data-toggle="modal" data-target="#<?php echo $link; ?>">Cancel</a>
												<!--<a data-remote="ajax/delete_item.php?p=<?php echo $row['mv_item_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
												
											    </div>
											</td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
										<tfoot>
											<tr>
												<th>No</th>
    										
    											<th>Package</th>
    										
    											<th>Price</th>
    											<th>Date</th>
    											<th>Wholesaler</th>
    											<th>Pay Method</th>
    											<th>Status</th>
    											<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
								
							</div>
						</div>
						
					</div>
					
					
					
				</div>
				
				<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							
						</div>
					</div>
				</div>
				
				 <div class="modal inmodal" id="delivered" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Delivered Order</h4>
                                    
                                </div>
                                <div class="modal-body text-center">
                                    <h2><strong>This Order was <span class="text-danger">Delivered </span>. You are not allow to cancel this order.</strong></h2>
                                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal inmodal" id="apporved" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Approved Order</h4>
                                    
                                </div>
                                <div class="modal-body text-center">
                                    <h2><strong>This Order was <span class="text-danger">Approved</span>. You are not allow to cancel this order. If you want to cancel this order, please contact admin. </strong></h2>
                                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal inmodal" id="apporved" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Completed Order</h4>
                                    
                                </div>
                                <div class="modal-body text-center">
                                    <h2><strong>This Order was <span class="text-danger">Completed</span>. You are not allow to cancel this order. </strong></h2>
                                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    
                                </div>
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
		
		<!-- Custom and plugin javascript -->
		<script src="js/inspinia.js"></script>
		<script src="js/plugins/pace/pace.min.js"></script>
		
    	<script src="js/plugins/dataTables/datatables.min.js"></script>
    	<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>

        <!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>	
        
		<!-- blueimp gallery -->
		<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
		
		<!-- Jquery Validate -->
		<script src="js/plugins/validate/jquery.validate.min.js"></script>
		
		<!-- Page-Level Scripts -->
		<script>
		     $('.chosen-select').chosen({width: "100%"});
		
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
		
		
        	$('body').on('click', '[data-toggle="modal"]', function(){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
            });    
		
		


			
			
		</script>
		
		
	</body>
</html>
