<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "packagelist";
	require_once('inc/header.php');
?>
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			<?php 
			    if($onpage == 1){
	
			 ?>
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Package List</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Package</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				
				
				<div class="row">
					<div class="col-md-9 text-center">						
						
					</div>
					<div class="col-md-3 text-center">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#add_item"> &nbsp;Add Package</a>
						
					</div>	
									
					
				</div>
				<br>
				
				
				
				<div class="modal inmodal" id="add_item" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							<form role="form1" id="form" action="soap_func.php?type=addpackage&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Package</h4>
								</div>
								<div class="modal-body">
									
									
								    <div class="form-group"><label>Name</label> <input type="text" placeholder="Enter Item name" class="form-control" name="pack_name" id="chkpackagename"></div>
									<div class="form-group"><label>Description</label> <input type="text" placeholder="Enter Description" class="form-control" name="pack_desc"></div>
									<div class="form-group"><label><?php echo $point; ?></label> <input type="number" placeholder="Enter Price" class="form-control" name="pack_price"></div>
									<div class="form-group" hidden><label>Max Point</label> <input type="number" placeholder="Enter Unit" class="form-control" name="pack_unit" value="0"></div>
									<div class="form-group" hidden><label>Percentage</label> <input type="number" placeholder="Enter Point" class="form-control" name="pack_point" value="0"></div>
									<div class="form-group"><label>Commission</label> <input type="number" placeholder="Enter Commission" class="form-control" name="pack_com"></div>
									<div class="form-group"><label>Delivery Fee</label> <input type="number" placeholder="Enter delivery fee" class="form-control" name="pack_deli"></div>
										<div class="form-group"><label>State</label><span class="text-danger"><strong> (Please select at least one state)</strong></span>
									<div class="row ">
									    <?php
									    $col    = 'mv_state_id != ?';
									    $opt =array(99);
									    $result = $db->advwhere('*','mv_state',$col,$opt);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="statechecked[]"  value="<?php echo $row['mv_state_id']; ?>"  /> <?php echo $row['mv_state_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
										<div class="form-group"><label>Category</label><span class="text-danger"><strong> (Please select at least one category)</strong></span>
									<div class="row ">
									    <?php
									    $col='mv_category_status = ?';
									    $opt=array(1);
									    $result = $db->advwhere('*','mv_category',$col,$opt);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="categorychecked[]"  value="<?php echo $row['mv_category_id']; ?>"  /> <?php echo $row['mv_category_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
									<div class="form-group " id="selectoption">
                                        <label class="font-normal">Add Wholesaler<span class="text-danger" ></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addwholesaler"  tabindex="2" >
                                                    <option disabled selected value=""> -- select an option -- </option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
            										$col='mv_user_type = ? AND mv_user_status =?';
            									    $opt=array(3,1);
            									    $result = $db->advwhere('*','mv_user',$col,$opt);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_user_id']; ?>"><?php echo $row['mv_merchant_cname']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
                                    
                                    	<div class="form-group"><label>Logo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff" >
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
	
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnaddpackage"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				

				
				<div class="row">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Package List</h5>
								
								
							</div>
							<div class="ibox-content">
								
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									     

										<thead>
										<tr>
											<th>No</th>
											<th>Name</th>
											<th>Company Name</th>
											<th><?php echo $point; ?></th>
											<th>Commission</th>
											<th>Status</th>
											
											<th width=15%></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									    
								            $i=1;
											$tb = 'mv_package';
											$col='mv_package_status != ?';
											$opt=array('9');
											$result = $db->advwhere('*',$tb,$col,$opt);
											foreach($result as $row){
											    
											    $wholesaler = $db->where('mv_merchant_cname','mv_user','mv_user_id',$row['mv_user_id']);
											    $wholesaler_cname = $wholesaler[0]['mv_merchant_cname'];
											?>
											
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_package_name"]; ?></td>
											<td><?php echo $wholesaler_cname; ?></td>
											<td><?php echo $row["mv_package_price"]; ?></td>
											<td><?php echo $row["mv_package_commission"]; ?></td>
											<?php
                    						    
                    						    $status = $row["mv_package_status"];
                    						    if($status == 1)
                    						    {
                    						        $show = "Available";
                    						        $color = "text-success";
                    						    }else if($status == 0)
                    						    {
                    						        $show = "Not Available";
                    						        $color = "text-danger";
                    						    }
                    						
                    						?>
											
                            					
                    						<td><span class="<?php echo $color; ?>"><?php echo $show; ?></span></td>
                            				
											
											<td class="text-center">
											    <div class="btn-group">
												<a data-remote="ajax/package_info.php?p=<?php echo $row['mv_package_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a data-remote="ajax/package_edit.php?p=<?php echo $row['mv_package_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">Edit</a>
												<a data-remote="ajax/edit_pcate.php?p=<?php echo $row['mv_package_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">Category</a>
												<!--a data-remote="ajax/delete_package.php?p=<?php echo $row['mv_package_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
												
											    </div>
											</td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
										<tfoot>
											<tr>
												<th>No</th>
											<th>Name</th>
											<th>Company Name</th>
											<th><?php echo $point; ?></th>
											<th>Commission</th>
											<th>Status</th>
											<th width=15%></th>
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
		 <script src="js/plugins/chosen/chosen.jquery.js"></script>
    	<script src="js/plugins/iCheck/icheck.min.js"></script>
		
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
		
			 $('.chosen-select').chosen({width: "100%"});
			 
			 $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
            
            function myFunction() {
                var checkBox = document.getElementById("myCheck");
                var text = document.getElementById("text");
                if (checkBox.checked == true){
                    text.style.display = "block";
                } else {
                   text.style.display = "none";
                }
            }
		
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
			
			$(document).ready(function(){
				
				$("#form").validate({
					rules: {
						pack_desc: {
							required: true,
							
						},
						pack_name: {
							required: true,
							
							
						},
						under_addwholesaler: {
							required: true,
							
							
						},
						"statechecked[]": {
							required: true,
							
							
						},
						"categorychecked[]": {
							required: true,
							
							
						},
						under_addstate: {
							required: true,
							
							
						},
						pack_unit: {
							required: true,
							number: true,
						},
						pack_price: {
							required: true,
							number: true,
						},
						pack_com: {
							required: true,
							number: true,
						},
						pack_point: {
							required: true, 
							number: true,
						},
							pack_deli: {
							required: true,
							
							
						},
						
					}
				});
				
				
		});
			
				//for packagename checked
		$('#chkpackagename').change(function(){
		var packagenameid = $(this).val();
		var thisparent = $(this).parent();
		if(packagenameid == ""){
			$('#packagename_note').remove();
		}else{
			$('#packagename_note').remove();
			$.post('api/validation.php', { packagename_id: packagenameid, type: 'check_packagename' }, function(data){
				console.log(data);
				data = JSON.parse(data);
				if(data.Status){
					thisparent.append('<label id="packagename_note" class="text-success">'+data.Msg+'</label>');
				}else{
					thisparent.append('<label id="packagename_note" class="text-danger">'+data.Msg+'</label>');
				}
			});
		}
	});

 
 
 

			
			
		</script>
		
		
	</body>
</html>
