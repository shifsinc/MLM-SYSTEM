<?php
	include_once('../connection/PDO_db_function.php');
	
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $subcate = $db->where('*','mv_sub_product','mv_sub_product_id',$id);
    $subcate = $subcate[0];
	
    
?>
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Edit Sub-Category</h4>
	
</div>
<div class="modal-body">
	
	
	
	
	<form role="form" id="form_subedit" action="soap_func.php?type=editsubcategory&tb=user" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		
		<div class="hr-line-dashed"></div>
		
		

	    <div class="form-group"><label>Name</label> <input type="text" placeholder="Enter sub-category name" class="form-control" name="subcate_name" value="<?php echo $subcate["mv_sub_product_name"]; ?>" id='chksubcategoryname_ajax'></div>
		<div class="form-group"><label>Description</label> <input type="text" placeholder="Enter Description" class="form-control" name="subcate_desc" value="<?php echo $subcate["mv_sub_product_desc"]; ?>"></div>

		<div class="form-group">
            <label class="font-normal">Under which category<span class="text-danger"><strong> (Please check your category before submit)</strong></span></label>
                <div>
                    <select  class="chosen-select" name="under_cate" tabindex="2" >
                        
                       
                    <?php 
		    
			            $i=1;
						$tb = 'mv_product';
        				$opt = "mv_product_status = ? AND mv_user_type = ?";
                    	$arr = array(1,3);
        				$result = $db->advwhere('*',$tb,$opt,$arr);
					foreach($result as $cate){
					?>
                    <option selected value="<?php echo $cate['mv_product_name']; ?>"><?php echo $cate['mv_product_name']; ?></option>
                    
                    
                   <?php $i++; } ?>
                    </select>
                </div>
        </div>
        
         <div class="form-group"><label>Status</label>
			<div class="row">
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="0"  <?php if ($subcate["mv_sub_product_status"] == 0): ?>
					checked="checked"
				<?php endif ?>> Block</div>
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="1"  <?php if ($subcate["mv_sub_product_status"] == 1): ?>
					checked="checked"
				<?php endif ?>/> UnBlock</div>
			</div>
		</div>
		
		<div class="form-group"><label>Photo</label> 
    		<div class="custom-file ">
    			<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff" >
    			<label for="logo" class="custom-file-label">Choose file...</label>
    		</div>
    	</div>
		
		
		
		<div class="modal-footer">
			<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-white" name="btnsubmitsubcategory" value="<?php echo $subcate["mv_sub_product_id"]; ?>">Submit</button>

		</div>
	</form>
	
</div>
		<!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>
        <script src="js/plugins/iCheck/icheck.min.js"></script>
        <!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
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
				
				$("#form_subedit").validate({
					rules: {
						subcate_name: {
							required: true
							
						},
						subcate_desc: {
							required: true
							
						}
					
						
					}
				});
				
				
		});
		
		
			//for subcategory name checked
		$('#chksubcategoryname_ajax').change(function(){
		var subcategorynameid = $(this).val();
		var thisparent = $(this).parent();
		if(subcategorynameid == ""){
			$('#subcategoryname_note').remove();
		}else{
			$('#subcategoryname_note').remove();
			$.post('api/validation.php', { subcategoryname_id: subcategorynameid, type: 'check_subcategoryname_ajax' }, function(data){
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
        
        
