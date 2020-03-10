<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "checkrequest";
	require_once('inc/header.php');
?>
 
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->

			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Request List</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Your Request</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				

				
				
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							
							<div class="ibox-title">
								<h5>Request List</h5>
								
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
												<th>Status</th>
												
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
	

												    
												$i=1;
												$thisid = $user["mv_user_id"];
										    	$result = $db->where('*','mv_request','mv_user_id',$thisid);
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
												    
												    	<?php 
													
													    $activity = $row["mv_request_activity"];
													    if($activity == 1)
													    {
													        $showactivity = "Request ".$point;
													    }
													    else if($activity == 2)
													    {
													        $showactivity = "Redeem Point";
													    }
													     else if($activity == 3)
													    {
													        $showactivity = "Withdraw ".$point;
													    }
													    
													      $status = $row["mv_request_status"];
    						                              if($status == 1)
    						                           {
    						                               $show = "Pending";
    						                               $color = "text-warning";
    						                        }else if($status == 0)
    						                          {
    						                          $show = "Approved";
    						                          $color = "text-success";
    						                           }  
													?>
												    
													<td><?php echo $i; ?></td>
												
													<td><?php echo $showactivity; ?></td>
													<td><?php echo $row["mv_request_amt"]; ?></td>
													<td><?php echo $row["mv_request_datetime"]; ?></td>
													<td><span class="<?php echo $color; ?>"><?php echo $show; ?></span></td>
													
													<td width=20%>
        												<a data-remote="ajax/request_info.php?p=<?php echo $row['mv_request_id']; ?>" class="btn btn-primary text-white" data-toggle="modal" data-target="#myModal">View More</a>
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
		
		<!-- Custom and plugin javascript -->
		<script src="js/inspinia.js"></script>
		<script src="js/plugins/pace/pace.min.js"></script>
		
    	<script src="js/plugins/dataTables/datatables.min.js"></script>
    	<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
		
		<!-- blueimp gallery -->
		<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
		
		<!-- Jquery Validate -->
		<script src="js/plugins/validate/jquery.validate.min.js"></script>
		
		<!-- Page-Level Scripts -->
		<script>
		
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
		
		
        	$('body').on('click', '[data-toggle="modal"]', function(){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
            });    
		
		

			
			$('.custom-file-input').on('change', function() {
				let fileName = $(this).val().split('\\').pop();
				$(this).next('.custom-file-label').addClass("selected").html(fileName);
			}); 

			
			
			
		</script>
		
		
	</body>
</html>
