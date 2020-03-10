<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "userlist";
	require_once('inc/header.php');
?>
 <link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
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

					<div class="col-md-3 " style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#adminadd"><i class="fa fa-send"></i> &nbsp;Add <?php echo $point; ?> &nbsp;</a>
						
					</div>
					<div class="col-md-3 " style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#adminaddpending"><i class="fa fa-send"></i> &nbsp;Add Pending Wallet &nbsp;</a>
						
					</div>
					<div class="col-md-2 " style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#addmerchant"> &nbsp;Add Merchant</a>
						
					</div>
					<div class="col-md-2 " style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#addseller"> &nbsp;Add Wholesaler</a>
						
					</div>
					<div class="col-md-2 " style="margin-top: 2px;">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#adduser"> &nbsp;Add User</a>
						
					</div>
					
				</div>
				<br>
				
				<div class="modal inmodal" id="adminadd" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">

					    	<form role="form" id="form1" action="soap_func.php?type=addcredit&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add <?php echo $point; ?></h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Amount</label> <input type="number" placeholder="Enter amount" class="form-control" name="addcoin"></div>
									
									<div class="form-group"><label>User Code</label> <input type="text" placeholder="Enter user code" class="form-control" name="usercode" id="chk_user"></div>
									
										<div class="form-group"><label>Remark (Optional)</label> <input type="text" placeholder="Enter remark" class="form-control" name="remark" ></div>
									
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnaddcredit"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				<div class="modal inmodal" id="adminaddpending" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content animated fadeIn">

					    	<form role="form" id="form_add_pending" action="soap_func.php?type=addpendingwallet&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add <?php echo $point; ?></h4>
								</div>
								<div class="modal-body">
									
									
									<div class="form-group"><label>Amount</label> <input type="number" placeholder="Enter amount" class="form-control" name="add_pending"></div>
									
									<div class="form-group"><label>User Code</label> <input type="text" placeholder="Enter user code" class="form-control" name="usercode" id="chk_user_pending"></div>
									
										<div class="form-group"><label>Remark (Optional)</label> <input type="text" placeholder="Enter remark" class="form-control" name="remark" ></div>
									
									
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="btnaddpending"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
				
				<div class="modal inmodal" id="adduser" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_add_user" action="soap_func.php?type=add&tb=user&success=1" method="post" enctype="multipart/form-data">
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
				                     
				                     
				                     
				                     
									?>
									
									<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser"></div>
									<div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password" id="checkpassword"></div>
									<div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter password" class="form-control" name="cpassword"></div>
									<!--div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"></div-->
									<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"></div>
									<div class="form-group"><label>Referral Code (Optional)<span class="text-danger">&nbsp; ->When add admin can empty this &nbsp; ->If add user empty this mean is first level </span> </label> <input type="text" placeholder="Enter referral code" class="form-control" id="chkRef2" name="upline"></div>
									
								    <div class="form-group"><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
								        <div class="row">
								            <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="1" /> <?php echo $type; ?></div>
    								        <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="2" checked="" /> <?php echo $type2; ?></div>
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
									
									<!--div class="form-group"><label><?php echo $point; ?> Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="credit"></div>
									<div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120-06-5555" class="form-control" name="ic"></div>
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
				
				
				<div class="modal inmodal" id="addmerchant" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_add_merchant" action="soap_func.php?type=addmerchant&tb=user&success=1" method="post" enctype="multipart/form-data">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Merchant</h4>
								</div>
								<div class="modal-body">
								    
									<?php
									 $gettype = $db->where('*','mv_user_type','mv_user_type_id',1);
				                     $gettype = $gettype[0];
				                     $type=$gettype['mv_user_type_name'];
				                     
				                     $gettype2 = $db->where('*','mv_user_type','mv_user_type_id',2);
				                     $gettype2 = $gettype2[0];
				                     $type2=$gettype2['mv_user_type_name'];
				                     
				                     $gettype4 = $db->where('*','mv_user_type','mv_user_type_id',4);
				                     $gettype4 = $gettype4[0];
				                     $type4=$gettype4['mv_user_type_name'];
				                     
				                     
				                     
				                     
									?>
									
									<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser"></div>
									<div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password1" id="checkpassword1"></div>
									<div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter password" class="form-control" name="cpassword1"></div>
									<div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"></div>
									<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"></div>
									
								    <div class="form-group" hidden><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
								        <div class="row">
								            <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="1" /> <?php echo $type; ?></div>
    								        <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="2" /> <?php echo $type2; ?></div>
    								        <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="4" checked="" /> <?php echo $type4; ?></div>
								        </div>
								    </div>
									
									<div class="form-group" hidden><label><?php echo $point; ?> Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="credit"></div>
									<div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120-06-5555" class="form-control" name="ic"></div>
									<div class="form-group"><label>Phone Number</label> <input type="text" placeholder="eg. XXX-XXXXXXX" class="form-control" name="phone"></div>
									<div class="form-group"><label>Address</label> <input type="text" placeholder="Enter Address" class="form-control" name="address"></div>
									<div class="form-group"><label>Shop Name</label> <input type="text" placeholder="Enter Shop Name" class="form-control" name="sname"></div>
									<div class="form-group"><label>Company Name</label> <input type="text" placeholder="Enter Company Name" class="form-control" name="cname"></div>
										<div class="form-group">
                                        <label class="font-normal">Category<span class="text-danger"><strong> (Please check your category before submit)</strong></span></label>
                                            <div>
                                                <select  class="chosen-select" name="under_cate" tabindex="2" >
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        											$tb = 'mv_product';
        											$opt = "mv_product_status = ? AND mv_user_type = ?";
                                                  	$arr = array(1,4);
        											$result = $db->advwhere('*',$tb,$opt,$arr);
    											foreach($result as $cate){
    											?>
                                                <option selected value="<?php echo $cate['mv_product_id']; ?>"><?php echo $cate['mv_product_name']; ?></option>
                                                
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
									<div class="form-group"><label>State</label><span class="text-danger"><strong> (Please select at least one state)</strong></span>
									<div class="row ">
									    <?php
									    $result = $db->get('*','mv_state',1);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="statechecked[]" value="<?php echo $row['mv_state_id']; ?>"  /> <?php echo $row['mv_state_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
										<div class="form-group">
                                        <label class="font-normal">Change Close Day</label>
                                            <div>
                                                <select  class="chosen-select" name="cday" tabindex="2" >
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
	                          		<input type="time"  class="form-control" name="stime">
	                          	</div>
	                          	<div class="form-group"><label>End Time</label> 
	                          		<input type="time"  class="form-control" name="etime">
	                          	</div>
									<div class="form-group"><label>Bank Detail</label> <input type="text" placeholder="Enter Bank Detail" class="form-control" name="bdetail"></div>
									<div class="form-group"><label>Introduction (Optional)</label> <input type="text" placeholder="Enter Introduction" class="form-control" name="intro"></div>
									<div class="form-group"><label>Web Link (Optional)</label> <input type="text" placeholder="Enter Web Link" class="form-control" name="link"></div>
									<div class="form-group"><label>Passport (Optional)</label> <input type="text" placeholder="Enter passport" class="form-control" name="passport"></div>
									<div class="form-group" hidden><label>Beneficiary (Optional)</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck"  onclick="myFunction()" name="checkpass" value="checked"></div>
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
									</div>
									
										
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-primary" name="submit"><strong>Confirm</strong></button>
								</div>
								
							</form>
						</div>
					</div>
				</div>
				
					<div class="modal inmodal" id="addseller" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form_add_seller" action="soap_func.php?type=addseller&tb=user&success=1" method="post" enctype="multipart/form-data">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Add Wholesaler</h4>
								</div>
								<div class="modal-body">
								    
								<?php
									 $gettype = $db->where('*','mv_user_type','mv_user_type_id',1);
				                     $gettype = $gettype[0];
				                     $type=$gettype['mv_user_type_name'];
				                     
				                     $gettype2 = $db->where('*','mv_user_type','mv_user_type_id',2);
				                     $gettype2 = $gettype2[0];
				                     $type2=$gettype2['mv_user_type_name'];
				                     
				                     $gettype4 = $db->where('*','mv_user_type','mv_user_type_id',4);
				                     $gettype4 = $gettype4[0];
				                     $type4=$gettype4['mv_user_type_name'];
				                     
				                     $gettype3 = $db->where('*','mv_user_type','mv_user_type_id',3);
				                     $gettype3 = $gettype3[0];
				                     $type3=$gettype3['mv_user_type_name'];
				                     
				                     
				                     
				                     
									?>
									
									<div class="form-group"><label>Username</label> <input type="text" placeholder="Enter username" class="form-control" name="uname" id="chkuser"></div>
									<div class="form-group"><label>Password</label> <input type="password" placeholder="Enter password" class="form-control" name="password2" id="checkpassword2"></div>
									<div class="form-group"><label>Confirm Password</label> <input type="password" placeholder="Enter password" class="form-control" name="cpassword2"></div>
									<div class="form-group"><label>Fullname</label> <input type="text" placeholder="Enter fullname" class="form-control" name="fname"></div>
									<div class="form-group" hidden><label>Type <span class="text-danger">(Please make user your user type is correct!)</span></label>
								        <div class="row">
								            <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="1" /> <?php echo $type; ?></div>
    								        <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="2" /> <?php echo $type2; ?></div>
    								        <div class="i-checks col-md-3 text-center"><input type="radio" name="typeid" value="3" checked="" /> <?php echo $type3; ?></div>
								        </div>
								    </div>
									<div class="form-group"><label>Email</label> <input type="email" placeholder="Enter email" class="form-control" name="email"></div>
									<div class="form-group"><label>NRIC</label> <input type="text" placeholder="eg. 931120-06-5555" class="form-control" name="ic"></div>
									<div class="form-group" hidden><label><?php echo $point; ?> Amount</label> <input type="number" placeholder="Enter credit" class="form-control" name="credit"></div>
									<div class="form-group"><label>Phone Number</label> <input type="text" placeholder="eg. XXX-XXXXXXX" class="form-control" name="phone"></div>
									<div class="form-group"><label>Company Name</label> <input type="text" placeholder="Enter Company Name" class="form-control" name="cname"></div>
									
                
                                    	<div class="form-group"><label>Item Category</label><span class="text-danger"><strong> (Please select at least one item category)</strong></span>
									<div class="row ">
									    <?php
									  $i=1;
        											$tb = 'mv_product';
        											$opt = "mv_product_status = ? AND mv_user_type = ?";
                                                  	$arr = array(1,3);
        											$result = $db->advwhere('*',$tb,$opt,$arr);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="icatechecked[]" value="<?php echo $row['mv_product_id']; ?>"  /> <?php echo $row['mv_product_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
									
										<div class="form-group"><label>Main Category</label><span class="text-danger"><strong> (Please select at least one main category)</strong></span>
									<div class="row ">
									    <?php
									     $i=1;
        											$tb = 'mv_category';
        											$opt = "mv_category_status = ?";
                                                  	$arr = array(1);
        											$result = $db->advwhere('*',$tb,$opt,$arr);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="mcatechecked[]" value="<?php echo $row['mv_category_id']; ?>"  /> <?php echo $row['mv_category_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
									
									<div class="form-group"><label>State</label><span class="text-danger"><strong> (Please select at least one state)</strong></span>
									<div class="row ">
									    <?php
									    $col='mv_state_id != ?';
									    $arr=array(99);
									    $result = $db->advwhere('*','mv_state',$col,$arr);
												foreach($result as $row){
												    ?>
								            <div class="i-checks col-md-3 "><input type="checkbox" name="statechecked[]" value="<?php echo $row['mv_state_id']; ?>"  /> <?php echo $row['mv_state_name']; ?></div>
								            <?php }?>
								        </div>
									</div>
									<div class="form-group"><label>Passport (Optional)</label> <input type="text" placeholder="Enter passport" class="form-control" name="passport"></div>
									<div class="form-group"><label>Bank Detail</label> <input type="text" placeholder="Enter Bank Detail" class="form-control" name="bdetail"></div>
									<div class="form-group" hidden><label>Beneficiary (Optional)</label>&nbsp;  &nbsp;<input style="transform: scale(1.9)" type="checkbox" id="myCheck"  onclick="myFunction()" name="checkpass" value="checked"></div>
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
									</div>
									
										
									
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
								<h5>User and Admin List</h5>
								
							</div>
							
							<div class="ibox-content">
							
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    

										<thead>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Referral</th>
												<th>Pending Wallet</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
										    	$i=1;
												$tb = 'mv_user INNER JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
												$col = '(mv_user.mv_user_type = ? OR mv_user.mv_user_type = ?) AND mv_user.mv_user_status != ?';
											    $arr = array(1,2,9);
												$result = $db->advwhere('*',$tb,$col,$arr);
											
											
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<td><?php echo $row["mv_user_fullname"]; ?> </td>
													<?php
													    
													    $usertype = $row["mv_user_type"];
													    if($usertype == 1){
													        $show = "Admin";
													    }else if($usertype == 2){
													        $show = "User";
													    }else if($usertype == 3){
													         $show = "Wholesaler";
													    }else if($usertype == 4){
													         $show = "Merchant";
													    }
													    
													    
													    
													    
													    
													    $referrer = $row["mv_user_referral"];
                                        			    $result = $db->where('*','mv_user','mv_user_id',$referrer);
                                        			    $result = $result[0];
													?>
													
													<td><?php echo $show; ?></td>
													<td><?php echo $row["mv_user_name"]; ?></td>
													<td><?php echo $result["mv_user_fullname"]; ?></td>
													<td><?php echo $row["mv_wallet_pending_amt"]; ?></td>
													<td><?php echo $row["mv_wallet_amt"]; ?></td>
													<td><?php echo $row["mv_user_code"]; ?></td>
													<td class="text-center">
													    <div class="btn-group">
														<a data-remote="ajax/user_info.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">View</a>
														<!-- new --><!-- new --><!-- new --><!-- new -->
														<a data-remote="ajax/user_edit.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Edit</a>
															<?php if ($row["mv_user_type"] == 1 || $row["mv_user_type"] == 2){ ?>
														<button type="button" class="btn btn-white btn-xs btnusercode" data-toggle="modal" data-target="#adduser" data-code="<?php echo $row['mv_user_code']; ?>">
    														Add
    													</button>
    														<?php }?>
    															<?php if ($row["mv_user_type"] == 3){ ?>
    													<button type="button" class="btn btn-white btn-xs btnusercode" data-toggle="modal" data-target="#addseller">
    														Add
    													</button>
    													<?php } ?>
    															<?php if ($row["mv_user_type"] == 4){ ?>
    													<button type="button" class="btn btn-white btn-xs btnusercode" data-toggle="modal" data-target="#addmerchant">
    														Add
    													</button>
    													<?php }?>
    													
    													
    													<!--a data-remote="ajax/delete_user.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
    												
    													</div>
                                                      
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Referral</th>
												<th>Pending Wallet</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
							 
							</div>
						</div>
						

						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
					<!--merchant list -->
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							<div class="ibox-title">
								<h5>Merchant List</h5>
								
							</div>
							
							<div class="ibox-content">
							
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    

										<thead>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Status</th>
												<th>Percentage</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
										    	$i=1;
												$tb = 'mv_user INNER JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
											    $col = 'mv_user.mv_user_type = ? AND mv_user.mv_user_status != ? ORDER BY mv_user.mv_user_status';
											    $arr = array(4,9);
												$result = $db->advwhere('*',$tb,$col,$arr);
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<td><?php echo $row["mv_user_fullname"]; ?> </td>
													<?php
													    
													    $usertype = $row["mv_user_type"];
													    if($usertype == 1){
													        $show = "Admin";
													    }else if($usertype == 2){
													        $show = "User";
													    }else if($usertype == 3){
													         $show = "Wholesaler";
													    }else if($usertype == 4){
													         $show = "Merchant";
													    }
													    
													      $userstatus = $row["mv_user_status"];
                    						    if($userstatus == 0)
                    						    {
                    						        $showstatus = "Pending";
                    						        $color = " text-warning";
                    						       
                    						    }else if($userstatus == 1)
                    						    {
                    						        $showstatus = "Available";
                    						        $color = " text-success";
                    						      
                    						    }else if($userstatus == 2)
                    						    {
                    						        $showstatus = "Blocked";
                    						        $color = " text-danger";
                    						        
                    						    }
													    
													    
													    
													    $referrer = $row["mv_user_referral"];
                                        			    $result = $db->where('*','mv_user','mv_user_id',$referrer);
                                        			    $result = $result[0];
													?>
													
													<td><?php echo $show; ?></td>
													<td><?php echo $row["mv_user_name"]; ?></td>
													<td class="<?php echo $color; ?>"><?php echo $showstatus; ?></td>
													<td><?php echo $row["mv_user_point"]; ?>%</td>
													<td><?php echo $row["mv_wallet_amt"]; ?></td>
													<td><?php echo $row["mv_user_code"]; ?></td>
													<td class="text-center">
													    <div class="btn-group">
														<a data-remote="ajax/user_info.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">View</a>
														<!-- new --><!-- new --><!-- new --><!-- new -->
														<?php if ($row["mv_user_status"] <> 0){ ?>
															<a data-remote="ajax/user_edit.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Edit</a>
														<?php }?>


    													<?php if ($row["mv_user_status"] == 0){ ?>
    													<a data-remote="ajax/approve_merchant.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Approve</a>
    													
    													<?php }?>
    													
    													<!--a data-remote="ajax/delete_user.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
    												
    													</div>
                                                      
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Status</th>
												<th>Percentage</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
							 
							</div>
						</div>
						

						
						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
				
					<div class="row">
					<div class="col-lg-12">
						<div class="ibox ">
							
							<div class="ibox-title">
								<h5>Wholesaler List</h5>
								
							</div>
							
							<div class="ibox-content">
							
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
									    

										<thead>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Status</th>
												<th>Percentage</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php 
										    	$i=1;
												$tb = 'mv_user INNER JOIN mv_wallet ON mv_user.mv_user_id=mv_wallet.mv_user_id';
											    $col = ' mv_user.mv_user_type = ? AND mv_user.mv_user_status != ? ORDER BY mv_user.mv_user_status';
											    $arr = array(3,9);
												$result = $db->advwhere('*',$tb,$col,$arr);
												foreach($result as $row){
												?>
												
												<tr class="gradeX">
													<td><?php echo $i; ?></td>
													<td><?php echo $row["mv_user_fullname"]; ?> </td>
													<?php
													    
													    $usertype = $row["mv_user_type"];
													    if($usertype == 1){
													        $show = "Admin";
													    }else if($usertype == 2){
													        $show = "User";
													    }else if($usertype == 3){
													         $show = "Wholesaler";
													    }else if($usertype == 4){
													         $show = "Merchant";
													    }
													    
													      $userstatus = $row["mv_user_status"];
                    						    if($userstatus == 0)
                    						    {
                    						        $showstatus = "Pending";
                    						        $color = " text-warning";
                    						       
                    						    }else if($userstatus == 1)
                    						    {
                    						        $showstatus = "Available";
                    						        $color = " text-success";
                    						      
                    						    }else if($userstatus == 2)
                    						    {
                    						        $showstatus = "Blocked";
                    						        $color = " text-danger";
                    						        
                    						    }
													    
													    
													    
													    $referrer = $row["mv_user_referral"];
                                        			    $result = $db->where('*','mv_user','mv_user_id',$referrer);
                                        			    $result = $result[0];
													?>
													
													<td><?php echo $show; ?></td>
													<td><?php echo $row["mv_user_name"]; ?></td>
													<td class="<?php echo $color; ?>"><?php echo $showstatus; ?></td>
													<td><?php echo $row["mv_user_point"]; ?>%</td>
													<td><?php echo $row["mv_wallet_amt"]; ?></td>
													<td><?php echo $row["mv_user_code"]; ?></td>
													<td class="text-center">
													    <div class="btn-group">
														<a data-remote="ajax/user_info.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">View</a>
														<!-- new --><!-- new --><!-- new --><!-- new -->
														<?php if ($row["mv_user_status"] <> 0){ ?>
															<a data-remote="ajax/user_edit.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Edit</a>
														<?php }?>


    													<?php if ($row["mv_user_status"] == 0){ ?>
    													<a data-remote="ajax/approve_merchant.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Approve</a>
    													
    													<?php }?>
    														<?php if ($row["mv_user_type"] == 3){ ?>
    													<a data-remote="ajax/edit_scate.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Category</a>
    													
    													<?php }?>
    													
    													<!--a data-remote="ajax/delete_user.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Delete</a-->
    												
    													</div>
                                                      
													</td>
												</tr>
												
											<?php $i++; } ?>
										</tbody>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Name</th>
												<th>User Type</th>
												<th>User name</th>
												<th>Status</th>
												<th>Percentage</th>
												<th>Wallet Amount</th>
												<th>User Code</th>
												<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
							 
							</div>
						</div>
						

						<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
						<div id="blueimp-gallery" class="blueimp-gallery">
							<div class="slides"></div>
							<h3 class="title"></h3>
							<a class="prev">‹</a>
							<a class="next">›</a>
							<a class="close">×</a>
							<a class="play-pause"></a>
							<ol class="indicator"></ol>
						</div>
						
					</div>
				</div>
		
				<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
						    
						</div>
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
	
	<script src="js/plugins/dataTables/datatables.min.js"></script>
	<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
	
	<!-- blueimp gallery -->
	<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
	
	<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	
    <!-- Sweet alert -->
    <script src="js/plugins/sweetalert/sweetalert.min.js"></script>
    
    <!-- iCheck -->
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
    </script>
     
	
	
	
	
	<!-- Page-Level Scripts -->
	<script>
	
	function myFunction() {
                var checkBox = document.getElementById("myCheck");
                var text = document.getElementById("text");
                if (checkBox.checked == true){
                    text.style.display = "block";
                } else {
                   text.style.display = "none";
                }
            }
	
	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
	//for add point
	$('#chk_user').change(function(){
		var refid = $(this).val();
		var thisparent = $(this).parent();
		if(refid == ""){
			$('#ref_note').remove();
		}else{
			$('#ref_note').remove();
			$.post('api/validation.php', { ref_id: refid, type: 'check_refname' }, function(data){
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
	
	//for add pending wallet
	$('#chk_user_pending').change(function(){
	var refid = $(this).val();
	var thisparent = $(this).parent();
	if(refid == ""){
		$('#ref_note').remove();
	}else{
		$('#ref_note').remove();
		$.post('api/validation.php', { ref_id: refid, type: 'check_refname' }, function(data){
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
	
	//for return user code to modal
	$('.btnusercode').click(function(){
	   var usercode = $(this).data('code'); 
	   $('#chkRef2').val(usercode);
	   $("#chkRef2").trigger( "change" );
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
	
	
		$(document).ready(function(){
			$('.dataTables-example').DataTable({
				pageLength: 25,
				responsive: true,
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [
				{ extend: 'copy'},
				{extend: 'csv'},
				{extend: 'excel', title: 'ExampleFile'},
				{extend: 'pdf', title: 'ExampleFile'},
				
				{extend: 'print',
					customize: function (win){
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');
						
						$(win.document.body).find('table')
						.addClass('compact')
						.css('font-size', 'inherit');
					}
				}
				]
				
			});
			
    
			
		});
		
		$('.custom-file-input').on('change', function() {
			let fileName = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').addClass("selected").html(fileName);
		});
		
		
		//for validate (admin add user)
		
		$(document).ready(function(){
			
			$('#form_add_user').validate({
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
		
			
			$('#form_add_merchant').validate({
				rules: {
					password1: {
					        required: true,
							minlength: 6
					},
					cpassword1: {
						required: true,
						minlength: 6,
                        equalTo: "#checkpassword1"
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
					sname: {
					    required: true,
					    minlength: 3,
					},
					address: {
					    required: true,
					    minlength: 3,
					},
					cname: {
				        required: true,
				        minlength: 3,
					},
					bdetail: {
					    required: true,
					    minlength: 3,
					},
					ic:{
					    required: true,
					    number:true,
					    
					},
					fname: {
						required: true,
						minlength: 3,
						
					},
					cday: {
						required: true,
					
						
					},
					stime: {
						required: true,
						
						
					},
					etime: {
						required: true,
						
						
					},
					
					credit: {
					       min: 0,
                            required: true,
					},
					"statechecked[]": {
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
					        "statechecked[]": {
							required: "",
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
			
			$('#form_add_seller').validate({
				rules: {
					password2: {
					        required: true,
							minlength: 6
					},
					cpassword2: {
						required: true,
						minlength: 6,
                        equalTo: "#checkpassword2"
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
					"statechecked[]": {
							required: true,
							
						},
							"icatechecked[]": {
							required: true,
							
						},
							"mcatechecked[]": {
							required: true,
							
						},
				
					ic:{
					    required: true,
					    number:true,
					    
					},
						under_cate:{
					    required: true,
					    
					    
					},
					fname: {
						required: true,
						minlength: 3,
						
					},
					
					credit: {
					       min: 0,
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
					       "statechecked[]": {
							required: "",
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
			
			
			
			//for validate admin add v-coin to user
			$("#form1").validate({
				rules: {
					
					
					usercode: {
						required: true, 
					},
					addcoin: {
						required: true,
						number: true,
						min: 0,

					}
				},
				messages: {
					addcoin: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",

					       }
				    
				}
			});
			
			//for validate admin add pending wallet to user
			$("#form_add_pending").validate({
				rules: {
					
					
					usercode: {
						required: true, 
					},
					add_pending: {
						required: true,
						number: true,
						min: 0,

					}
				},
				messages: {
					add_pending: {
						required: "Please enter a amount",
						min: "Your amount cannot be less than 0.",

					       }
				    
				}
			});
			
			
		});
		
		
		
		
	
		
		
		
	</script>
	
	
</body>
<?php
	
?>
</html>
