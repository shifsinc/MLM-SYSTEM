<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $package = $db->where('*','mv_package','mv_package_id',$id);
    $package = $package[0];
    
    $point = $db->get('mv_default_point_name','mv_default',1);
    $point = $point[0]['mv_default_point_name'];
	
    
?>

<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Edit Category</h4>
	
</div>
<div class="modal-body">
	
	
	
	
	<div class="row">
		<div class="col-lg-12 ">
			
			<form role="form" id="form_edit" action="soap_func.php?type=editpackage&tb=user" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="hr-line-dashed"></div>
				<div class="form-group"><label >Name</label>
					<input type="text" placeholder="Package Name" class="form-control" name="pname" value="<?php echo $package["mv_package_name"]; ?>" id="chkpackagename_ajax">
				</div>
				
				<div class="form-group "><label >Description</label>
					<input type="text"  placeholder="Package Description" class="form-control" name="pdesc" value="<?php echo $package["mv_package_desc"]; ?>">
				</div>
				
				
				<div class="form-group "><label >Percentage</label>
					<input type="number"  placeholder="Package Point" class="form-control" name="ppoint" value="<?php echo $package["mv_package_point"]; ?>">
				</div>
				
				<div class="form-group "><label >Max Points</label>
					<input type="number"  placeholder="Package Unit" class="form-control" name="punit" value="<?php echo $package["mv_package_unit"]; ?>">
				</div>
				
				<div class="form-group "><label ><?php echo $point; ?></label>
					<input type="number"  placeholder="Package Price" class="form-control" name="pprice" value="<?php echo $package["mv_package_price"]; ?>">
				</div>
				<div class="form-group "><label >Commission</label>
					<input type="number"  placeholder="Package Price" class="form-control" name="pcom" value="<?php echo $package["mv_package_commission"]; ?>">
				</div>
				<div class="form-group "><label >Delivery Fee</label>
					<input type="number"  placeholder="Package fee" class="form-control" name="pdeli" value="<?php echo $package["mv_package_deli"]; ?>">
				</div>
				
				<div class="form-group">
					<label class="font-normal">Change Wholesaler<span class="text-danger"><strong> (If you want to change wholesaler)</strong></span></label>
					<div>
						<select  class="chosen-select" name="under_changeuser" tabindex="3" >
							
							
							
							<?php 
								
								$i=1;
								
								
								$col='mv_user_type = ? AND mv_user_status =?';
								$opt=array(3,1);
								$result2 = $db->advwhere('*','mv_user',$col,$opt);
								foreach($result2 as $row){
								?>
								<option <?php if($row['mv_user_id'] == $package["mv_user_id"]) echo"selected"; ?>  value="<?php echo $row['mv_user_id']; ?>"><?php echo $row['mv_merchant_cname']; ?></option>
								
								
							<?php $i++; } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="font-normal">Add State<span class="text-danger"><strong> (If you want to add state)</strong></span></label>
					<div>
						<select  class="chosen-select" name="under_addstate" tabindex="2" >
							<?php 
								
								;
								$thisid = $user["mv_user_id"];
								$tb = 'mv_state JOIN mv_package_state ON mv_state.mv_state_id=mv_package_state.mv_state_id';
								$result1 = $db->where('*',$tb,'mv_package_state.mv_package_id',$id);
							?>
							<option disabled selected  value="0"> -- select an option -- </option>
							
							
							<?php 
								
								$i=1;
								
								
								$col='mv_state_id !=?';
								$opt=array(99);
								$result = $db->advwhere('*','mv_state',$col,$opt);
								foreach($result as $row){
								?>
								<option  value="<?php echo $row['mv_state_id']; ?>"><?php echo $row['mv_state_name']; ?></option>
								
								
							<?php $i++; } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="font-normal">Delete State<span class="text-danger"><strong> (If you want to delete state)</strong></span></label>
					<div>
						<select  class="chosen-select" name="under_deletestate" tabindex="2" >
							<option disabled selected value="0"> -- select an option -- </option>
							
							<?php 
								
								$j=1;
								$thisid = $user["mv_user_id"];
								$tb = 'mv_state JOIN mv_package_state ON mv_state.mv_state_id=mv_package_state.mv_state_id';
								$result1 = $db->where('*',$tb,'mv_package_state.mv_package_id',$id);
								foreach($result1 as $row){
								?>
								<option  value="<?php echo $row['mv_state_id']; ?>"><?php echo $row['mv_state_name']; ?></option>
								
								
							<?php $j++; } ?>
						</select>
					</div>
				</div>
				<div class="form-group"><label>Status </label>
					<div class="row">
						<div class="i-checks col-md-3 text-center"><input type="radio" name="pstatus" value="1"  <?php if ($package["mv_package_status"] == 1): ?>
							checked="checked"
						<?php endif ?>/> Available</div>
						<div class="i-checks col-md-4 text-center"><input type="radio" name="pstatus" value="0"  <?php if ($package["mv_package_status"] == 0): ?>
							checked="checked"
						<?php endif ?>/> Not available</div>
					</div>
				</div>
				
				
				<div class="form-group"><label >Logo</label> 
					<input  type="file"  id="myfile"  class="form-control" name="file" accept=".jpg, .png , .jpeg , .tiff" />
				</div>
				
				
				
				
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-white" name="btnsubmitpackage" value="<?php echo $package["mv_package_id"]; ?>">Submit</button>
					
					
					
				</div>
			</form>
		</div>
		
	</div>
</div>


</div>
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
				pdesc: {
					required: true,
					
				},
				pname: {
					required: true,
					
					
				},
				
				pdeli: {
					required: true,
					
					
				},
				under_changeuser: {
					required: true,
					
					
				},
				under_changestate: {
					required: true,
					
					
				},
				punit: {
					required: true,
					number: true,
				},
				pprice: {
					required: true,
					number: true,
				},
				pcom: {
					required: true,
					number: true,
				},
				ppoint: {
					required: true, 
					number: true,
				}
				
			}
		});
		
		
	});
	
	//for packagename checked
	$('#chkpackagename_ajax').change(function(){
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
