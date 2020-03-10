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
	<h4 class="modal-title">Edit User</h4>
	
</div>


<div class="modal-body">
	
	<div class="row">
		<div class="col-lg-12 ">
			
			<form role="form" id="form_edit" action="soap_func.php?type=edituser&tb=user" method="post" enctype="multipart/form-data">
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
				<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser_ajax"  value="<?php echo $user["mv_user_name"]; ?>"></div>
				<div class="form-group"><label>Change password? :</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck1"  onclick="myFunction1()" name="checkpass" value="checked"></div>
				<div id="text1" style="display:none">
				     
				    <div class="form-group"><label>New Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password" id="checkeditpassword" value="<?php echo $decpass; ?>">  </div>
				    <div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter password" class="form-control" name="cpassword" value="<?php echo $decpass; ?>"></div>
				    
				</div> 
				
				
				<div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"  value="<?php echo $user["mv_user_fullname"]; ?>"></div>
				<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"  value="<?php echo $user["mv_user_email"]; ?>"></div>
				
				<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<div class="form-group"><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
					<div class="row">
						<div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="1"  <?php if ($user["mv_user_type"] == 1): ?>
							checked="checked"
						<?php endif ?>> <?php echo $type; ?></div>
						<div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="2"  <?php if ($user["mv_user_type"] == 2): ?>
							checked="checked"
						<?php endif ?>/> <?php echo $type2; ?></div>
							<div class="i-checks col-md-3 text-center" hidden><input type="radio" name="typeid" value="3"  <?php if ($user["mv_user_type"] == 3): ?>
							checked="checked"
						<?php endif ?>/> <?php echo $type3; ?></div>
							<div class="i-checks col-md-3 text-center" hidden><input type="radio" name="typeid" value="4"  <?php if ($user["mv_user_type"] == 4): ?>
							checked="checked"
						<?php endif ?>/> <?php echo $type4; ?></div>
					</div>
				</div>
				<?php }?>
				
				<?php if ($user["mv_user_type"] == 3 || $user["mv_user_type"] == 4){ ?>
				<div class="form-group" hidden><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
					<div class="row">
					
							<div class="i-checks col-md-3 text-center" hidden><input type="radio" name="typeid" value="3"  <?php if ($user["mv_user_type"] == 3): ?>
							checked="checked"
						<?php endif ?>/> <?php echo $type3; ?></div>
							<div class="i-checks col-md-3 text-center" hidden><input type="radio" name="typeid" value="4"  <?php if ($user["mv_user_type"] == 4): ?>
							checked="checked"
						<?php endif ?>/> <?php echo $type4; ?></div>
					</div>
				</div>
				<?php }?>
				 
				
					<div class="form-group"><label>Status </label>
					<div class="row">
						<div class="i-checks col-md-3 text-center"><input type="radio" name="ustatus" value="1"  <?php if ($user["mv_user_status"] == 1): ?>
							checked="checked"
						<?php endif ?>/>Unblock</div>
						<div class="i-checks col-md-3 text-center"><input type="radio" name="ustatus" value="2"  <?php if ($user["mv_user_status"] == 2): ?>
							checked="checked"
						<?php endif ?>/>Block</div>
					</div>
				</div>
				<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<div class="form-group"><label>Wallet Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="credit"  value="<?php echo $wallet["mv_wallet_amt"]; ?>"></div>
				<div class="form-group"><label>Pending Wallet Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="pendingwallet"  value="<?php echo $wallet["mv_wallet_pending_amt"]; ?>"></div>
				<?php }?>
				<div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120-06-5555" class="form-control" name="ic"  value="<?php echo $user["mv_user_ic"]; ?>"></div>
				<div class="form-group"><label>Phone Number</label> <input type="text" placeholder="eg. XXX-XXXXXXX" class="form-control" name="phone"  value="<?php echo $user["mv_user_phnum"]; ?>"></div>
					<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<div class="form-group">
                                        <label class="font-normal">Change State<span class="text-danger"><strong> (If you want to change state)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_changestate" tabindex="2" >
                                                    <option  selected value="<?php echo $row['mv_state_id']; ?>" >-- select an option --</option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
											$result = $db->get('*','mv_state',1);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_state_id']; ?>"><?php echo $row['mv_state_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
                                    	<?php }?>
                                    		<?php if ($user["mv_user_type"] == 3){ ?>
                                    			<div class="form-group"><label>Company Name</label> <input type="text" placeholder="Enter Company Name" class="form-control" name="cname" value="<?php echo $user["mv_merchant_cname"]; ?>"></div>
	
                                    	<?php }?>
					<?php if ($user["mv_user_type"] == 4 || $user["mv_user_type"] == 3){ ?>
						<div class="form-group">
                                        <label class="font-normal">Add State<span class="text-danger"><strong> (If you want to add state)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addstate" tabindex="2" >
                                                    <option disabled selected value > -- select an option -- </option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
											$result = $db->get('*','mv_state',1);
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
                                                    <option disabled selected value> -- select an option -- </option>
                                                   
                                                <?php 
									    
        								            $j=1;
        										$thisid = $user["mv_user_id"];
									    	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
											$result = $db->where('*',$tb,'mv_user_state.mv_user_id',$thisid);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_state_id']; ?>"><?php echo $row['mv_state_name']; ?></option>
                                                
                                                
                                               <?php $j++; } ?>
                                                </select>
                                            </div>
                                    </div>
						<?php }?>
				<?php if ($user["mv_user_type"] == 4){ ?>
					<div class="form-group">
                                        <label class="font-normal">Change Category<span class="text-danger"><strong> (If you want to change category)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_changecategory" tabindex="2" >
                                                    <option  selected value="<?php echo $row['mv_product_id']; ?>" >-- select an option --</option>
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        									
        								
										         $tb = 'mv_product';
        											$result = $db->where('*',$tb,'mv_product_status',1);
    											foreach($result as $row){
    											?>
                                                <option  value="<?php echo $row['mv_product_id']; ?>"><?php echo $row['mv_product_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
				<div class="form-group">
             <label class="font-normal">Change Close Day<span class="text-danger"><strong> (If you want to change close day)</strong></span></label>
                 <div>
                     <select  class="chosen-select" name="cday" tabindex="2" >
                         <option  selected value="<?php echo $user["mv_merchant_close_day"] ?>" > -- select an option -- </option>
                         <option  value="No Off">No Off</option>
                         <option  value="Sunday">Sunday</option>
                         <option  value="Monday">Monday</option>
                         <option  value="Tuesday">Tuesday</option>
                         <option  value="Wednesday">Wednesday</option>
                         <option  value="Thurday">Thurday</option>
                         <option  value="Friday">Friday</option>
                         <option  value="Saturday">Saturday</option>
                     </select>
                 </div>
           </div>
				<div class="form-group"><label>Start Time</label> 
	         	<input type="time"  class="form-control" name="stime"  value="<?php echo $user["mv_merchant_start_time"]; ?>">
	         	</div>
	         	<div class="form-group"><label>End Time</label> 
	         	<input type="time"  class="form-control" name="etime"  value="<?php echo $user["mv_merchant_end_time"]; ?>">
	         	</div>
				<div class="form-group"><label>Address</label> <input type="text" placeholder="Enter Address" class="form-control" name="address" value="<?php echo $user["mv_merchant_address"]; ?>"></div>
				<div class="form-group"><label>Shop Name</label> <input type="text" placeholder="Enter Shop Name" class="form-control" name="sname" value="<?php echo $user["mv_merchant_shopname"]; ?>"></div>
				<div class="form-group"><label>Company Name</label> <input type="text" placeholder="Enter Company Name" class="form-control" name="cname" value="<?php echo $user["mv_merchant_cname"]; ?>"></div>
				<div class="form-group"><label>Bank Detail</label> <input type="text" placeholder="Enter Bank Detail" class="form-control" name="bdetail" value="<?php echo $user["mv_merchant_bank"]; ?>"></div>
				<div class="form-group"><label>Introduction (Optional) </label> <input type="text" placeholder="Enter Introduction" class="form-control" name="intro" value="<?php echo $user["mv_merchant_intro"]; ?>"></div>
				<div class="form-group"><label>Web Link (Optional) </label> <input type="text" placeholder="Enter Web Link" class="form-control" name="link" value="<?php echo $user["mv_merchant_link"]; ?>"></div>
				<?php }?>
				<?php if ($user["mv_user_type"] == 1 || $user["mv_user_type"] == 2){ ?>
				<div class="form-group"><label>Referral Code (Optional) </label> <input type="text" placeholder="Enter referral code" class="form-control" id="chkRef2_ajax" name="upline" value="<?php echo $usercode["mv_user_code"]; ?>"></div>
				<?php }?>
				
				
				
				
				<div class="form-group"><label>Photo</label> 
					<div class="custom-file ">
						<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff"  value="<?php echo $user["mv_user_image"]; ?>" >
						<label for="logo" class="custom-file-label">Choose file...</label>
					</div>
				</div>
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

