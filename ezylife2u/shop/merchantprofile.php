<?php
	require_once('inc/init.php');
	$PageName = "merchantprofile";
	require_once('inc/header.php');
	
	
$thisid = $user["mv_user_id"];
	
	//echo 'ID:'.$id;
	$user = $db->where('*','mv_user','mv_user_id',$thisid);
    
    
    
    
    
?>

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
							
							//$userid = str_replace("+", "_", $userid);
							
								?>
									<h5>
										Web Link : <?php echo $user["mv_merchant_link"]; ?>
									</h5>
									<p><i class="fa fa-qrcode"></i> <?php echo $user["mv_user_code"]; ?></p>
									<address>
										<strong>Contact </strong><br>
										<abbr title="Phone">P:</abbr> <?php echo $user["mv_user_phnum"]; ?> <br>
										<abbr title="Email">E:</abbr> <?php echo $user["mv_user_email"]; ?>
									</address>
									
									
									<?php 
									  
									    
									     $passport = $user["mv_user_passport"];
    if( ($passport == NULL) || ($passport == "") )
    {
        $userpass = "Please insert the passport number.";
    }else
    {
        $userpass = $user["mv_user_passport"];
    }
    

        
                                    $open = $user["mv_merchant_start_time"];
                                    $close = $user["mv_merchant_end_time"];
                                    
                                    $open = strtotime($open);
                                    $close = strtotime($close);
                                    
                                    $open = date('H:i', $open); 
                                    $close = date('H:i', $close);
    
									?>
									
									<h5>
										State : <?php
									    $thisid = $user["mv_user_id"];
									    	$tb = 'mv_state JOIN mv_user_state ON mv_state.mv_state_id=mv_user_state.mv_state_id';
											$result = $db->where('*',$tb,'mv_user_state.mv_user_id',$thisid);
												foreach($result as $row){
												    echo $row["mv_state_name"].',';
												}
												?>
									</h5>
									<h5>
										Shop Name : <?php echo $user["mv_merchant_shopname"]; ?>
									</h5>
									<h5>
										Company Name: <?php echo $user["mv_merchant_cname"]; ?>
									</h5>
									<h5>
										Operation Hour : <?php echo $open;  ?> - <?php echo $close; ?>
									</h5>
									<h5>
										Close day : <?php echo $user["mv_merchant_close_day"]; ?>
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
											<a data-remote="ajax/merchantprofile_edit.php?p=<?php echo $user['mv_user_id']; ?>" class="btn btn-primary btn-sm btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-gear"></i>Edit Profile</a>
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

<script>
	
	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
   </script>
