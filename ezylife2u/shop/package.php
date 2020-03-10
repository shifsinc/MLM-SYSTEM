<?php
	include_once('connection/PDO_db_function.php');
	$PageName = "package";
	require_once('inc/header.php');
	$db = new DB_Functions(); 
	
	$getseller_id = $_REQUEST['p'];
	if(isset($_SESSION['pac_id'])){
	    
	    if($_SESSION['pac_type']==1){
	        header('Location: itemgrid.php');
			}else{
	        header('Location: checkout.php');
		}
	    
	}



?>


<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			
			
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Package</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Package</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			<br><br>
			<div hidden class="row wrapper border-bottom g page-heading">
			    	    <div class="col-lg-12">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    
                                    <li><a class="nav-link active filter-button btn-primary" data-filter="all" data-toggle="tab" href="#tab-1"> All</a></li>
                                    
                                    <?php 
										$i=1;
										
										$col = '*';
    									$tb = 'mv_product';
    									$chkcol = 'mv_product.mv_product_status = ? AND mv_product.mv_user_type = ?';
    									$arr = array(1,3);
    									$cate = $db->advwhere($col,$tb,$chkcol,$arr);
										
										
										
								// 		$cate = $db->get("mv_product_name, mv_product_id","mv_product",1);
										foreach($cate as $pcate){
										?>
                                    <li><a class="nav-link  filter-button" data-filter="<?php echo 'p'.str_replace(' ','',$pcate["mv_product_id"]); ?>" data-toggle="tab" href="#<?php echo 't'.str_replace(' ','',$pcate["mv_product_id"]); ?>"> <?php echo $pcate["mv_product_name"]; ?></a></li>
                                    <?php $i++; } ?>
                                    
                                    
                                </ul>
                                
                            
                               <div class="tab-content gray-bg">
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        
                                    </div>
                                    
                                     <?php 
										$i=1;
										$cate = $db->get("mv_product_name, mv_product_id","mv_product",1);
										foreach($cate as $pcate){
										?>
                                    <div role="tabpanel" id="<?php echo 't'.str_replace(' ','',$pcate["mv_product_id"]); ?>" class="tab-pane">
                                        <div class="panel-body">
                                            
                                            
                                            <div class=""> <!-- title-action -->
                                                
                                                
                                                <?php 
            										$i=1;
            										
            										$col = '*';
                									$tb = 'mv_user_product join mv_user on mv_user_product.mv_user_id=mv_user.mv_user_id';
                									$chkcol = 'mv_user.mv_user_type = ? AND mv_user_product.mv_product_id = ?';
                									$arr = array(3,$pcate["mv_product_id"]);
                									$cate = $db->advwhere($col,$tb,$chkcol,$arr);
            										
            										
            								// 		$cate = $db->where("mv_sub_product_name, mv_sub_product_id","mv_sub_product","mv_product_id",$pcate["mv_product_id"]);
            										foreach($cate as $subcate){
            										?>
            										<button class="btn btn-default filter-button" data-filter="<?php echo str_replace(' ','',$subcate["mv_user_id"]); ?>"><?php echo $subcate["mv_user_fullname"]; ?></button>
            									<?php $i++; } ?>
            								</div>
                                           
                                        </div>
                                    </div>
                                    <?php $i++; } ?>
                                    
                                    
                                </div>
        
                            </div>
                            <br>
                            <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Search">
                        </div>
                             
			    	    </div>
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
				    
				    
				     
					
					<?php 
					
					
				    	$user_state = $db->where("mv_state_id","mv_user_state","mv_user_id",$your_id);
                        $user_state = $user_state[0]['mv_state_id'];            
	
			            $i=1;
				// 		$tb = 'mv_package';
				// 		$result = $db->where('*',$tb,'mv_package_status',1);
						
						$col = '*';
    					$tb = 'mv_package join mv_package_state on mv_package.mv_package_id = mv_package_state.mv_package_id';
    					$chkcol = 'mv_package.mv_user_id =? AND mv_package.mv_package_status =? AND mv_package_state.mv_state_id =?';
    					$arr = array($getseller_id,1,$user_state);
    					$result = $db->advwhere($col,$tb,$chkcol,$arr);
    	                
    	                $wholesaler_shop_name = $db->where("mv_merchant_cname","mv_user","mv_user_id",$getseller_id);
    	                $wholesaler_shop_name = $wholesaler_shop_name[0]['mv_merchant_cname'];
						
					    if(count($result) == 0){
					        
					        echo '<p>No package at this category and your state. Please press back button and choose again.</p>';
					        
					    }else{
					        
					        
					        
					    }
					    
						foreach($result as $item){
						    
						?>
						
						<div class="col-lg-3 filter <?php echo $item["mv_user_id"]; ?> ">
							<div class="contact-box ">
								
								<h2 class="m-b-xs"><strong><?php echo $item['mv_package_name']; ?></strong></h2>
								
								<div class="font-bold"><h3 class="text-info"><?php echo $item['mv_package_price']+$item['mv_package_deli']; ?> <span class="badge badge-danger"><?php echo $point; ?></span></h3></div>
								
								<br>
								<table class="table">
									<thead>
									</thead>
    								<tbody>
    						<!--			<tr>-->
    						<!--				<td>Package Maximum Points</td>-->
    						<!--				<td><?php echo $item['mv_package_unit']; ?></td>-->
										<!--</tr>-->
    									<tr>
    										<td>Package Delivery Fee</td>
    										<td><?php echo $item['mv_package_deli']; ?></td>
										</tr>
    									
    									<?php
    									
    										$col = "*";
            			                    $tb = "mv_user join mv_wallet on mv_user.mv_user_id = mv_wallet.mv_user_id";
            			                    $chkcol = "mv_user.mv_user_id";
            			                    $opt = $_SESSION['id'];
            			                    $wallet= $db->where($col,$tb,$chkcol,$opt);
            			                    $userwallet = $wallet[0]['mv_wallet_amt'];
											
    									    $status =  $item['mv_package_status']; 
    									    
    									    if($status == 1)
    									    {
    									        $show = "Available";
    									        $class = "label label-primary";
    									        $button = "";
												}else if($status == 0){
    									        $show = "Not Available";
    									        $class = "label label-danger";
    									        $button = "disabled";
											}
											
										?>
    									
    									<tr>
    										<td>Status</td>
    										<td><span class="<?php echo $class; ?>"><?php echo $show; ?></span></td>
										</tr>
										<tr>
    										<td>Wholesaler</td>
    										<td><?php echo $wholesaler_shop_name; ?></td>
										</tr>
    									<tr>
    										<td></td>
    										<td></td>
										</tr>
									</tbody>
								</table>	
								
								<h4>
									Description
								</h4>
								
								<p>
									<?php echo $item['mv_package_desc']; ?>
								</p>
								
								
								
								
								<div class="contact-box-footer">
									<div class="m-t-xs btn-group">
									    <form role="form" id="form" action="api/cart.php?type=slcPac" method="post" enctype="multipart/form-data" class="wizard-big" action="#">
									        
									        
											<button class="btn btn-primary dim " name='btnSelfSelect' value="<?php echo $item['mv_package_id']; ?>" type="submit" <?php echo $button; ?>><i class="fa fa-check"></i>Purchase</button>        
								            
								            <input type="hidden" name="token" value="<?php echo $token; ?>" />
								            <input type="hidden" name="package" id='slcPackage' value="<?php echo $item['mv_package_id']; ?>" />
								        </form>
									</div>
								</div>
							</div>
						</div>
					<?php $i++; } ?>	
					
					
				</div>
			</div>
			
		
			
			
			
			
		

			
			<!--<div class="modal inmodal" id="modal" tabindex="-1" role="dialog"  aria-hidden="true">-->
			<!--	<div class="modal-dialog modal-sm">-->
			<!--		<div class="modal-content animated fadeIn">-->
			<!--			<form role="form" id="form" action="api/cart.php?type=slcPac" method="post" enctype="multipart/form-data" class="wizard-big" action="#">-->
			<!--				<input type="hidden" name="token" value="<?php echo $token; ?>" />-->
			<!--				<div class="modal-header">-->
			<!--					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
								
			<!--					<h4 class="modal-title">Package</h4>-->
			<!--				</div>-->
			<!--				<div class="modal-body text-center">-->
			<!--					<input type="hidden" name="package" id='slcPackage' value="" />-->
			<!--					<div class="m-t-xs btn-group">-->
			<!--						<button class="btn btn-success dim" type="submit" value='1' name='btnSelfSelect'><i class="fa fa-check"></i> Self Select</button>                -->
			<!--					</div>-->
			<!--					<div class="m-t-xs btn-group">-->
			<!--						<button class="btn btn-primary dim" type="submit" value='1' name='btnFoodBank'><i class="fa fa-building"></i> Food Bank</button>                -->
			<!--					</div>-->
			<!--					<div class="m-t-xs btn-group">-->
			<!--						<button class="btn btn-primary dim" type="submit" value='1' name='btnRandomFood'><i class="fa fa-question"></i> Random Food</button>                -->
			<!--					</div>-->
								
			<!--				</div>-->
			<!--				<div class="modal-footer">-->
			<!--					<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>-->
			<!--				</div>-->
							
			<!--			</form>-->
			<!--		</div>-->
			<!--	</div>-->
			<!--</div>	-->
		
			
			
			
			
			<!-- Content write here END -->
			<?php require_once('inc/footer.php'); ?>
		</div>
		
		
		
		
		<?php require_once('inc/right_nav.php'); ?>
	</div>
	
	<!-- Mainly scripts -->
	<?php
		require_once('inc/scripts.php');
	?>
	
	
	
	<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	
	
	
	
	<script>
		
		
		
	</script>
	
	
</body>
</html>
<script>
	$(document).ready(function(){
			$(".filter-button").click(function(){
				var value = $(this).attr('data-filter');
				
				if(value == "all")
				{
					//$('.filter').removeClass('hidden');
					$('.filter').show('1000');
				}
				else
				{
					//            $('.filter[filter-item="'+value+'"]').removeClass('hidden');
					//            $(".filter").not('.filter[filter-item="'+value+'"]').addClass('hidden');
					$(".filter").not('.'+value).hide('3000');
					$('.filter').filter('.'+value).show('3000');
					
				}
			});
            
            
            
             $("#filter").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".filter").filter(function() {
                  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
              });
            
		});
		
    $('.btnPackage').click(function(){
        var pac_id = $(this).val();
        $('#slcPackage').val(pac_id);
	});
	</script>	