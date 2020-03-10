<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "catelist";
	require_once('inc/header.php');
?>

<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
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
					<h2>Category List</h2>
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
					<div class="col-md-3 text-center">						
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#add_sellercate"> &nbsp;Add Wholeseller category</a>
					</div>
					<div class="col-md-3 text-center">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#add_mercate"> &nbsp;Add Merchant category</a>
						
					</div>	
					<div class="col-md-3 text-center">					
						
					</div>
					<div class="col-md-3 text-center">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#add_subcate"> &nbsp;Add Sub-Category</a>
						
					</div>					
					
				</div>
				<br>
				
				<div class="modal inmodal" id="add_sellercate" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form" action="soap_func.php?type=addsellercategory&tb=user" method="post" enctype="multipart/form-data">
							    <input type="hidden" name="token" value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Wholeseller Category</h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Name</label> <input type="text" placeholder="Enter category name" class="form-control" name="cate_name" id="chkcategoryname"></div>
									<div class="form-group"><label>Description</label> <input type="text" placeholder="Enter Description" class="form-control" name="cate_desc"></div>
									
									<div class="form-group"><label>Photo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
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
				
				<div class="modal inmodal" id="add_mercate" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form" action="soap_func.php?type=addmercategory&tb=user" method="post" enctype="multipart/form-data">
							    <input type="hidden" name="token" value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Merchant Category</h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Name</label> <input type="text" placeholder="Enter category name" class="form-control" name="cate_name" id="chkcategoryname"></div>
									<div class="form-group"><label>Description</label> <input type="text" placeholder="Enter Description" class="form-control" name="cate_desc"></div>
									
									<div class="form-group"><label>Photo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
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
				
				<div class="modal inmodal" id="add_subcate" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form1" action="soap_func.php?type=addsubcategory&tb=user" method="post" enctype="multipart/form-data">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Sub-Category</h4>
								</div>
								<div class="modal-body">
									
									
								    <div class="form-group"><label>Name</label> <input type="text" placeholder="Enter sub-category name" class="form-control" name="subcate_name" id='chksubcategoryname'></div>
									<div class="form-group"><label>Description</label> <input type="text" placeholder="Enter Description" class="form-control" name="subcate_desc"></div>
			
									<div class="form-group">
                                        <label class="font-normal">Under which category<span class="text-danger"><strong> (Please check your category before submit)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_cate" tabindex="2" >
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        											$tb = 'mv_product';
        											$result = $db->where('*',$tb,'mv_user_type',3);
    											foreach($result as $cate){
    											?>
                                                <option selected value="<?php echo $cate['mv_product_name']; ?>"><?php echo $cate['mv_product_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
									
									
									
									
									<div class="form-group"><label>Photo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div>
									
	
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnaddsubcategory"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				
				<div class="row">
					<div class="col-lg-6">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Wholeseller Category List</h5>
								
								
							</div>
							<div class="ibox-content">
							   
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
									<thead>
										<tr>
											<th>No</th>
											<th>Name</th>
											<th width=20%></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									    
								            $i=1;
											$tb = 'mv_product';
											$result = $db->where('*',$tb,'mv_user_type',3);
											foreach($result as $row){
											?>
									    
									    
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_product_name"]; ?></td>
											
											<td class="text-center">
										    <div class="btn-group">
										        <?php 
										        
										            $cate_status = $row["mv_product_status"]; 
										            if($cate_status == 1){
										                $show = 'Unblock';
										                $color = 'text-success';
										            }else{
										                $show = 'Block';
										                $color = 'text-danger';
										            }
										            
										        
										        ?>
										        <a class="btn btn-white  btn-xs <?php echo $color;  ?>" style="pointer-events: none; cursor: default;"><?php echo $show;?></a>
												<a data-remote="ajax/cate_info.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white  btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a data-remote="ajax/cate_edit.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white  btn-xs" data-toggle="modal" data-target="#myModal">Edit</a>
											
												<!--a data-remote="ajax/delete_cate.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
											</div></td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="col-lg-6">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Sub-Category List</h5>
								
								
							</div>
							
							<div class="ibox-content">
							    
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter1"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="8" data-filter=#filter1>
									<thead>
										<tr>
											<th>No</th>
											<th>Name</th>
											
											<th width=20%></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									    
								            $i=1;
											$tb = 'mv_sub_product';
											$result = $db->get('*',$tb,1);
											foreach($result as $row){
											?>
											 
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_sub_product_name"]; ?></td>
											
											<td class="text-center">
										    <div class="btn-group">
										        <?php 
										        
										            $sub_cate_status = $row["mv_sub_product_status"]; 
										            if($sub_cate_status == 1){
										                $show = 'Unblock';
										                $color = 'text-success';
										            }else{
										                $show = 'Block';
										                $color = 'text-danger';
										            }
										            
										        
										        ?>
										        <a class="btn btn-white  btn-xs <?php echo $color;  ?>" style="pointer-events: none; cursor: default;"><?php echo $show;?></a>
												<a data-remote="ajax/subcate_info.php?p=<?php echo $row['mv_sub_product_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a data-remote="ajax/subcate_edit.php?p=<?php echo $row['mv_sub_product_id']; ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">Edit</a>
											
												<!--a data-remote="ajax/delete_subcate.php?p=<?php echo $row['mv_sub_product_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
												</div>
											</td>
										</tr>
										
											<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
						</div>
						
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-lg-6">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Merchant Category List</h5>
								
								
							</div>
							<div class="ibox-content">
							   
								<input type="text" class="form-control form-control-sm m-b-xs" id="filter"
								placeholder="Search in table">
								
								<table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
									<thead>
										<tr>
											<th>No</th>
											<th>Name</th>
											<th width=20%></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									    
								            $i=1;
											$tb = 'mv_product';
											$col='mv_user_type = ? AND mv_product_status != ?';
											$arr=array(4,9);
											$result = $db->advwhere('*',$tb,$col,$arr);
											foreach($result as $row){
											?>
									    
									    
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_product_name"]; ?></td>
											
											<td class="text-center">
										    <div class="btn-group">
										        <?php 
										        
										            $cate_status = $row["mv_product_status"]; 
										            if($cate_status == 1){
										                $show = 'Unblock';
										                $color = 'text-success';
										            }else{
										                $show = 'Block';
										                $color = 'text-danger';
										            }
										            
										        
										        ?>
										        <a class="btn btn-white  btn-xs <?php echo $color;  ?>" style="pointer-events: none; cursor: default;"><?php echo $show;?></a>
												<a data-remote="ajax/cate_info.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white  btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a data-remote="ajax/cate_edit.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white  btn-xs" data-toggle="modal" data-target="#myModal">Edit</a>
											
												<!--a data-remote="ajax/delete_cate.php?p=<?php echo $row['mv_product_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
											</div></td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3">
												<ul class="pagination float-right"></ul>
											</td>
										</tr>
									</tfoot>
								</table>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="col-lg-6">
						
						
						
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
		
		<!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>
		
		<!-- FooTable -->
		<script src="js/plugins/footable/footable.all.min.js"></script>
		
		<!-- blueimp gallery -->
		<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
		
		<!-- Jquery Validate -->
		<script src="js/plugins/validate/jquery.validate.min.js"></script>
		
		<!-- Page-Level Scripts -->
		<script>
		    
		   			
			 $('.chosen-select').chosen({width: "100%"});
			 
		   
		    
        	$('body').on('click', '[data-toggle="modal"]', function(){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
            });    
		
		
			$(document).ready(function() {
				
				$('.footable').footable();
				$('.footable2').footable();
				
			});
			
			$('.custom-file-input').on('change', function() {
				let fileName = $(this).val().split('\\').pop();
				$(this).next('.custom-file-label').addClass("selected").html(fileName);
			}); 
			
			$(document).ready(function(){
				
				$("#form").validate({
					rules: {
						cate_desc: {
							required: true,
							
						},
						
						cate_name: {
							required: true,
							
						}
					
						
					}
				});
				
				$("#form1").validate({
                    
					rules: {
						subcate_desc: {
							required: true,
							
						},
						subcate_name: {
							required: true,
							
						},
						under_cate: {
							required: true,
							valueNotEquals: "default"
						}
					
						
					},
					messages: {
					under_cate: {
						required: "Please choose a category",
						valueNotEquals: "Please select an item!"
						
					       },
				   
			    	}
				});
			});


			
			//for category checked
		$('#chkcategory').change(function(){
		var categoryid = $(this).val();
		var thisparent = $(this).parent();
		if(categoryid == ""){
			$('#category_note').remove();
		}else{
			$('#category_note').remove();
			$.post('api/validation.php', { category_id: categoryid, type: 'check_category' }, function(data){
				console.log(data);
				data = JSON.parse(data);
				if(data.Status){
					thisparent.append('<label id="category_note" class="text-success">'+data.Msg+'</label>');
				}else{
					thisparent.append('<label id="category_note" class="text-danger">'+data.Msg+'</label>');
				}
			});
		}
	});
	
	//for category name checked
		$('#chkcategoryname').change(function(){
		var categorynameid = $(this).val();
		var thisparent = $(this).parent();
		if(categorynameid == ""){
			$('#categoryname_note').remove();
		}else{
			$('#categoryname_note').remove();
			$.post('api/validation.php', { categoryname_id: categorynameid, type: 'check_categoryname' }, function(data){
				console.log(data);
				data = JSON.parse(data);
				if(data.Status){
					thisparent.append('<label id="categoryname_note" class="text-success">'+data.Msg+'</label>');
				}else{
					thisparent.append('<label id="categoryname_note" class="text-danger">'+data.Msg+'</label>');
				}
			});
		}
	});
	
	//for subcategory name checked
		$('#chksubcategoryname').change(function(){
		var subcategorynameid = $(this).val();
		var thisparent = $(this).parent();
		if(subcategorynameid == ""){
			$('#subcategoryname_note').remove();
		}else{
			$('#subcategoryname_note').remove();
			$.post('api/validation.php', { subcategoryname_id: subcategorynameid, type: 'check_subcategoryname' }, function(data){
				console.log(data);
				data = JSON.parse(data);
				if(data.Status){
					thisparent.append('<label id="subcategoryname_note" class="text-success">'+data.Msg+'</label>');
				}else{
					thisparent.append('<label id="subcategoryname_note" class="text-danger">'+data.Msg+'</label>');
				}
			});
		}
	});
			
			
		</script>
		
		
	</body>
</html>

<?php                                                        
  if(isset($_POST['btndeletecategory']))
  {
       $productid=$_POST['btndeletecategory'];
       
       $getid = $db->where('*','mv_product','mv_product_id',$productid);
	    $getid = $getid[0];
		$pid=$getid['mv_product_id'];
       $result=$db->del('mv_product','mv_product_id',$pid);
  }
