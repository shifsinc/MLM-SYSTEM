<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $user = $db->where('*','mv_user','mv_user_id',$id);
    $user = $user[0];
    
   	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
	$state = $db->where('*',$tb,'mv_user_state.mv_user_id',$id);
	$state = $state[0];
    
    $referralid=$user["mv_user_referral"];
    $usercode=$db->where('*','mv_user','mv_user_id',$referralid);
    $usercode=$usercode[0];
    
    $wallet = $db->where('*','mv_wallet','mv_user_id',$id);
    $wallet = $wallet[0];
	
    
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
			
			<form role="form" id="form_edit" action="soap_func.php?type=editsuser&tb=user" method="post" enctype="multipart/form-data">
				<input type="hidden" name="token" value="<?php echo $token; ?>" />
				<div class="hr-line-dashed"></div>
				<?php
					$gettype = $db->where('*','mv_user_type','mv_user_type_id',1);
					$gettype = $gettype[0];
					$type=$gettype['mv_user_type_name'];
					
					$gettype2 = $db->where('*','mv_user_type','mv_user_type_id',2);
					$gettype2 = $gettype2[0];
					$type2=$gettype2['mv_user_type_name'];
					
					$gettype3 = $db->where('*','mv_user_type','mv_user_type_id',3);
					$gettype3 = $gettype3[0];
					$type3=$gettype3['mv_user_type_name'];
					
					$gettype4 = $db->where('*','mv_user_type','mv_user_type_id',4);
					$gettype4 = $gettype4[0];
					$type4=$gettype4['mv_user_type_name'];
					
					$key = 'mumuls1314';
					
					$encpass = $user['mv_user_pword'];
					$data = base64_decode($encpass);
					$iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC));
					
					$decpass = rtrim(
					mcrypt_decrypt(
					MCRYPT_RIJNDAEL_128,
					hash('sha256', $key, true),
					substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC)),
					MCRYPT_MODE_CBC,
					$iv
					),
					"\0"
					);
					
					
				?>
			
			
				 
				
				
                                    		<?php if ($user["mv_user_type"] == 3){ ?>
                                    		
		<div class="form-group">
                                        <label class="font-normal">Add Main Category<span class="text-danger"><strong> (If you want to add main Category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addcategory" tabindex="2" >
                                                    <option disabled  selected hidden value='0' > -- select an option -- </option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
											$result = $db->where('*','mv_category','mv_category_status',1);
    											foreach($result as $row){
    											?>
                                                <option   value="<?php echo $row['mv_category_id']; ?>"><?php echo $row['mv_category_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
			<div class="form-group">
                                        <label class="font-normal">Delete Main Category<span class="text-danger"><strong> (If you want to delete main category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_deletecategory" tabindex="2" >
                                                    <option  disabled selected hidden value='0'> -- select an option -- </option>
                                                   
                                                <?php 
									    
        								            $j=1;
        										$thisid = $user["mv_user_id"];
									    	$tb = 'mv_category JOIN mv_user_category ON mv_category.mv_category_id=mv_user_category.mv_category_id';
											$result = $db->where('*',$tb,'mv_user_category.mv_user_id',$thisid);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_category_id']; ?>"><?php echo $row['mv_category_name']; ?></option>
                                                
                                                
                                               <?php $j++; } ?>
                                                </select>
                                            </div>
                                    </div>
                                    	<div class="form-group">
                                        <label class="font-normal">Add Item Category<span class="text-danger"><strong> (If you want to add item Category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addicategory" tabindex="2" >
                                                    <option disabled selected hidden value='0' > -- select an option -- </option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
											$result = $db->where('*','mv_product','mv_product_status',1);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_product_id']; ?>"><?php echo $row['mv_product_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
			<div class="form-group">
                                        <label class="font-normal">Delete Item Category<span class="text-danger"><strong> (If you want to delete item category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_deleteicategory" tabindex="2" >
                                                    <option disabled selected hidden value='0'> -- select an option -- </option>
                                                   
                                                <?php 
									    
        								            $j=1;
        										$thisid = $user["mv_user_id"];
									    	$tb = 'mv_product JOIN mv_user_product ON mv_product.mv_product_id=mv_user_product.mv_product_id';
											$result = $db->where('*',$tb,'mv_user_product.mv_user_id',$thisid);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_product_id']; ?>"><?php echo $row['mv_product_name']; ?></option>
                                                
                                                
                                               <?php $j++; } ?>
                                                </select>
                                            </div>
                                    </div>
                                    	<?php }?>
                                    		<!--div class="form-group"><label>Item Category</label><span class="text-danger"><strong> (Please select at least one main category)</strong></span>
									<div class="row ">
									    <?php
									                $k=1;
									               	$thisid = $user["mv_user_id"];
									            	$table = 'mv_product JOIN mv_user_product ON mv_product.mv_product_id=mv_user_product.mv_product_id';
										         	$result1 = $db->where('*',$table,'mv_user_product.mv_user_id',$thisid);
										         	
        											$tb = 'mv_product';
        											$opt = "mv_product_status = ?";
                                                  	$arr = array(1);
        											$result = $db->advwhere('*',$tb,$opt,$arr);
												foreach($result as $row){
												    
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="icatechecked[]" value="<?php echo $row['mv_product_id']; ?>" <?php 	foreach($result1 as $row1){
												    	    $checkbox_array = explode(",", $row1['mv_product_id']); if(in_array($row['mv_product_id'], $checkbox_array)){ echo " checked=\"checked\""; } } ?>  /> <?php echo $row['mv_product_name']; ?></div>
								            <?php  	}?>
								        </div>
									</div-->
                                    
				
				<div class="modal-footer">
					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-white" name="btnsubmituser" value="<?php echo $user["mv_user_id"]; ?>">Submit</button>
					
					
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

