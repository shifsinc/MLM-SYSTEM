<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "category";
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
			<?php 
			    if($onpage == 1){
	
			 ?>
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Category for seller</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Category</strong>
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
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#add_item"> &nbsp;Add Category</a>
						
					</div>	
									
					
				</div>
				<br>
				
				
				
				<div class="modal inmodal" id="add_item" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form" action="soap_func.php?type=addcategory&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Category</h4>
								</div>
								<div class="modal-body">
									
									
								    <div class="form-group"><label>Category Name</label> <input type="text" placeholder="Enter Category name" class="form-control" name="category_name" id="chkcate"></div>
									<div class="form-group"><label>icon</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff" >
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
									
	
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnaddcategory"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Category List</h5>
								
								
							</div>
							<div class="ibox-content">
							   
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									     

										<thead>
										<tr>
											<th>No</th>
											<th>Category Name</th>
												<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									    
								            $i=1;
										
											
											$col="*";
											$tb = 'mv_category';
                							$opt= 'mv_category_status != ? ';
                							$arr=array(9);
                							$result=$db->advwhere($col,$tb,$opt,$arr);
											
											foreach($result as $row){
											?>
											
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_category_name"]; ?></td>
											
										
											
											<?php
											    
											    $status = $row["mv_category_status"];
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
											
											<td class="<?php echo $color; ?>"><?php echo $show; ?></td>
											<td class="text-center">
											    <div class="btn-group">
												<a data-remote="ajax/category_info.php?p=<?php echo $row['mv_category_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a data-remote="ajax/category_edit.php?p=<?php echo $row['mv_category_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">Edit</a>
												<!--a data-remote="ajax/delete_item.php?p=<?php echo $row['mv_item_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
												
											    </div>
											</td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
										<tfoot>
											<tr>
												<th>No</th>
    											<th>Category Name</th>
    										
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
						item_desc: {
							required: true,
							
						},
						item_name: {
							required: true,
							
						},
						under_subcate: {
							required: true,
							
						},
						item_amt: {
							required: true,
							
						},
						item_unit: {
							required: true,
							
						}
						
					}
				});
				
				
		});
			
			
			//for item checked
		$('#chkitem').change(function(){
		var itemid = $(this).val();
		var thisparent = $(this).parent();
		if(itemid == ""){
			$('#item_note').remove();
		}else{
			$('#item_note').remove();
			$.post('api/validation.php', { item_id: itemid, type: 'check_item' }, function(data){
				console.log(data);
				data = JSON.parse(data);
				if(data.Status){
					thisparent.append('<label id="item_note" class="text-success">'+data.Msg+'</label>');
				}else{
					thisparent.append('<label id="item_note" class="text-danger">'+data.Msg+'</label>');
				}
			});
		}
	});
			
			
		</script>
		
		
	</body>
</html>
