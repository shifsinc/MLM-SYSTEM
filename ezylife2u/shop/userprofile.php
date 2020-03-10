<?php
	require_once('inc/init.php');
	$PageName = "userprofile";
	require_once('inc/header.php');
    
?>
<link href="css/plugins/jsTree/style.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Profile</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.html">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Profile</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="wrapper wrapper-content">
				<div class="row animated fadeInRight">
					<div class="col-md-12">
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Profile Detail</h5>
							</div>
							<div>
								<div class="ibox-content  border-left-right">
									
									
								<?php if($user['mv_user_image']!="") {?>
						<img alt="image" class="feed-photo img-thumbnail" src="img/userprofile/<?php echo $user["mv_user_image"]; ?>" />
						<?php }
						else{
						?>
						<img alt="image" class="feed-photo img-thumbnail" src="img/userprofile/img.jpg" />
						<?php
						}
					?>
								</div>
								<div class="ibox-content profile-content">
									
									
									<h3><strong><?php echo $user["mv_user_fullname"]; ?></strong></h3>
									<?php 
									$userid=$user["mv_user_id"];
									$usercode=$user["mv_user_code"];
									
									$key = 'mumuls1314';
        							$iv = mcrypt_create_iv(
        							mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
        							MCRYPT_DEV_URANDOM
        							);
        							
        							$userid = base64_encode(
        							$iv.
        							mcrypt_encrypt(
        							MCRYPT_RIJNDAEL_128,
        							hash('sha256', $key, true),
        							$userid,
        							MCRYPT_MODE_CBC,
        							$iv
        							)
        							);
        							
        							$userid = str_replace("+", "_", $userid);
        							
        							    
        							    
    							    	$col = "*";
                                    	$tb = "mv_default";
                                    	$opt = 1;
                                    	$default = $db->get($col,$tb,$opt);
                                    	$default = $default[0];
                                    	
                                    	// get maximum downline
                                        $max_downline = $default['mv_default_max_ref'];
			                            
			                            
			                            // check number of user's downline
                                    	$col = "*";
                                    	$tb = "mv_user";
                                    	$chkcol = "mv_user_referral";
                                    	$opt = $user["mv_user_id"];
       
                                        $result = $db->where($col,$tb,$chkcol,$opt);

                                        
                                        if(count($result) < $max_downline){
                                            
                                            echo "<a value=$userid href=http://ezylife2u.com/shop/register.php?p=$userid >http://ezylife2u.com/shop/register.php?p=$userid</a>";
                                        	
                                        }else{
                                        	
                                            echo "<a value=$userid href=http://ezylife2u.com/shop/register.php?p=$userid >http://ezylife2u.com/shop/register.php?p=$userid</a><br><br>";
                                        	echo "Your downline is max. You can click button below to get link for add user to the member downline that you wish to .";
                                            
                                            $user_id = $user["mv_user_id"];
                                            
                                        	
                                        	
                                        	?>
                                        	<br>
                                        	<div class="m-t-xs btn-group">

                                                    <!--<a data-remote="ajax/user_link.php?p=<?php echo $user_id; ?>"  class="btn btn-xs btn-white" data-toggle="modal" data-target="#myModal"><i class="fa fa-user-plus"></i> Get Link</a>-->
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" href="#myModal">Get Link</button>

                                            </div>
                                            <br><br>
                                        	
                                        	<?php 

                                        }
        							

									
									?>
									
									<!--<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">-->
         <!--               				<div class="modal-dialog">-->
         <!--               					<div class="modal-content animated fadeIn">-->
                        					    
         <!--               					</div>-->
         <!--               				</div>-->
         <!--               			</div>-->
                        			
                        			

                                	
									
									
									<p><i class="fa fa-qrcode"></i> <?php echo $user["mv_user_code"]; ?></p>
									<address>
										<strong>Contact </strong><br>
										<abbr title="Phone">P:</abbr> <?php echo $user["mv_user_phnum"]; ?> <br>
										<abbr title="Email">E:</abbr> <?php echo $user["mv_user_email"]; ?>
									</address>
									
									
									<?php 
									    $referrer = $user["mv_user_referral"];
									    $result = $db->where('*','mv_user','mv_user_id',$referrer);
									    $result = $result[0];
									    
									    $passport = $user["mv_user_passport"];
                                        if( ($passport == NULL) || ($passport == "") )
                                        {
                                            $userpass = "Please insert the passport number.";
                                        }else
                                        {
                                            $userpass = $user["mv_user_passport"];
                                        }
                                        
                                        $beneficiary_name = $user["mv_beneficiary_name"];
                                        if( ($beneficiary_name == NULL) || ($beneficiary_name == "") )
                                        {
                                            $beneficiaryname = "";
                                        }else
                                        {
                                            $beneficiaryname = $user["mv_beneficiary_name"];
                                        }
                                        
                                        $beneficiary_ic = $user["mv_beneficiary_ic"];
                                        if( ($beneficiary_ic == NULL) || ($beneficiary_ic == "") || ($beneficiary_ic == 0) )
                                        {
                                            $beneficiaryic = "";
                                        }else
                                        {
                                            $beneficiaryic = $user["mv_beneficiary_ic"];
                                        }
                                        
                                        $beneficiary_phnum = $user["mv_beneficiary_phnum"];
                                        if( ($beneficiary_phnum == NULL) || ($beneficiary_phnum == "") || ($beneficiary_phnum == 0) )
                                        {
                                            $beneficiaryphnum = "";
                                        }else
                                        {
                                            $beneficiaryphnum = $user["mv_beneficiary_phnum"];
                                        }
									?>
									
									<h5>
										Referral : <?php echo $result["mv_user_fullname"]; ?>
									</h5>
									<h5>
										Referral Code : <?php echo $result["mv_user_code"]; ?>
									</h5>
									<h5>
										State: <?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
											$result = $db->where('*',$tb,'mv_user_state.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_state_name"];
												}
												?>
									</h5>
								
									<p>
									<i class=""></i> 	
									</p>
									
									
								
									
									<div class="row m-t-lg">
										<div class="col-md-4">
										
										
										</div>
										<div class="col-md-4">
											
										
										</div>
										<div class="col-md-4">
											
											
										</div>
									</div>
									<div class="user-button">
										<div class="row">
											<div class="col-md-12 text-center">
											<a data-remote="ajax/userprofile_edit.php?p=<?php echo $user['mv_user_id']; ?>" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-gear"></i>Edit Profile</a>
													<!--a data-toggle="modal" class="btn btn-primary btn-sm btn-block" href="<?php echo '#'.$user["mv_user_id"]; ?>"><i class="fa fa-gear"></i>Edit Profile</a-->
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
						
						
						
						<!--div id="<?php echo $user["mv_user_id"]; ?>" class="modal inmodal" role="dialog"  aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content animated fadeIn">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
										
										<h4 class="modal-title">Profile Edit</h4>
										
									</div>
									
									<div class="modal-body">
										
										<div class="row">
											<div class="col-lg-12 ">
												
												<form role="form" id="form" action="soap_func.php?type=editprofile&tb=user" method="post" enctype="multipart/form-data">
													<input type="hidden" name="token" value="<?php echo $token; ?>" />
													<div class="hr-line-dashed"></div>
													<div class="form-group row"><label class="col-sm-2 col-form-label">Name</label>
														<div class="col-sm-10"><input type="text" placeholder="Name" class="form-control" name="name" value="<?php echo $user["mv_user_fullname"]; ?>"></div>
													</div>
													
													<div class="form-group row"><label class="col-sm-2 col-form-label">Email</label>
														<div class="col-sm-10"><input type="email" id="exampleInputEmail2" placeholder="Email" class="form-control" name="email"value="<?php echo $user["mv_user_email"]; ?>" ></div>
													</div>
													
													<div class="form-group row"><label class="col-sm-2 col-form-label">Phone number</label>
														<div class="col-sm-10"><input type="text" placeholder="Phone number" class="form-control" name="phonenumber" value="<?php echo $user["mv_user_phnum"]; ?>"></div>
													</div>
												    <div class="form-group row"><label class="col-sm-2 col-form-label">Photo</label> 
        			<div class="col-sm-10">
        				<input  type="file"  id="myfile"  class="form-control" name="file" accept=".jpg, .png , .jpeg , .tiff" required="">
        			
        			</div>
        		</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
														<button type="submit" class="btn btn-primary" name="btnsubmit"><strong>Save changes</strong></button>
													</div>
												</form>
											</div>
											
										</div>
									</div>
									
								</div>
							</div>
						</div-->
						
						
						
						
					</div>
					
				</div>
			</div>
			
	    	<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content animated fadeIn">
						
						 <div class="modal-header">
    
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            		
                            		<h4 class="modal-title">Get Link</h4>
                            		<br>
                            		<p>Please select your downline to add user.</p>
                            	</div>
                            	
                            	<div class="modal-body">
                            		
                                    <div class="ibox ">
                        				<div class="ibox-title">
                        					<h5>Relationship &nbsp; </h5>
                        					
                        				</div>
                        				<div class="ibox-content">
                        					<!-- 需要看有几个上线和几个下线再loop  -->
                        					<?php 
                        						    
                        					    $currentID1 = $user1["mv_user_id"];
                                                $status1 = $db->where('*','mv_user','mv_user_id',$currentID1); 
                                                $current_status1 = $status1[0]['mv_user_status'];
                        
                        
                                                if($current_status1 == 2){
                                                    $color1 = "text-muted";
                                                }else if($current_status1 == 1){
                                                     $color1 = "text-info";
                                                }
                        				    
                        				    ?>
                        					
                        
                        					<i class="fa fa-user-md text-muted" ></i> : Inactive &nbsp;
                        					<i class="fa fa-user-md text-info" ></i> : Active
                        					<br><br>
                        					<div id="jstree1">
                        						<ul>
                        						    
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
                        
                                                                    if($current_status == 2){
                                                                        $color = "text-muted";
                                                                    }
                                                                    else if($current_status == 1){
                                                                        $color = "text-info";
                                                                    }
                                                                    
                                                                        
                                							    	$col = "*";
                                                                	$tb = "mv_default";
                                                                	$opt = 1;
                                                                	$default = $db->get($col,$tb,$opt);
                                                                	$default = $default[0];
                                                                	
                                                                	// get maximum downline
                                                                    $max_downline = $default['mv_default_max_ref'];
                            			                            
                            			                            
                            			                            // check number of user's downline
                                                                	$col = "*";
                                                                	$tb = "mv_user";
                                                                	$chkcol = "mv_user_referral";
                                                                	$opt = $row["mv_user_id"];
                                   
                                                                    $result = $db->where($col,$tb,$chkcol,$opt);
                                                                    
                                                                    if(count($result) < $max_downline){
                                                                    
                                                                        //if downline less then max_downline
                                                                        $check_ref_status = true;
                                                                        $linkcolor = "badge-primary";
                                                                        
                                                                        
                                                                	
                                                                    }else{
                                                                        
                                                                        $check_ref_status = false;
                                                                        $linkcolor = "badge-danger";
                                                                    }
                                                                    
                                                                    
                                                                    
                                                                   
                                                                    echo "	<li class='jstree $color' >  <span class='text-dark'>$row[mv_user_fullname]</span> <span class='text-white'>l</span> ";
                                                                    
                                                                    
                                                                    
                                                                    echo "<span data-remote='ajax/getlink.php?p=$currentID' class='badge $linkcolor ' data-toggle='modal' data-target='#getlink'  >Get Link</span>";
                        										   
                                                                    // echo "<span class='text-white'>l</span>"."<button type='button' class='badge badge-primary' value='$row[mv_user_code]' onclick='pushRef(this.value)' data-toggle='modal' data-target='#adduser'>Add User</button>";    
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
                        					
                        				</div>
                        			</div>    		
                            		
                            	    
                            	   
                            	   
                            	 
                            		
                            	</div>
                            	<div class="modal-footer">
                            		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            	</div>
						
					</div>
				</div>
			</div>
			
		    <div class="modal inmodal" id="getlink" tabindex="-1" role="dialog"  aria-hidden="true">
    			<div class="modal-dialog">
    				<div class="modal-content animated fadeIn">
    				    
    				</div>
    			</div>
    		</div>
    		
            <div class="modal inmodal" id="nolink" tabindex="-1" role="dialog"  aria-hidden="true">
    			<div class="modal-dialog modal-sm">
    				<div class="modal-content animated fadeIn">
                            <div class="modal-header">
    
                            </div>
                            <div class="modal-body text-center">

                            	This is full
                            </div>
                            <div class="modal-footer">
                        		<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                            </div>
    
    				</div>
    			</div>
    		</div>
			
			
			<!-- Content write here END -->
			<?php require_once('inc/footer.php'); ?>
		</div>
		
		
		
		
		<?php require_once('inc/right_nav.php'); ?>
	</div>
	
    <!-- Mainly scripts -->
    <?php
		require_once('inc/scripts.php');
	?>
	
	
	
	
    
</body>
</html>
    	
    	
<script src="js/plugins/jsTree/jstree.min.js"></script>

<style>
	.jstree-open > .jstree-anchor > .fa-folder:before {
	content: "\f07c";
	}
	
	.jstree-default .jstree-icon.none {
	width: 0;
	}
</style>    	
<script>

    
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

		});
    
    
</script>



<script>
	
	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
</script>
