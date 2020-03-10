<?php
	include_once('inc/init.php');
	$PageName = "checkout";
	require_once('inc/header.php');
	
		$id = $_REQUEST['p'];
	
	//echo 'ID:'.$id;
	$user = $db->where('*','mv_user','mv_user_id',$id);
    $user = $user[0];
	
	if(isset($_SESSION['pac_id'])){
	    $pac_id = $_SESSION['pac_id'];
	}else{
	    header('Location: package.php');
	    die('Please Select Package!');
	}
	
	$cart = $_SESSION['cart'];
	$price = $_SESSION['price'];
?>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
<body>
     <script
    src="https://www.paypal.com/sdk/js?client-id=Ae6O52Q1_c9wcBDjVbvudcqYhE5_rEbtGNd_LKuEe2sZ6xbyu76hbrwZLgS3yd6ckN9_UJgSzuAgEn4P&currency=MYR&disable-card=amex">
  </script>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			

			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Check Out</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Check Out <?php echo $price; ?></strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				
				
				
				<div class="row">
					<div class="col-md-9">
						<form role="form" id="form_address" action="api/cart.php?type=checkout" method="post"  enctype="multipart/form-data" class="wizard-big"  >
						    <input type="hidden" name="token" id='token' value="<?php echo $token; ?>" />
						<div class="ibox">
							<div class="ibox-title">
								
								<h5>BILLING & SHIPPING</h5>
							</div>
							
							<!-- loop here -->
							<div class="ibox-content">
								<div class="table-responsive">
									
									
									<?php if($_SESSION['pac_type']==1 || $_SESSION['pac_type']==3) { ?>
									<div class="form-group"><label class="col-sm-4 col-form-label">Choose Your Shipping Address</label>
										<?php
										    $col = "*";
										    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
										    $chkcol = "mv_user.mv_user_id";
										    $opt = $_SESSION['id'];
										    $user_det = $db->where($col,$tb,$chkcol,$opt);
										    if(empty($user_det)){
										        $remain_amt = 0;
										    }else{
										        $remain_amt = $user_det[0]['mv_wallet_amt'];
										    }
										    
										    $col = "*";
										    $tb = "mv_package";
										    $chkcol = "mv_package_id";
										    $opt = $pac_id;
										    $package = $db->where($col,$tb,$chkcol,$opt);
										    
										    //$package_amt = $package[0]['mv_package_price'];
										?>
										<div class="col-sm-9">
											<div class=""><label> <input type="radio" value="def_addr" name="address" onclick="check(this.value)"<?php if ($user["mv_user_type"] == 1): ?>
                    							checked="checked"
                    						<?php endif ?>> <i></i> Default Address </label></div>
											<div class=""><label> <input type="radio" value="new_addr" name="address" onclick="check(this.value)" checked=""> <i></i> New Address </label></div>
	
											
											
										</div>
									</div>
									<div class="form-group"><label class="col-sm-3 col-form-label">Full Name </label>
										
										<div class="col-sm-10">
											<input type="text" placeholder="Enter Your Full Name" class="form-control" name="fname" value="" id="name_show">
											</div>
											</div>
												<div class="form-group"><label class="col-sm-3 col-form-label">Phone Number </label>
										
										<div class="col-sm-10">
											<input type="text" placeholder="Enter Your Phone Number" class="form-control" name="phonenum" value="" id="num_show">
											</div>
											</div>
									
									<div class="form-group"><label class="col-sm-3 col-form-label">Shipping Address </label>
										
										<div class="col-sm-10">
											<input type="text" placeholder="Enter Your Shipping Address" class="form-control" name="address1" value="" id="addr_show">
											</div>
											</div>
									<div class="form-group"><label class="col-sm-2 col-form-label">State </label>
									<?php 
									 $col = "*";
                        			$tb = "mv_user";
                        			$chkcol = "mv_user_id";
                        			$opt = $_SESSION['id'];
                        			$cur_user = $db->where($col,$tb,$chkcol,$opt);
                    			    
                    			    $state= $cur_user[0]['mv_user_state'];
			   
									?>
										<div class="col-sm-10">
									<select name="state" id="state" class="dropselectsec form-control" required>
													<option value="<?php echo $state; ?>"><?php echo $state; ?></option>
													<option value="Johor">Johor</option>
													<option value="Kedah">Kedah</option>
													<option value="Kelantan">Kelantan</option>
													<option value="Kuala Lumpur">Kuala Lumpur</option>
													<option value="Melaka">Melaka</option>
													<option value="Negeri Sembilan">Negeri Sembilan</option>
													<option value="Pahang">Pahang</option>
													<option value="Perak">Perak</option>
													<option value="Perlis">Perlis</option>
													<option value="Pulau Pinang">Pulau Pinang</option>											
													<option value="Selangor">Selangor</option>
													<option value="Terengganu">Terengganu</option>											
												</select>
											</div>
										    </div>
										    <div class="form-group"><label class="col-sm-3 col-form-label">City </label>
										
										<div class="col-sm-10">
											<input type="text" placeholder="Enter Your City" class="form-control" name="city" value="" id="city_show" >
											</div>
											</div>
											<div class="form-group"><label class="col-sm-3 col-form-label">Postcode </label>
										
										<div class="col-sm-10">
											<input type="text" placeholder="Enter Your Postcode" class="form-control" name="postcode" value="" id="postcode_show"  >
											</div>
											</div>
										    <div class="form-group"><label class="col-sm-3 col-form-label">Billing Address (email) </label>
										
										<div class="col-sm-10">
											<input type="email" placeholder="Enter Your Billing Address" class="form-control" name="address2" value="" id="baddr_show" >
											</div>
											</div>
									
										<?php } ?>
									
									
									
									
									<div class="form-group"><label class="col-sm-3 col-form-label">Select Your Payment Method <span class="text-danger"> *If you choose to pay online, you will be charged 5% by the customer. </span></label>
										
										<div class="col-sm-6">
											<div class="">
											    <label> <input id="pointpay" type="radio" value="vcoin" name="pay_method" onchange="showcoin();" checked> <i></i> <?php echo $point; ?> </label> &nbsp;&nbsp;&nbsp;
											    <label> <input id="onlinepay" type="radio" value="online" name="pay_method" onchange="showonline();" > <i></i> Online Payment </label>
											    
											</div>
											    
											    <div id="wallet_balance" style="display: block">
											        <div class="widget style1 lazur-bg">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <i class="fa fa-money fa-5x"></i>
                                                            </div>
                                                            <div class="col-8 text-right">
                                                                <span> Your Balance </span>
                                                                <?php 
                                                                
                                                                $user_balance = $db->where('mv_wallet_amt','mv_wallet','mv_user_id',$your_id);
                                                                $user_balance = $user_balance[0]['mv_wallet_amt'];
                                                                ?>
                                                                <h2 class="font-bold"><?php echo $user_balance; ?> <?php echo $point; ?></h2>
                                                            </div>
                                                        </div>
                                                    </div>
										         </div>
										         
											    <div id="paypal-button-container" style="display: none"></div>
											
										</div>
									</div>
									
								</div>
								
							</div>
							
							
							
							
							
							<div class="ibox-content">
								
								<?php if($remain_amt >= $price){ ?><button id="place_order" type="submit" class="btn btn-primary float-right" name="btnsubmit"><i class="fa fa fa-shopping-cart"></i> Place Order</button><?php }else { ?><button class="btn btn-primary float-right" disabled><i class="fa fa fa-shopping-cart"></i> Insufficient Balance</button> <?php } ?>
								<?php if($_SESSION['pac_type']==1){ ?><a href="itemgrid.php" class="btn btn-white"><i class="fa fa-arrow-left"></i> Continue shopping</a><?php } ?>
								<a href="#removePackage" data-toggle='modal' class="btn btn-white btn-sm"> Change Package</a>
								
							</div>
						</div>
						</form>
						
					</div>
					<div class="col-md-3">
                    <?php
                        $col = "*";
                        $tb = "mv_package";
                        $chkcol = "mv_package_id";
                        $opt = $pac_id;
                        $package = $db->where($col,$tb,$chkcol,$opt);
                        $package = $package[0];
                    ?>
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5>Cart Summary</h5>
                        </div>
                        <div class="ibox-content">
                            <span>
                                Package Name
                            </span>
                            <h2 class="font-bold">
                                <?php echo $package['mv_package_name']; ?>
                            </h2>
                            
                            <hr/>   
                            <span>
                                Original price
                            </span>
                            <h2 class="font-bold">
                                <?php echo $package['mv_package_price']; ?>
                            </h2>

                            <hr/>
   							<span>
								Delivery Fee
							</span>
							<h2 class="font-bold">
								<?php echo $package['mv_package_deli']; ?> <?php echo $point; ?>
							</h2>

                            <hr/>
                            <span>
                                Total Payment Price (Included Delivery Fee)
                            </span>
                            <h2 class="font-bold">
                                
                                <?php 
                                
                                if($cart['unit'] > $package['mv_package_price']){
                                    
                                    echo $cart['unit']+$package['mv_package_deli']; 
                                    
                                }else{
                                    
                                    echo $package['mv_package_price'] + $package['mv_package_deli']; 
                                }
                                
                                
                                
                                
                                
                                ?>
                            </h2>

                            <hr/>
                            <span class="text-muted small" id='errorMsg'>
                                
                            </span>
                            <div class="m-t-sm">
                                <div class="btn-group">
                                <button href="#removePackage" data-toggle='modal' class="btn btn-white btn-sm"> Change Package</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
				</div>
				
			</div>
			
			
			
			
			
			<!-- Content write here END -->
			<?php require_once('inc/footer.php'); ?>
		</div>
		
		
		
		
		<?php require_once('inc/right_nav.php'); ?>
	</div>
	
	
	<div class="modal inmodal" id="removePackage" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content animated fadeIn">
				<form role="form" id="form" action="api/cart.php?type=removePackage" method="post" enctype="multipart/form-data" class="wizard-big" action="#">
				    <input type="hidden" name="token" value="<?php echo getToken(); ?>" />
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						
						<h4 class="modal-title">Change Package</h4>
					</div>
					<div class="modal-body text-center">
						<p>
						    <i class='fa fa-alert fa-2x text-danger'></i> Your Selected Items Will Be Removed If You Wish To Change Package. <br> Press <b>Confirm</b> To Continue.
						</p>
					</div>
					<div class="modal-footer">
						<button class="btn btn-danger dim" type="submit" value='1' name='btnRemovePackage'><i class="fa fa-alert"></i> Confirm</button>   
						<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
					</div>
					
				</form>
			</div>
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
	
	<script src="js/plugins/dataTables/datatables.min.js"></script>
	<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
	
	
	<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	
	<!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js"></script>
    
      <!-- paypal api -->
    <script src="js/api/paypal.js"></script>
	<script>
	
            function showcoin(){
              document.getElementById('paypal-button-container').style.display ='none';
              document.getElementById('wallet_balance').style.display = 'block';
              $("#place_order").attr("disabled", false);
            }
            function showonline(){
              document.getElementById('paypal-button-container').style.display = 'block';
              document.getElementById('wallet_balance').style.display ='none';
              $("#place_order").attr("disabled", true);
            
		    var order_address = $('#addr_show').val();
		    var order_postcode = $('#postcode_show').val();
		    var order_city = $('#city_show').val();
		    var order_baddr = $('#baddr_show').val();
		    
		    if(order_address == '' || order_postcode == '' || order_city == '' || order_baddr == ''){
		        alert('Please Enter Your Address! And Make Sure Your Details Is Correct! ');
		        $("#pointpay").prop("checked", true);
                document.getElementById('paypal-button-container').style.display ='none';
                document.getElementById('wallet_balance').style.display = 'block';
                $("#place_order").attr("disabled", false);
		    }
              
            }
	
		$(document).ready(function () {
			$('.i-checks').iCheck({
				checkboxClass: 'icheckbox_square-green',
				radioClass: 'iradio_square-green',
			});
			
			$("#form_address").validate({
				rules: {
					address1: {
						required: true, 
					    
				},
					fname: {
						required: true, 
					    
				},
				phonenum: {
						required: true, 
					    
				},
				city: {
						required: true, 
					    
				},
				postcode: {
						required: true, 
					    
				},
				address2: {
						required: true, 
					    
				},
				messages: {
					address1: {
						required: "Please enter a shipping address",
						
					       },
					       	city: {
						required: "Please enter a city", 
					    
				},
				postcode: {
						required: "Please enter a postcode", 
					    
				},
				address2: {
						required: "Please enter a billing address", 
					    
				},
				}
				}
			});
			
			

			

		});
		
				<?php 
			     $col = "*";
    			$tb = "mv_user";
    			$chkcol = "mv_user_id";
    			$opt = $_SESSION['id'];
    			$cur_user = $db->where($col,$tb,$chkcol,$opt);
			     $fname= $cur_user[0]['mv_user_fullname'];
			      $phonenum= $cur_user[0]['mv_user_phnum'];
			    $addr= $cur_user[0]['mv_user_addr'];
			    $baddr= $cur_user[0]['mv_user_baddr'];
                $city= $cur_user[0]['mv_user_city'];
                $postcode= $cur_user[0]['mv_user_postcode'];
			
			?>
		
		function check(addr_value) {
		    	var user_name = "<?php echo $fname; ?>";
		    		var user_num = "<?php echo $phonenum; ?>";
			var user_addr = "<?php echo $addr; ?>";
			var user_city = "<?php echo $city; ?>";
			var user_baddr = "<?php echo $baddr; ?>";
			var user_postcode = "<?php echo $postcode; ?>";
			if(addr_value == "def_addr"){
				document.getElementById("name_show").value=user_name;
				document.getElementById("num_show").value=user_num;
				document.getElementById("addr_show").value=user_addr;
				document.getElementById("city_show").value=user_city;
				document.getElementById("baddr_show").value=user_baddr;
				document.getElementById("postcode_show").value=user_postcode;
				}else if(addr_value == "new_addr"){
				    document.getElementById("name_show").value="";
					document.getElementById("name_show").placeholder="Enter Your Full name";
					
					document.getElementById("num_show").value="";
					document.getElementById("num_show").placeholder="Enter Your Phone Number";
				
					document.getElementById("addr_show").value="";
					document.getElementById("addr_show").placeholder="Enter Your Shipping Address";
					
					document.getElementById("city_show").value="";
					document.getElementById("city_show").placeholder="Enter Your City";
					
					document.getElementById("baddr_show").value="";
					document.getElementById("baddr_show").placeholder="Enter Your Billing Address";
					
					document.getElementById("postcode_show").value="";
					document.getElementById("postcode_show").placeholder="Enter Your Postcode";
				}
			 
			}
	</script>
	
	  <script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: '<?php echo $price * 1.05; ?>'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // Capture the funds from the transaction
      return actions.order.capture().then(function(details) {
        // Show a success message to your buyer
        alert('Transaction completed by ' + '<?php echo $user['mv_user_name']; ?>');
             var user_fname = $('#name_show').val();
		    var user_phnum = $('#num_show').val();
		    var order_address = $('#addr_show').val();
		    var order_state = $('#state').val();
		    var order_postcode = $('#postcode_show').val();
		    var order_city = $('#city_show').val();
		    var order_baddr = $('#baddr_show').val();
            var token = $('#token').val();
		    

// 		    $.post('api/cart.php', { type: 'online_checkout', address1: order_address, state: order_state, address2: order_baddr, city: order_city, postcode: order_postcode }, function(data){
		        
// 			});
        
        $.ajax({

            type: "POST",
            url: 'api/cart.php',
            data: {type: 'online_checkout', address1: order_address, fname: user_fname, phonenum: user_phnum, state: order_state, address2: order_baddr, city: order_city, postcode: order_postcode, token: token},
            success: function(data){
                alert(data);
                window.location.href = "checkorder.php";
            }
            
            
        });

        // window.location.href='package.php';
        
        return fetch('/paypal-transaction-complete', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: data.orderID
          })
        });
        
        
      });
      
    }
  }).render('#paypal-button-container');
  
  
  
  
</script>
	
</body>
</html>
