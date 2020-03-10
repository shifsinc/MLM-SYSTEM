<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	

	
    
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
			
			<form role="form" id="form_edit" action="soap_func.php?type=editpcate&tb=user" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="hr-line-dashed"></div>
				
				
			
			
				 
				
				
                                    	
                                    		
		<div class="form-group">
                                        <label class="font-normal">Add Category<span class="text-danger"><strong> (If you want to add category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addcate" tabindex="2" >
                                                    <option disabled selected value="0"> -- select an option -- </option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
										 $col='mv_category_status =?';
									    $opt=array(1);
									    $result = $db->advwhere('*','mv_category',$col,$opt);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_category_id']; ?>"><?php echo $row['mv_category_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
			<div class="form-group">
                                        <label class="font-normal">Delete Category<span class="text-danger"><strong> (If you want to delete category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_deletecate" tabindex="2" >
                                                    <option disabled selected value="0"> -- select an option -- </option>
                                                   
                                                <?php 
									    
        								            $j=1;
        										$thisid = $user["mv_user_id"];
									    	$tb = 'mv_category JOIN mv_package_category ON mv_category.mv_category_id=mv_package_category.mv_category_id';
											$result1 = $db->where('*',$tb,'mv_package_category.mv_package_id',$id);
    											foreach($result1 as $row){
    											?>
                                                <option  value="<?php echo $row['mv_category_id']; ?>"><?php echo $row['mv_category_name']; ?></option>
                                                
                                                
                                               <?php $j++; } ?>
                                                </select>
                                            </div>
                                    </div>
                                    
				
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-white" name="btnsubmitpackage" value="<?php echo $id; ?>">Submit</button>
					
					
				</div>
			</form>
		</div>
		
	</div>
</div>
<script src="js/plugins/iCheck/icheck.min.js"></script>
 <script src="js/plugins/chosen/chosen.jquery.js"></script>
        <script>
        
         $('.chosen-select').chosen({width: "100%"});
        
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
            
            $('.custom-file-input').on('change', function() {
               let fileName = $(this).val().split('\\').pop();
               $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }); 
            
            function myFunction1() {
                var checkBox = document.getElementById("myCheck1");
                var text = document.getElementById("text1");
                if (checkBox.checked == true){
                    text.style.display = "block";
                } else {
                   text.style.display = "none";
                }
            }
            
            //for username checked ajax
        		$('#chkuser_ajax').change(function(){
        		var userid = $(this).val();
        		var thisparent = $(this).parent();
        		if(userid == ""){
        			$('#user_note').remove();
        		}else{
        			$('#user_note').remove();
        			$.post('api/validation.php', { user_id: userid, type: 'check_user_ajax' }, function(data){
        				console.log(data);
        				data = JSON.parse(data);
        				if(data.Status){
        					thisparent.append('<br><label id="user_note" class="text-success">'+data.Msg+'</label>');
        				}else{
        					thisparent.append('<label id="user_note" class="text-danger">'+data.Msg+'</label>');
        				}
        			});
        		}
        	});
        	
        	//for add user
	$('#chkRef2_ajax').change(function(){
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
            
            $(document).ready(function(){
			
			$('#form_edit').validate({
				rules: {
					password: {
					        required: true,
							minlength: 6
					},
					cpassword: {
						required: true,
						minlength: 6,
                        equalTo: "#checkeditpassword"
					},
					phone: {
						required: true,
						phone: true
					},
					email: {
						required: true,
						email: true
					},
					uname: {
						required: true,
						minlength: 6,
					
						
					},
					
					ic:{
					    required: true,
					    number:true,
					    
					},
					fname: {
						required: true,
						minlength: 3,
						
					},
					
					credit: {
					       min: 0,
                            required: true,
					},
						address: {
                            required: true,
					},
						sname: {
                            required: true,
					},
						cname: {
                            required: true,
					},
						bdetail: {
                            required: true,
					},
					
					phone:{
					    required: true,
					    number:true
					}
				
				
				},
				messages: {
					uname: {
						required: "Please enter a username",
						minlength: "Your username must consist of at least 6 characters",
						
					       },
				    password: {
						required: "Please enter a password",
						minlength: "Your password must consist of at least 6 characters",
						
					},
					cpassword: {
						required: "Please enter a  confirm password",
						minlength: "Your password must consist of at least 6 characters",
						
					},
						credit: {
					       min: "Your amount cannot be less than 0.",
					     
					},
						ic:{
					    required: "Please enter IC number",
					    regex: "Please enter a valid ICnumber"
					},
						phone:{
					    required: "Please enter a phone number",
				        pattern: "Please enter a valid phone number"
					},
				}
			});
		
			
		
			
		
			
			
		});
		
</script>

