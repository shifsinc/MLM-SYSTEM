<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "member";
	require_once('inc/header.php');
	
	
 
?>
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/jsTree/style.min.css" rel="stylesheet">

<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Member</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.html">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Member</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div> 
			
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				
				
				<div class="row">
					
					<div class="col-md-9 text-center">
						
					</div>	
					<div class="col-md-3 text-center">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#adduser"> &nbsp;Add Member &nbsp;</a>
						
					</div>					
					
				</div>
				<br>
				
				<div class="modal inmodal" id="adduser" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form" action="soap_func.php?type=addmember&tb=user&success=1" method="post" enctype="multipart/form-data">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add User</h4>
								</div>
								<div class="modal-body">
								    
									<?php
									 $gettype = $db->where('*','mv_user_type','mv_user_type_id',1);
				                     $gettype = $gettype[0];
				                     $type=$gettype['mv_user_type_name'];
				                     
				                     $gettype2 = $db->where('*','mv_user_type','mv_user_type_id',2);
				                     $gettype2 = $gettype2[0];
				                     $type2=$gettype2['mv_user_type_name'];
				                     
				                     $code = $db->where('*','mv_user','mv_user_id',$your_id);
				                     $getcode = $code[0]['mv_user_code'];
				                     
				                     
									?>
									
									<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser"></div>
									<div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password" id="password"></div>
									<div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter password" class="form-control" name="cpassword"></div>
									<!--div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"></div-->
									<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"></div>
									<div class="form-group"><label>Referral Code</label> <input type="text" placeholder="Your code: <?php echo $getcode  ?>" class="form-control" id="chkRef2" name="upline" ></div>
									
								    <div class="form-group" hidden><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
								        <div class="row">
								            
    								        <div class="i-checks col-md-3 text-center" ><input type="radio" name="typeid" value="2" checked="" /> <?php echo $type2; ?></div>
								        </div>
								    </div>
								    
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
									
									<div class="form-group"><label>Credit Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="credit"></div>
									<!--div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120-06-5555" class="form-control" name="ic"></div>
									<div class="form-group"><label>Phone Number</label> <input type="text" placeholder="eg. XXX-XXXXXXX" class="form-control" name="phone"></div>
									<div class="form-group"><label>Passport (Optional)</label> <input type="text" placeholder="Enter passport" class="form-control" name="passport"></div>
									<div class="form-group"><label>Beneficiary (Optional)</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck"  onclick="myFunction()" name="checkpass" value="checked"></div>
				                    <div id="text" style="display:none">
				     
				                    <div class="form-group"><label>Beneficiary Name</label> <input type="text" placeholder="Enter Beneficiary Name" class="form-control" name="bname">  </div>
				                    <div class="form-group"><label>Beneficiary NRIC</label> <input type="text" placeholder="Enter Beneficiary NRIC" class="form-control" name="bic"></div>
				                    <div class="form-group"><label>Beneficiary Phone Number</label> <input type="text" placeholder="Enter Beneficiary Phone Number" class="form-control" name="bnum"></div>
				                    </div> 
									
								
									
									
									<div class="form-group"><label>Photo</label> 
										<div class="custom-file ">
											<input  type="file"  id="myfile" class="custom-file-input" name="file" accept=".jpg, .png , .jpeg , .tiff">
											<label for="logo" class="custom-file-label">Choose file...</label>
										</div>
									</div-->
									
										
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="submit"><strong>Confirm</strong></button>
								</div>
								
							</form>
							</div>
						</div>
					</div>
					
					<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
								<div class="ibox-title">
									<h5>Relationship &nbsp; </h5>
									
								</div>
								<div class="ibox-content">
									<!-- 需要看有几个上线和几个下线再loop  -->
									<?php 
										    
    								    $currentID1 = $user["mv_user_id"];
                                        $status1 = $db->where('*','mv_user','mv_user_id',$currentID1); 
                                        $current_status1 = $status1[0]['mv_user_status'];
                                        $current_point1 = $status1[0]['mv_user_point'];
                                        
                                        // if($current_status1 == 2){
                                        //     $color1 = "text-muted";
                                        // }else if($current_status1 == 1 && $current_point1 < 100){
                                        //     $color1 = "text-danger";
                                        // }else if($current_status1 == 1 && $current_point1 >= 100){
                                        //     $color1 = "text-info";
                                        // }
                                        
                                        if($current_status1 == 2){
                                            $color1 = "text-muted";
                                        }else if($current_status1 == 1){
                                             $color1 = "text-info";
                                        }
								    
								    ?>
									
									<!--<p>Your percentage : <?php echo $current_point1; ?> %</p>-->
									<i class="fa fa-user-md text-muted" ></i> : Inactive &nbsp;
									<!--<i class="fa fa-user-md text-danger" ></i> : Active & less than 100 &nbsp;-->
									<i class="fa fa-user-md text-info" ></i> : Active
									<br><br>
									<div id="jstree1">
										<ul>
										    
											<li class="jstree-open <?php echo $color1 ?>"><span class="text-dark"><?php echo $code[0]['mv_user_fullname']; ?></span>
											
											<?php 
											    $no = 0;
											    
											 
											    
											    function printTree($level=0, $parentID=null)
                                                {   
                                                    global $db;
                                                    global $no;
                                                    // Create the query
                                                    $sql = "SELECT id FROM tree WHERE ";
                                                    $col = "*";
                                                    $tb = "mv_user";
                                                    $chkcol = "mv_user_referral";
                                                    if($parentID == null) {
                                                        $opt = null;
                                                    }
                                                    else {
                                                        $opt = intval($parentID);
                                                    }
                                                    // Execute the query and go through the results.
                                                    $result = $db->where($col,$tb,$chkcol,$opt);
                                                    if($result)
                                                    {
                                                        foreach($result as $row)
                                                        {
                                                            $no++;
                                                            
                                                            if($row['mv_user_type']==1){ $utype = 'Admin'; }else{ $utype = 'User'; }
                                                            
                                                            // Print the current ID;
                                                            $currentID = $row['mv_user_id'];
                                                            $status = $db->where('*','mv_user','mv_user_id',$currentID); 
                                                            $current_status = $status[0]['mv_user_status'];
                                                            $current_point = $status[0]['mv_user_point'];
                                                            if($current_status == 2){
                                                                $color = "text-muted";
                                                            }
                                                            else if($current_status == 1){
                                                                $color = "text-info";
                                                            }
                                                            
                                                            
                                                            $current_name = $db->where('*','mv_user','mv_user_id',$currentID); 
                                                            $current_name = $current_name[0]['mv_user_fullname'];
                                                            $parent_name = $db->where('*','mv_user','mv_user_id',$parentID);
                                                            $parent_name = $parent_name[0]['mv_user_fullname'];
                                                            
                                                            //echo "<td>$no</td><td>$row[mv_user_fullname]</td><td>".$utype."</td><td>$current_name and $parent_name</td><td>$row[mv_user_code]</td>"; ~if want to show current name~
                                                            echo "	<li class='jstree $color' >  <span class='text-dark'>$row[mv_user_fullname]</span> <span class='text-white'>l</span> ";
                                                            
                                                            echo "<span data-remote='ajax/user_user_info.php?p=$row[mv_user_id]' class='badge badge-primary' data-toggle='modal' data-target='#myModal'>View More</span>";
														   
                                                            echo "<span class='text-white'>l</span>"."<button type='button' class='badge badge-primary' value='$row[mv_user_code]' onclick='pushRef(this.value)' data-toggle='modal' data-target='#adduser'>Add User</button>";    
                                                            echo "<ul>";   
                                                            
                                                            // Print all children of the current ID
                                                            printTree($level+1, $currentID);
                                                            echo "</ul>";   
                                                            echo "</li>";  
                                                            
                                                          
                                                        }
                                                    }
                                                    else {
                                                        //die("Failed to execute query! ($level / $parentID)");
                                                    }
                                                   
                                                }
                                                
                                                
											
											    printTree(0,$_SESSION['id']);
											   
										    	?>
											
											
											</li>
										</ul>
									</div>
									
									
									
									
									<br>
									
									<p>Total Downline: <?php echo $no; ?></p>
									
									<div>
								
											
											
											
									
									</div>
									
									
									
								</div>
							</div>
						
						
						<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content animated fadeIn">
								    
								</div>
							</div>
						</div>
						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
					
						
					</div>
				</div>
				
					
				
					
				</div>
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

		<script src="js/plugins/jsTree/jstree.min.js"></script>
		  <script src="js/plugins/chosen/chosen.jquery.js"></script>
		
    <!-- blueimp gallery -->
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
		
		<style>
			.jstree-open > .jstree-anchor > .fa-folder:before {
			content: "\f07c";
			}
			
			.jstree-default .jstree-icon.none {
			width: 0;
			}
		</style>
		
		
		<!-- Jquery Validate -->
		<script src="js/plugins/validate/jquery.validate.min.js"></script>
		
		<!-- Page-Level Scripts -->
		<script>
		
		$('body').on('click', '[data-toggle="modal"]', function(){
		    if($(this).data('remote')){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
		    }
        });
     $('.chosen-select').chosen({width: "100%"});
    
    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        var text = document.getElementById("text");
        if (checkBox.checked == true){
            text.style.display = "block";
        } else {
           text.style.display = "none";
        }
    }

			
				function pushRef(usercode){
            	   //var usercode = $(this).data('code'); 
            	   
            	   $('#chkRef2').val(usercode);
            	   $("#chkRef2").trigger( "change" );
            	}
			
			
			//upload photo
			$('.custom-file-input').on('change', function() {
				let fileName = $(this).val().split('\\').pop();
				$(this).next('.custom-file-label').addClass("selected").html(fileName);
			}); 
			
			
			//for add user
        	$('#chkRef2').change(function(){
        		var refid = $(this).val();
        		var thisparent = $(this).parent();
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
        					thisparent.append('<label id="user_note" class="text-success">'+data.Msg+'</label>');
        				}else{
        					thisparent.append('<label id="user_note" class="text-danger">'+data.Msg+'</label>');
        				}
        			});
        		}
        	});
			
			
			
			
				<?php
		
					    $thisid = $user["mv_user_id"];
					    $wallet = $db->where('*','mv_wallet','mv_user_id',$thisid);
					    $wallet = $wallet[0];
					  ?>
			$('#form').validate({
				rules: {
					password: {
					        required: true,
							minlength: 6
					},
					cpassword: {
						required: true,
						minlength: 6,
                        equalTo: "#password"
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
                           max: <?php echo $wallet["mv_wallet_amt"]; ?>
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
						credit: {
					       min: "Your amount cannot be less than 0.",
					       max: "Your amount cannot more than your balance."
					     
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
			
			
			
			$(document).ready(function(){
				
				$('#jstree1').jstree({
					'core' : {
						'check_callback' : true
					},
					'plugins' : [ 'types', 'dnd' ],
					'types' : {
						'default' : {
							'icon' : 'fa fa-user-md'
						},
						'html' : {
							'icon' : 'fa fa-bus'
						},
						'svg' : {
							'icon' : 'fa fa-file-picture-o'
						},
						'css' : {
							'icon' : 'fa fa-file-code-o'
						},
						'img' : {
							'icon' : 'fa fa-file-image-o'
						},
						'js' : {
							'icon' : 'fa fa-file-text-o'
						}
						
					}
				});
				
			/*	$(function(){
					$('input[name="addressid"]').click(function(){
						if(this.value =="default"){
							$('#Defaultaddress').show();
							$('#FoodBankaddress').hide();
							$('input[name="addressinput"]').val('87,jalan air kuning,taman puahso.87870 seremban');
						}
						
						else{
							$('#Defaultaddress').hide();
							$('#FoodBankaddress').show();
							$('input[name="addressinput"]').val('FoodBank');
						}
					});
					$('#Defaultaddress').hide();
					$('#FoodBankaddress').hide();
				});*/
				
				
			});
			
			
		</script>
		
		
	</body>
</html>
