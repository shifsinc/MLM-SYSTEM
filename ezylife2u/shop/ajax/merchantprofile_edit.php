<?php
	include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
    $user = $db->where('*','mv_user','mv_user_id',$id);
    $user = $user[0];
	
    
?>
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title">Edit Profile</h4>
	
</div>
<div class="modal-body">
	
	<?php
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
	
	
	<form role="form" id="form_edit" action="soap_func.php?type=editprofilemer&tb=user" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<div class="hr-line-dashed"></div>
		
		<div class="form-group"><label>Username</label>
			<input type="text" placeholder="Enter username" class="form-control" name="uname" value="<?php echo $user["mv_user_name"]; ?>">
		</div>
		
		<div class="form-group"><label>Change password? :</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck"  onclick="myFunction()" name="checkpass" value="checked"></div>
				<div id="text" style="display:none">
				    <div class="form-group"><label>Old Password</label> <input type="password" placeholder="Enter old password" class="form-control" name="opassword"value="<?php echo $decpass; ?>" > </div>
				    <div class="form-group"><label>New Password</label> <input type="password" placeholder="Enter new password" class="form-control" name="password" id="checkpassword"  value="<?php echo $decpass; ?>"></div>
				    <div class="form-group"><label>Confirm New Password</label> <input type="password" placeholder="Enter comfirm new password" class="form-control" name="cpassword" value="<?php echo $decpass; ?>"></div>
				    
		</div> 
		
		<div class="form-group"><label>Fullname</label>
			<input type="text"  placeholder="Enter fullname" class="form-control" name="fname" value="<?php echo $user["mv_user_fullname"]; ?>">
		</div>
		
		<div class="form-group"><label>NRIC</label>
			<input type="text"  placeholder="eg. 931120-06-5555" class="form-control" name="ic" value="<?php echo $user["mv_user_ic"]; ?>">
		</div>
		
		<div class="form-group"><label>Phone Number</label>
			<input type="text"  placeholder="eg. XXX-XXXXXXX" class="form-control" name="phone" value="<?php echo $user["mv_user_phnum"]; ?>">
		</div>
		
		<div class="form-group"><label>Email</label>
			<input type="text"  placeholder="Enter email" class="form-control" name="email" value="<?php echo $user["mv_user_email"]; ?>">
		</div>
		<div class="form-group"><label>Passport </label> 
		     <input type="text" placeholder="Enter passport" class="form-control" name="passport"  value="<?php echo $user["mv_user_passport"]; ?>">
		</div>
		<div class="form-group"><label>Address</label> 
			<input type="text" placeholder="Enter Address" class="form-control" name="address"  value="<?php echo $user["mv_merchant_address"]; ?>"> 
		</div>
		<div class="form-group"><label>Shop Name</label> 
			<input type="text" placeholder="Enter Shop Name" class="form-control" name="sname"  value="<?php echo $user["mv_merchant_shopname"]; ?>">
		</div>
		<div class="form-group"><label>Company Name</label> 
			<input type="text" placeholder="Enter Company Name" class="form-control" name="cname"  value="<?php echo $user["mv_merchant_cname"]; ?>">
		</div>
			<div class="form-group">
             <label class="font-normal">Change Close Day<span class="text-danger"><strong> (If you want to change close day)</strong></span></label>
                 <div>
                     <select  class="chosen-select" name="cday" tabindex="2" >
                         <option  selected value="<?php echo $user["mv_merchant_close_day"] ?>" > -- select an option -- </option>
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
           	<div class="form-group">
                                        <label class="font-normal">Add State<span class="text-danger"><strong> (If you want to add state)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addstate" tabindex="2" >
                                                    <option disabled selected value=""> -- select an option -- </option>
                                                    
                                                   
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
        <div class="form-group"><label>Start Time</label> 
			<input type="time"  class="form-control" name="stime"  value="<?php echo $user["mv_merchant_start_time"]; ?>">
		</div>
		<div class="form-group"><label>End Time</label> 
			<input type="time"  class="form-control" name="etime"  value="<?php echo $user["mv_merchant_end_time"]; ?>">
		</div>
			<div class="form-group"><label>Bank Detail</label> 
			<input type="text" placeholder="Enter Bank Detail" class="form-control" name="bdetail"  value="<?php echo $user["mv_merchant_bank"]; ?>">
		</div>
			<div class="form-group"><label>Web Link</label> 
			<input type="text" placeholder="Enter Web Link" class="form-control" name="link"  value="<?php echo $user["mv_merchant_link"]; ?>">
		</div>
			<div class="form-group"><label>Introduction</label> 
			<input type="text" placeholder="Enter Introduction" class="form-control" name="intro"  value="<?php echo $user["mv_merchant_intro"]; ?>">
		</div>
		
		
		<div class="form-group"><label >Photo</label> 
			<input  type="file"  id="myfile"  class="form-control" name="file" accept=".jpg, .png , .jpeg , .tiff" />
		</div>
		
		
		
		<div class="modal-footer">
			<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-white" name="btnsubmitprofile" value="<?php echo $user["mv_user_id"]; ?>">Submit</button>
			
			
			
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
			
			$('#form_edit').validate({
				rules: {
					password: {
					        required: true,
							minlength: 6
					},
					cpassword: {
						required: true,
						minlength: 6,
                        equalTo: "#checkpassword"
					},
					opassword:{
					    required: true,
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
						minlength: "Your username must consist of at least 6 characters",
						
					},
					cpassword: {
						required: "Please enter a  confirm password",
						minlength: "Your username must consist of at least 6 characters",
						
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


