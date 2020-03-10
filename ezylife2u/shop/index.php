<?php
    require_once('inc/init.php');
    $PageName = "index";
    require_once('inc/header.php');

    //createLog(1,'user');

?>

<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
		<?php require_once('inc/top_nav.php'); ?>
		<!-- Content write here START -->
		<?php 
		    if($onpage == 1){

		 ?>
		 
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>Home</h2>
				<ol class="breadcrumb">
					<li class="breadcrumb-item active">
						<a href="index.php">Home</a>
					</li>
					
				</ol>
			</div>
			<div class="col-lg-2">

			</div>
		</div>
		
        <div class="wrapper wrapper-content">
            
            <?php 
                
                // count user 
                // $user = $db->get('mv_user_id',"mv_user",1);

                $col="*";
                $tb ="mv_user JOIN mv_wallet ON mv_user.mv_user_id = mv_wallet.mv_user_id";
				$opt= 'mv_user.mv_user_type = ?';
				
				$arr=array(2);
				$user = $db->advwhere($col,$tb,$opt,$arr);
                
                
                $count_user = count($user)-1;
                
                
                //count request
                $col="mv_user_id";
				$opt= 'mv_request_activity = ? AND mv_request_status = ?';
				
				$arr=array(3,1);
				$withdraw = $db->advwhere($col,'mv_request',$opt,$arr);
                
                $arr=array(2,1);
				$redeem = $db->advwhere($col,'mv_request',$opt,$arr);
				
				$arr=array(1,1);
				$vcoin = $db->advwhere($col,'mv_request',$opt,$arr);
				
                //count merchant & whosaler
                $col="mv_user_id";
				$opt= 'mv_user_status = ? AND mv_user_type = ?';
				
				$arr=array(0,4);
				$merchant = $db->advwhere($col,'mv_user',$opt,$arr);
				
				$arr=array(0,3);
				$wholesaler = $db->advwhere($col,'mv_user',$opt,$arr);
                
                // $withdraw = $db->where('mv_user_id',"mv_request","mv_request_activity",3);
                // $redeem = $db->where('mv_user_id',"mv_request","mv_request_activity",2);
                // $vcoin = $db->where('mv_user_id',"mv_request","mv_request_activity",1);
                
                $count_with = count($withdraw);
                $count_redeem = count($redeem);
                $count_vcoin = count($vcoin);
                $count_merchant = count($merchant);
                $count_wholesaler = count($wholesaler);
                
                //get defaut setting
                $max = $db->get('*',"mv_default",1);
                $max_layer =$max[0]['mv_default_max_layer'];
                $max_ref =$max[0]['mv_default_max_ref'];
                $merchant_rebate = $max[0]['mv_default_merchant_rebate'];
            
            ?>
            
            
            <div class="row">
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="userlist.php" ><span class="label label-success float-right">View More</span></a>
                                <h5>User</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_user; ?></h1>
                                
                                <small>Total user</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="userlist.php" ><span class="label label-info float-right">Go Approve</span></a>
                                <h5>Merchant</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_merchant; ?></h1>
                                
                                <small>Total request</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="userlist.php" ><span class="label label-info float-right">Go Approve</span></a>
                                <h5>WholeSaler</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_wholesaler; ?></h1>
                                
                                <small>Total request</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="pending.php" ><span class="label label-primary float-right">Go Approve</span></a>
                                <h5><?php echo $point; ?></h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_vcoin; ?></h1>
                                
                                <small>Total request</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="pending.php" ><span class="label label-primary float-right">Go Approve</span></a>
                                <h5>Withdraw</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_with; ?></h1>
                                
                                <small>Total request</small>
                            </div>
                        </div>
                    </div>
                    <!--div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <a href="pending.php" ><span class="label label-danger float-right">Go Approve</span></a>
                                <h5>Redeem</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins"><?php echo $count_redeem; ?></h1>
                               
                                <small>Total request</small>
                            </div>
                        </div>
                    </div-->
        </div>
		
		<div class="row">
		 <div class="col-lg-12">
    		<div class="row">
    		    
    		    <div class="col-lg-3">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-4">
                                <a data-toggle="modal" data-target="#edit_layer" style="color:white;"><i class="fa fa-cog fa-5x"></i></a>
                            </div>
                            <div class="col-8 text-right">
                                <span> Maximun layer </span>
                                <h2 class="font-bold"><?php echo $max_layer; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
    		    
    		    <div class="col-lg-3">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-4">
                                <a data-toggle="modal" data-target="#edit_ref" style="color:white;"><i class="fa fa-cog fa-5x"></i></a>
                            </div>
                            <div class="col-8 text-right">
                                <span> Maximun Downline </span>
                                <h2 class="font-bold"><?php echo $max_ref; ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-4">
                                <a data-toggle="modal" data-target="#edit_merchant_rebate" style="color:white;"><i class="fa fa-cog fa-5x"></i></a>
                            </div>
                            <div class="col-8 text-right">
                                <span> Merchant Rebate Rate </span>
                                <h2 class="font-bold"><?php echo $merchant_rebate; ?> %</h2>
                            </div>
                        </div>
                    </div>
                </div>
    		    
    		</div>
    		
    		<div class="row">
    		    
    		  <?php
    		    
    		    $anno = $db->get('mv_default_anno',"mv_default",1);
    		    $anno = $anno[0]['mv_default_anno'];
    		    
    		    
    		  ?>
    		    
    		    <div class="col-lg-12">
    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Announcement
                        </div>
                        <div class="panel-body">
                            <p><?php echo $anno; ?></p>
                        </div>
                        <div class="panel-footer text-right fadeInRight" >
                            
                            <button type="button" class="btn btn-w-m btn-primary" data-toggle="modal" href="#edit_anno">Edit</button>
                       
        
                        </div>
                        
        
                    </div>
        		    
        		</div>
    
            </div>
        </div>
        
        
        </div>
        
        
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Landing page slide (Recommend Size: 1600 x 530 )</h5>
                        <div class="ibox-tools">
    
                            <a class=""  data-toggle="modal" href="#edit_slide1">
                                Edit Slide 1
                            </a>
                            <a class=""  data-toggle="modal" href="#edit_slide2">
                                Edit Slide 2
                            </a>
                            <a class=""  data-toggle="modal" href="#edit_slide3">
                                Edit Slide 3
                            </a>
    
    
                        </div>
                        
    
                    </div>
                    <?php 
                        
                    	$db = new DB_Functions(); 
                    	$landing_slide = $db->get('*',"mv_default",1);
                    	$img = $landing_slide[0];
                        
                    ?>
                    <div class="ibox-content">
                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="img/landing/<?php echo $img['mv_pic1'] ?>" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="img/landing/<?php echo $img['mv_pic2'] ?>" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="img/landing/<?php echo $img['mv_pic3'] ?>" alt="Third slide">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
        
        
        
        
        <div class="modal inmodal" id="edit_layer" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_layer" action="soap_func.php?type=editlayer&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Max Layer</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Enter the number of max layer</strong></h4>
                            <div class="form-group"><label>Max Layer</label> <input type="number" placeholder="Enter max layer" class="form-control" name="max_num" value="<?php echo $max_layer; ?>"></div>
                        	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEdit" >Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
		
        <div class="modal inmodal" id="edit_ref" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_ref" action="soap_func.php?type=editref&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Max Referrer</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Enter the number of max referrer</strong></h4>
                        	<div class="form-group"><label>Max Referrer</label> <input type="number" placeholder="Enter max referrer" class="form-control" name="max_num" value="<?php echo $max_ref; ?>"></div>
                                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditRef">Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
        <div class="modal inmodal" id="edit_merchant_rebate" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_ref" action="soap_func.php?type=edit_merchant_rebate&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Merchant Rebate Rate</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Enter the rate to rabate</strong></h4>
                        	<div class="form-group"><label>Rebate Rate</label> <input type="number" placeholder="Enter Rebate Rate" class="form-control" name="rebate_rate" value="<?php echo $merchant_rebate; ?>"></div>
                                    
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditRebate">Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
		        
        <div class="modal inmodal" id="edit_anno" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_layer" action="soap_func.php?type=editanno&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Announcement</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Enter Announcement</strong></h4>
                            
                            <div class="form-group">
                             
                              <textarea class="form-control" rows="5" name="announcement" ><?php echo $anno; ?></textarea>
                            </div>
                            
                            
                            <!--<div class="form-group"> <input type="text" placeholder="Enter Announcement" class="form-control" name="announcement" value="<?php echo $anno; ?>"></div>-->
                        	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditAnno" >Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
        <div class="modal inmodal" id="edit_slide1" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_slide1" action="soap_func.php?type=editslide1&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Landing Page Slide 1</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Upload Image</strong></h4>
                            
							<div class="form-group">
								<div class="custom-file ">
									<input  type="file"  id="myfile" class="custom-file-input" name="fileslide1" accept=".jpg, .png , .jpeg , .tiff">
									<label for="logo" class="custom-file-label">Choose file...</label>
								</div>
							</div>
						
   
                        	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditSlide1" >Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
		<div class="modal inmodal" id="edit_slide2" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_slide2" action="soap_func.php?type=editslide2&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Landing Page Slide 2</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Upload Image</strong></h4>
                            
							<div class="form-group">
								<div class="custom-file ">
									<input  type="file"  id="myfile" class="custom-file-input" name="fileslide2" accept=".jpg, .png , .jpeg , .tiff">
									<label for="logo" class="custom-file-label">Choose file...</label>
								</div>
							</div>
						
   
                        	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditSlide2" >Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
		
		<div class="modal inmodal" id="edit_slide3" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content animated fadeIn">
					 <form role="form" id="form_slide3" action="soap_func.php?type=editslide3&tb=user" method="post" enctype="multipart/form-data">
					 	<input type="hidden" name="token" value="<?php echo $token; ?>" />
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <i class="fa fa-laptop modal-icon"></i>
                            <h4 class="modal-title">Edit Landing Page Slide 3</h4>
                            
                        </div>
                        <div class="modal-body text-center">
                            
                            <h4><strong>Upload Image</strong></h4>
                            
							<div class="form-group">
								<div class="custom-file ">
									<input  type="file"  id="myfile" class="custom-file-input" name="fileslide3" accept=".jpg, .png , .jpeg , .tiff">
									<label for="logo" class="custom-file-label">Choose file...</label>
								</div>
							</div>
						
   
                        	
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary  btn-lg-dim" name="btnEditSlide3" >Confirm</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
        
        
        <?php  
		    }
		    else
		    {
		        echo "YOU ARE NOT ADMIN, U CANNOT LANDING THIS PAGE";
		    }
		?>
		<!-- Content write here END -->
		<?php require_once('inc/footer.php'); ?>
	</div>
	
	
	


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
    
    <!-- Jquery Validate -->
    <script src="js/plugins/validate/jquery.validate.min.js"></script>


<script>
    
            
        $('.custom-file-input').on('change', function() {
           let fileName = $(this).val().split('\\').pop();
           $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }); 
        
        $(document).ready(function(){
			
			
			$('#form_layer').validate({
				rules: {
					max_num: {
					        required: true,
							min: 0
					},

				
				},
				messages: {
					max_num: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0",
						
					       },

				}
			});
			
						
			$('#form_ref').validate({
				rules: {
					max_num: {
					        required: true,
							min: 0
					},

				
				},
				messages: {
					max_num: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0",
						
					       },

				}
			});
		
									
			$('#form_slide1').validate({
				rules: {
					fileslide1: {
					        required: true,

					},

				
				},
				messages: {
					fileslide1: {
						required: "Please upload an image",
						
					       },

				}
			});
			
			$('#form_slide2').validate({
				rules: {
					fileslide2: {
					        required: true,

					},

				
				},
				messages: {
					fileslide2: {
						required: "Please upload an image",
						
					       },

				}
			});
			
			$('#form_slide3').validate({
				rules: {
					fileslide3: {
					        required: true,

					},

				
				},
				messages: {
					fileslide3: {
						required: "Please upload an image",
						
					       },

				}
			});


			
			
		});
        
        
        
</script>
</body>
</html>
