<?php
    include_once('inc/init.php');
    
    if(isset($_SESSION['pac_id'])){
	    $pac_id = $_SESSION['pac_id'];
	    if($_SESSION['pac_type']!=1){
	        header('Location: checkout.php');
		}
		}else{
	    header('Location: package.php');
	}
    
	$PageName = "itemgrid";
	require_once('inc/header.php');
	
	if(isset($_SESSION['cart'])){
        $cart = $_SESSION['cart'];
        $used_unit = $cart['unit'];
		}else{
        $used_unit = 0;
	}
	
?>


<!-- Toastr style -->
<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Item</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php" id="top">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Item</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<?php 
			
				$user_state = $db->where("mv_state_id","mv_user_state","mv_user_id",$your_id);
                $user_state = $user_state[0]['mv_state_id'];
                
                        
                $package_id = $_SESSION['pac_id'];
                $col = "*";
        	    $tb = "mv_package";
        	    $chkcol = "mv_package_id";
        	    $opt = $package_id;
        	    $getpackage = $db->where($col,$tb,$chkcol,$opt);
                $getpackage_sellerid = $getpackage[0]['mv_user_id']
                
			?>
			
			
			<!-- layout 我过后再改，暂时这样 -->
			<div class="wrapper wrapper-content">
			    
			    
			    
		    	<div class="row"> 
				    
			    	<div class="col-md-9"> 
			    	    
                        <div class="row wrapper border-bottom gray-bg page-heading">
                        	<div class="col-lg-12">
                        		<div class="tabs-container">
                        			<ul class="nav nav-tabs" role="tablist">
                        				
                        				<li><a class="nav-link active filter-button btn-primary" data-filter="all" data-toggle="tab" href="#tab-1"> All</a></li>
                        				
                        				<?php 
                        					$i=1;
                        					
                        					$col = '*';
                        					$tb = 'mv_product join mv_user_product on mv_product.mv_product_id = mv_user_product.mv_product_id';
                        					$chkcol = 'mv_product.mv_product_status = ? AND mv_product.mv_user_type = ? AND mv_user_product.mv_user_id =?';
                        					$arr = array(1,3,$getpackage_sellerid);
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
                        									$tb = 'mv_sub_product';
                        									$chkcol = 'mv_sub_product.mv_sub_product_status = ? AND mv_sub_product.mv_product_id = ?';
                        									$arr = array(1,$pcate["mv_product_id"]);
                        									$cate = $db->advwhere($col,$tb,$chkcol,$arr);
                        									
                        									
                        									// 		$cate = $db->where("mv_sub_product_name, mv_sub_product_id","mv_sub_product","mv_product_id",$pcate["mv_product_id"]);
                        									foreach($cate as $subcate){
                        									?>
                        									<button class="btn btn-default filter-button" data-filter="<?php echo str_replace(' ','',$subcate["mv_sub_product_id"]); ?>"><?php echo $subcate["mv_sub_product_name"]; ?></button>
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
			    	    
			    	    
			    	    
						
						
					    <div class="ibox">
							<div class="row ">
								<input type="hidden" id="token" value="<?php echo $token; ?>" />
								<input type="hidden" id='curCartUnit' value="<?php echo $used_unit; ?>" />
								<?php 
                                    
                                    
          
                                            
        									$i=1;
        									$col = '*';
        									$tb = 'mv_item join mv_sub_product on mv_item.mv_sub_product_id = mv_sub_product.mv_sub_product_id join mv_product on mv_sub_product.mv_product_id = mv_product.mv_product_id join mv_item_state on mv_item_state.mv_item_id = mv_item.mv_item_id';
        									$chkcol = 'mv_item.mv_item_status = ? AND mv_sub_product.mv_sub_product_status = ? AND mv_product.mv_product_status = ? AND mv_item.mv_user_id =? AND mv_item_state.mv_state_id =?';
        									$arr = array(1,1,1,$getpackage_sellerid,$user_state);
        									$result = $db->advwhere($col,$tb,$chkcol,$arr);
        
                                            if(count($result) == 0){
                                                
                                                echo '<p> No Item of this package at your state. Please press back button and choose again.</p>';
                                                
                                            }else{
                                                
                                                	foreach($result as $item){
        									    
        
        									    
        									    $pname = $item["mv_product_name"];
        									    $name = $item["mv_sub_product_name"];
        									    
        									    $pid = $db->where("mv_product_id","mv_product","mv_product_name",$pname);
        									    $pid = $pid[0];
        									    
        									    $id = $db->where("mv_sub_product_id","mv_sub_product","mv_sub_product_name",$name);
        									    $id = $id[0];
        
        									    
        									?>
        									
        									
        									
        									<div class="col-md-3 filter <?php echo $id["mv_sub_product_id"]; ?> <?php echo 'p'.$pid["mv_product_id"]; ?>">
        										<div class="ibox">
        											<div class="ibox-content product-box">
        												
        												<div class="block-image" >
        													
        													<img class="" style="width:100%; height:210px;" src="img/item/<?php echo $item["mv_item_img"]; ?>">
        													
        												</div>
        												<div class="product-desc">
        													<span class="product-price text">
        														<?php echo $item["mv_item_unit"]; ?> <span class="text-danger">Points</span>
        													</span>
        													<!--small class="text-muted">Category : <?php echo $item["mv_product_name"]; ?></small>
        													<br>
        													<small class="text-muted">Sub-Category : <?php echo $item["mv_sub_product_name"]; ?> </small-->
        													<br>
        													<p class="product-name"> <?php echo $item["mv_item_name"]; ?></p>
        													
        													
        													
        													<div class="m-t-xs">
        														<?php echo $item["mv_item_desc"]; ?>
        													</div>
        													
        													<?php 
        													
        													    $amt = $item["mv_item_amt"];
        													    if($amt == 0){
        													        $show_amt = "SOLD OUT";
        													        $show_color = "text-danger";
        													    }else{
        													        $show_amt = $amt;
        													        $show_color = "text-success";
        													    }
        													
        													?>
        													
        													
        													<p>Inventory : <span class="<?php echo $show_color ?>"><?php echo $show_amt ?></span></p>
        													<div class="s-t text-right">
        														<form>
        															
        															<div class="row">
        															    <div class="col-md-3">
        																</div>
        															    <div class="col-md-9">
        																	<input class="touchspin input-sm" id='item_qty<?php echo $item['mv_item_id'] ?>' type="text" value="1" name="qty">
        																</div>
        															</div>
        															<br>
        															<div class="row">
        															    <div class="col-md-3">
        																</div>
        															    <div class="col-md-9">
        																	<button class="btn btn-danger dim btnAddItems" value='<?php echo $item['mv_item_id'] ?>' type="button">Add</button>
        																</div>
        															</div>
        															
        														</form>
        													</div>
        												</div>
        											</div>
        										</div>
        									</div>
        								<?php $i++; } 
                                        
                                        
                                        
                                        
                                    }
									
								?>
								
								
								
							</div>
						</div>
						
					</div>
					
					
					
					
					<?php

                                    
					
					
					
						$col = "*";
						$tb = "mv_package";
						$chkcol = "mv_package_id";
						$opt = $pac_id;    
						$package = $db->where($col,$tb,$chkcol,$opt);
						$package = $package[0];
					?>
					<div class="col-md-3"> <!-- style="position: fixed; bottom: 0px; right: 0px; z-index: 100;"   -->
						<div class="ibox" >
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
								
								<hr>
								<span>
									Original price
								</span>
								<h2 class="font-bold">
									<?php echo $package['mv_package_price']; ?>
								</h2>
								

								
								<hr>
								<span>
									Delivery Fee
								</span>
								<h2 class="font-bold">
									<?php echo $package['mv_package_deli']; ?> <?php echo $point; ?>
								</h2>
								
								<hr>
								<span>
								     Current Point (Not Include Delivery Fee)
								</span>
								<h2 class="font-bold" id='usedUnit'>
									<?php
										echo $used_unit;
									?>
								</h2>
								    <?php echo $point; ?>
								<hr>
								<span class="text-danger small" id='failed_msg'>
								</span>
								<div class="m-t-sm">
									<div class="btn-group">
										<a href="cart.php" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart"></i> Cart</a>
										<button href="#removePackage" data-toggle='modal' class="btn btn-white btn-sm"> Change Package</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				
				
				
			</div>
			
			
                <a  href="#top" style=" position: fixed; bottom: 20px; right: 20px; z-index: 100;     height: 38px;
                    width: 38px;
                    display: block;
                    background: #1ab394;
                    padding: 9px 8px;
                    text-align: center;
                    color: #fff;
                    border-radius: 50%;">
                    <i class="fa fa-arrow-up"></i>
    
                </a>
            
			
			
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
	
	<!-- TouchSpin -->
	<script src="js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
	
	<!-- Page-Level Scripts -->
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
		

		
		$('.btnAddItems').click(function(){
		    var thisbtn = $(this);
		    var item_id = thisbtn.val();
		    var item_qty = $('#item_qty'+item_id).val();
		    var token = $('#token').val();
		    thisbtn.attr('disabled',true);
		    thisbtn.html('<i class="fa fa-spin fa-spinner"></i> Loading...');
		    
		    $.post('api/cart.php', { type: 'addItems', item_id: item_id, item_qty: item_qty, token: token }, function(data){
		        data = JSON.parse(data);
		        $('#token').val(data.Token);
		        if(data.Status){
		            //Success Action
		            thisbtn.html('<i class="fa fa-check animated fadeIn"></i> Added');
		            $('#usedUnit').html(data.Unit);
		            $('#curCartUnit').val(data.Unit);

					
					if(data.Reload){
    		            setTimeout(function() {
    						thisbtn.html('Add');
    						thisbtn.attr('disabled',false);
    					}, 2000);
					    location.reload();
					}else{
					    
    		            setTimeout(function() {
    						thisbtn.html('Add');
    						thisbtn.attr('disabled',false);
    					}, 2000);
					    
					}
					
					}else{
		            //Failed Action
		            $('#failed_msg').html('<span class="animated fadeIn"><i class="fa fa-times"> '+data.Msg+'</i></span>');
		            //data.Msg to get failed msg
		            thisbtn.html('<i class="fa fa-times animated fadeIn"></i> Failed');
		            setTimeout(function() {
						thisbtn.html('Add');
						thisbtn.attr('disabled',false);
					}, 2000);
				}
			});
		});
		
		$(".touchspin").TouchSpin({
			min: 0,
			max: 30,
			buttondown_class: 'btn btn-white',
			buttonup_class: 'btn btn-white'
			
		});
		
		
	</script>
	
	
</body>
</html>
