<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $cate = $db->where('*','mv_product','mv_product_id',$id);
    $cate = $cate[0];

    
?>
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">

<html>
<body>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<h4 class="modal-title">Edit Category</h4>

</div>
<div class="modal-body">


  
										
										<div class="row">
											<div class="col-lg-12 ">
												
												<form role="form" id="form_edit" action="soap_func.php?type=editcategory&tb=user" method="post" enctype="multipart/form-data">
													<input type="hidden" name="token" value="<?php echo $token; ?>" />
													<div class="hr-line-dashed"></div>
													<div class="form-group "><label>Name</label>
														<div class="col-sm-10"><input type="text" placeholder="Category Name" class="form-control" name="cname" value="<?php echo $cate["mv_product_name"]; ?>" id='chkcategoryname_ajax'></div>
													</div>
													
													<div class="form-group "><label>Description</label>
														<div class="col-sm-10"><input type="text"  placeholder="Category Description" class="form-control" name="desc" value="<?php echo $cate["mv_product_desc"]; ?>"></div>
													</div>
													
				 								    <div class="form-group "><label>Photo</label> 
        			                                    <div class="col-sm-10"><input  type="file"  id="myfile"  class="form-control" name="file" accept=".jpg, .png , .jpeg , .tiff" /></div>
        		                                    </div>
        		                                    <div class="form-group"><label>Status</label>
			<div class="row">
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="0"  <?php if ($cate["mv_product_status"] == 0): ?>
					checked="checked"
				<?php endif ?>> Block</div>
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="1"  <?php if ($cate["mv_product_status"] == 1): ?>
					checked="checked"
				<?php endif ?>/> UnBlock</div>
			</div>
		</div>
													<div class="modal-footer">
		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
		<button type="submit" class="btn btn-white" name="btnsubmitcategory" value="<?php echo $cate["mv_product_id"]; ?>">Submit</button>
		
		
		
	</div>
												</form>
											</div>
											
										</div>
									</div>
		
		
	</div>
	
		<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	<script src="js/plugins/iCheck/icheck.min.js"></script>
	<script>
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
				
				$("#form_edit").validate({
					rules: {
						cname: {
							required: true,
							
						},
						desc: {
							required: true,
							
						}
					
						
					}
				});
				
				
		});
		
		//for category name checked
		$('#chkcategoryname_ajax').change(function(){
		var categorynameid = $(this).val();
		var thisparent = $(this).parent();
		if(categorynameid == ""){
			$('#categoryname_note').remove();
		}else{
			$('#categoryname_note').remove();
			$.post('api/validation.php', { categoryname_id: categorynameid, type: 'check_categoryname_ajax' }, function(data){
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
</script>
	</body>
	</html>
	
