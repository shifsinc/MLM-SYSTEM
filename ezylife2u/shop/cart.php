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
	
	$PageName = "cart";
	require_once('inc/header.php');
?>

<link href="css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Shopping Cart</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Shopping Cart</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="wrapper wrapper-content animated fadeInRight">



            <div class="row">
                <div class="col-md-9">

                    <div class="ibox">
                        <div class="ibox-title">
                            <span class="float-right">(<strong>1</strong>) items</span>
                            <h5>Items in your cart</h5>
                        </div>
                        
                        <!-- loop here -->
                        <?php
                        
                            $col = "*";
                            $tb = "mv_item join mv_sub_product on mv_item.mv_sub_product_id = mv_sub_product.mv_sub_product_id join mv_product on mv_sub_product.mv_product_id = mv_product.mv_product_id";
                            $opt = 1;
                            $item_list = $db->get($col,$tb,$opt);
                            $item = array();
                            foreach($item_list as $key){
                                $item[$key['mv_item_id']] = array('name'=>$key['mv_item_name'],'desc'=>$key['mv_item_desc'],'img'=>$key['mv_item_img'],'amt'=>$key['mv_item_amt'],'unit'=>$key['mv_item_unit'],'cat'=>$key['mv_product_name'],'subcat'=>$key['mv_sub_product_name']);
                            }
                        
                            if(isset($_SESSION['cart'])){
                                $cart = $_SESSION['cart'];
                                foreach($cart['item'] as $key=>$data){
                        ?>
                        <div class="ibox-content" id='box<?php echo $key; ?>'>
                            <div class="table-responsive">
                                <table class="table shoping-cart-table">
									
                                    <tbody>
									  
                                    <tr>
                                        <td width=15%>
                                            <div class="cart-product">
												<a href="img/item/<?php echo $item[$key]['img']; ?>"  data-gallery=""><img src="img/item/<?php echo $item[$key]['img']; ?>" class="img-lg"></a>
                                            </div>
                                        </td>
                                        <td class="desc" width=68%> 
                                            <h3>
                                            <p class="text-info"> <?php echo $item[$key]['name']; ?></p>
                                            </h3>
           <!--                                 <small class="text-muted">Category : <?php echo $item[$key]['cat']; ?></small>-->
											<!--&nbsp;-->
											<!--<small class="text-muted">Sub-Category : <?php echo $item[$key]['subcat']; ?> </small>-->
           <!--                                 <p class="">-->
           <!--                                     <?php echo $item[$key]['unit']; ?> Points per item-->
											<!--	&nbsp;-->
           <!--                                     Inventory : <?php echo $item[$key]['amt']; ?>-->
           <!--                                 </p>-->
                                            <dl class=" m-b-none">
                                                <dt>Description</dt>
                                                <dd><?php echo $item[$key]['desc']; ?></dd>
                                            </dl>

                                            <div class="m-t-sm">
                                                
                                                <a href="javascript:void(0);" class="text-muted btnRemoveItem" data-itemid='<?php echo $key; ?>'><i class="fa fa-trash"></i> Remove item</a>
                                            </div>
                                        </td>

                                        

                                        <td width=17%>
										
											<input class="touchspin form-control itemvar" data-itemid='<?php echo $key; ?>' data-itemunit='<?php echo $item[$key]['unit']; ?>' type="text" value="<?php echo $data; ?>" name="itemvar">
                                            <input type='hidden' id='oldValue<?php echo $key; ?>' value='<?php echo $data; ?>'>
											<br>
                                            <h4>
												<span id='itemUnit<?php echo $key; ?>'><?php echo $data * $item[$key]['unit']; ?></span> Points
                                            </h4>
											
                                        </td>
                                    </tr>
									

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <?php } }else{ ?>
                        <div class="ibox-content">
                            <h2>Your Cart Is Empty</h2>
                        </div>
                        <?php } ?>
                        <!-- end loop -->
                        
                        
                       
                        <div class="ibox-content">

                            <a href="checkout.php" class="btn btn-primary float-right"><i class="fa fa fa-shopping-cart"></i> Checkout</a>
                            <a href="itemgrid.php" class="btn btn-white"><i class="fa fa-arrow-left"></i> Continue shopping</a>

                        </div>
                    </div>

                </div>
                
                <!-- loop here -->
                
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
                                Current Point (Not Include Delivery Fee)
                            </span>
                            <h2 class="font-bold" id='usedUnit'>
                                <?php echo $cart['unit']; ?>
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
			
			
			<!-- Content write here END -->
			<?php require_once('inc/footer.php'); ?>
		</div>
		
		
		
		
		<?php require_once('inc/right_nav.php'); ?>
	</div>
	
	<div class="modal inmodal" id="removePackage" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content animated fadeIn">
				<form role="form" id="form" action="api/cart.php?type=removePackage" method="post" enctype="multipart/form-data" class="wizard-big" action="#">
				    <input type="hidden" name="token" id='token' value="<?php echo $token; ?>" />
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
	
	<div id='loadDiv' style='position: fixed; width: 100%; height: 100%; left: 0; top: 0; background: rgba(51,51,51,0.2); z-index: 9999; display:none;'><i class="fa fa-spin fa-spinner fa-5x text-success" style='position: fixed; left: 50%; top: 50%;'></i></div>
	
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
	
	    <!-- blueimp gallery -->
    <script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
	
	<!-- Page-Level Scripts -->
	<script>
	
	    $('.itemvar').change(function(){
	        $('#loadDiv').show();
		    var thistxt = $(this);
		    var item_qty = thistxt.val();
		    var item_id = thistxt.data('itemid');
		    var item_unit = thistxt.data('itemunit');
		    var token = $('#token').val();
		    var oldvalue = $('#oldValue'+item_id).val();
		    
		    $.post('api/cart.php', { type: 'editItems', item_id: item_id, item_qty: item_qty, token: token }, function(data){
		        data = JSON.parse(data);
		        $('#token').val(data.Token);
		        if(data.Status){
		            //Success Action
		            var newunit = item_qty * item_unit;
		            $('#usedUnit').html(data.Unit);
		            $('#itemUnit'+item_id).html(newunit);
		            $('#oldValue'+item_id).val(item_qty);
		            $('#errorMsg').html('');
		            $('#loadDiv').hide();
		        }else{
		            thistxt.val(oldvalue);
		            //Failed Action
		            $('#errorMsg').html('<span class="animated fadeIn"><i class="fa fa-times"> '+data.Msg+'</i></span>');
		            //data.Msg to get failed msg
		            $('#loadDiv').hide();
		        }
			});
		});
		
		$('.btnRemoveItem').click(function(){
		    $('#loadDiv').show();
		    var thistxt = $(this);
		    var item_id = thistxt.data('itemid');
		    var token = $('#token').val();
		    
		    $.post('api/cart.php', { type: 'removeItems', item_id: item_id, token: token }, function(data){
		        data = JSON.parse(data);
		        $('#token').val(data.Token);
		        if(data.Status){
		            //Success Action
		            $('#usedUnit').html(data.Unit);
		            $('#oldValue'+item_id).remove();
		            $('#box'+item_id).remove();
		            $('#loadDiv').hide();
		        }else{
		            //Failed Action
		            $('#errorMsg').html('<span class="animated fadeIn"><i class="fa fa-times"> Failed to remove item</i></span>');
		            //data.Msg to get failed msg
		            $('#loadDiv').hide();
		        }
			});
		});
	
		$(".touchspin").TouchSpin({
			min: 0,
			max: 200,
			buttondown_class: 'btn btn-link',
			buttonup_class: 'btn btn-link'
			
		});
		
	</script>
	
	
</body>
</html>
