<!DOCTYPE html>

<html>

<head>
    
    <?php
	require_once('connection/PDO_db_function.php');
	$db = new DB_Functions(); 

    
?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ezylife2u | Register</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
<div class="navbar-wrapper">
            <nav class="navbar-header page-scroll" role="navigation">
                <div class="container">
                    <a class="navbar-brand" href="../index.php">HOME</a>
                  
                    
                </div>
            </nav>
    </div>
    <div class="text-center loginscreen animated fadeInDown ">
        <div>
            <div>

                <h1 class="logo-name ">Ezylife2u</h1>

            </div>
			<div class="middle-box ">
				<h3>Welcome to Ezylife2u</h3>
				<p>Register</p>
				<form role="form" id="form_user" action="api/register.php?type=landingregister&success=1" method="post" enctype="multipart/form-data">
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<div class="hr-line-dashed"></div>
		
	
		
		                            <div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser"></div>
									<div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password" id="checkpassword"></div>
									<div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter confirm password" class="form-control" name="cpassword"></div>
									<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"></div>
									<!--div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"></div>
									
								
									<div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120065555" class="form-control" name="ic"></div>
									<div class="form-group"><label>Phone Number</label> <input type="text" placeholder="eg. 0161234567" class="form-control" name="phone"></div-->
									<div class="form-group">
                                        <label class="font-normal">State<span class="text-danger"><strong> (Default Johor)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_addstate" tabindex="2" >
                                                   
                                                    
                                                   
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
									<!--div class="form-group"><label>Passport (Optional)</label> <input type="text" placeholder="Enter passport" class="form-control" name="passport"></div>
							    	<div class="form-group"><label>Referral Code (Optional)</label> <input type="text" placeholder="Enter referral code" class="form-control" id="chkRef2" name="upline"></div>
									<div class="form-group"><label>Beneficiary (Optional)</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck"  onclick="myFunction()" name="checkpass" value="checked"></div>
				                    <div id="text" style="display:none">
				     
				                    <div class="form-group"><label>Beneficiary Name</label> <input type="text" placeholder="Enter Beneficiary Name" class="form-control" name="bname">  </div>
				                    <div class="form-group"><label>Beneficiary NRIC</label> <input type="text" placeholder="Enter Beneficiary NRIC" class="form-control" name="bic"></div>
				                    <div class="form-group"><label>Beneficiary Phone Number</label> <input type="text" placeholder="Enter Beneficiary Phone Number" class="form-control" name="bnum"></div>
				                    </div--> 
				                    
				                    	<!--div class="form-group"><label>Photo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div-->
		
		
		
		<div class="modal-footer">
			<a type="button" class="btn btn-white" data-dismiss="modal">Back</a>
			<button type="submit" class="btn btn-white" name="btnsubmituser" >Submit</button>
			
			
			
		</div>
	</form>
				<p class="m-t"> <small>Developed By Ezylife2u &copy; 2018</small> </p>
			</div>
        </div>
    </div>
    
    

    <!-- Mainly scripts -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	 <script src="js/plugins/chosen/chosen.jquery.js"></script>

</body>

</html>

<script>
 $('.chosen-select').chosen({width: "100%"});
 
            $('.custom-file-input').on('change', function() {
               let fileName = $(this).val().split('\\').pop();
               $(this).next('.custom-file-label').addClass("selected").html(fileName);
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
			
			$('#form_user').validate({
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
						file: {
						required: true,
						
					
						
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
		
			//for username checked
		$('#chkuser').change(function(){
		var userid = $(this).val();
		var thisparent = $(this).parent();
		if(userid == ""){
			$('#user_note').remove();
		}else{
			$('#user_note').remove();
			$.post('api/validation.php', { user_id: userid, type: 'check_user' }, function(data){
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
	$('#chkRef2').change(function(){
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

	
            
            

</script>