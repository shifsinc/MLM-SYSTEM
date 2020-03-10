<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $item = $db->where('*','mv_item','mv_item_id',$id);
    $item = $item[0];
	
    
?>
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Edit Item</h4>
	
</div>
<div class="modal-body">
	
	
	
	
	
	<form role="form" id="form_edit" action="soap_func.php?type=edititem&tb=user" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<div class="hr-line-dashed"></div>
		
		<div class="form-group"><label>Name</label>
			<input type="text" placeholder="Item Name" class="form-control" name="iname" value="<?php echo $item["mv_item_name"]; ?>" id="chkitem_ajax">
		</div>
		
		<div class="form-group"><label>Description</label>
			<input type="text"  placeholder="Item Description" class="form-control" name="idesc" value="<?php echo $item["mv_item_desc"]; ?>">
		</div>
		
		<div class="form-group"><label>Status</label>
			<div class="row">
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="0"  <?php if ($item["mv_item_status"] == 0): ?>
					checked="checked"
				<?php endif ?>> Block</div>
				<div class="i-checks col-md-3 text-center"><input type="radio" name="status" value="1"  <?php if ($item["mv_item_status"] == 1): ?>
					checked="checked"
				<?php endif ?>/> UnBlock</div>
			</div>
		</div>
		
		
		
		
		<div class="form-group">
			<label>Sub-category<span class="text-danger"><strong> (Please check your category before submit)</strong></span></label>
			<div>
				<select  class="chosen-select" name="under_subcate" tabindex="2" >
					
					
					<?php 
						$current_sub = $item["mv_sub_product_id"];
						
						$i=1;
						$tb = 'mv_sub_product';
						$result = $db->get('*',$tb,1);
						foreach($result as $cate){
						?>
						
						<?php 
						    $check_sub = $cate["mv_sub_product_id"];
					        
						    if($current_sub == $check_sub){
						        $show_selected = "selected";
						    }else
						    {
						         $show_selected = "";
						    }
						    
						    echo $check_sub;
						?>
						<option <?php echo $show_selected; ?> value="<?php echo $cate['mv_sub_product_name']; ?>"><?php echo $cate['mv_sub_product_name']; ?></option>
						
						
					<?php $i++; } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group"><label >Inventory</label>
			<input type="number"  placeholder="Item Inventory" class="form-control" name="iamt" value="<?php echo $item["mv_item_amt"]; ?>">
		</div>
		
		<div class="form-group"><label >Unit</label>
			<input type="number"  placeholder="Item Unit" class="form-control" name="iunit" value="<?php echo $item["mv_item_unit"]; ?>">
		</div>
		
		<div class="form-group"><label >Photo</label> 
			<input  type="file"  id="myfile"  class="form-control" name="file" accept=".jpg, .png , .jpeg , .tiff" />
		</div>
		
		
		
		<div class="modal-footer">
			<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-white" name="btnsubmititem" value="<?php echo $item["mv_item_id"]; ?>">Submit</button>
			
			
			
		</div>
	</form>
	
</div>

	<!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>
    	<script src="js/plugins/iCheck/icheck.min.js"></script>
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
				
    				$("#form_edit").validate({
    					rules: {
    						idesc: {
    							required: true,
    							
    						},
    						iname: {
    							required: true,
    							
    						},
    						under_subcate: {
    							required: true,
    							
    						},
    						iamt: {
    							required: true,
    							
    						},
    						iunit: {
    							required: true,
    							
    						}
    						
    					}
    				});
    				
    				
    		});
    			
    			
	//for item checked
		$('#chkitem_ajax').change(function(){
		var itemid = $(this).val();
		var thisparent = $(this).parent();
		if(itemid == ""){
			$('#item_note').remove();
		}else{
			$('#item_note').remove();
			$.post('api/validation.php', { item_id: itemid, type: 'check_item_ajax' }, function(data){
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


