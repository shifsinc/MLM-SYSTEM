<?php
    include_once('inc/init.php');
	$PageName = "package";
	require_once('inc/header.php');
	
	$getcate_id = $_REQUEST['p'];

?>


<!-- Toastr style -->
<link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

<body>
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Wholesaler</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php" id="top">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Wholesaler</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<?php 
			
				$user_state = $db->where("mv_state_id","mv_user_state","mv_user_id",$your_id);
                $user_state = $user_state[0]['mv_state_id'];
			?>
			
			
			<!-- layout 我过后再改，暂时这样 -->
			<div class="wrapper wrapper-content">
			    
			    
			    
		    	<div class="row"> 
				    
			    	<div class="col-md-12"> 
			    	
			    	    <div class="row wrapper border-bottom gray-bg page-heading">
			    	    <div class="col-lg-12">
                            <br>
                            <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Search">
                        </div>
                             
			    	    </div>

		
					    <div class="ibox">
							<div class="row ">

								<?php 
                                    
                                    
             
                                    $col = '*';
									$tb = 'mv_user_category JOIN mv_user_state ON mv_user_category.mv_user_id = mv_user_state.mv_user_id JOIN mv_user ON mv_user.mv_user_id = mv_user_state.mv_user_id';
									$chkcol = 'mv_user_category.mv_category_id =? AND mv_user_state.mv_state_id =? AND mv_user.mv_user_status =?';
									$arr = array($getcate_id,$user_state,$user['mv_user_status']);
									$result = $db->advwhere($col,$tb,$chkcol,$arr);
									
									if(count($result)==0){
									    
									     echo '<p> No Wholesaler of this category at your state. Please press back button and choose again.</p>';
									    
									}else{
									    
									  foreach($result as $seller){
									    
				
    									    $seller_data = $db->where('*','mv_user','mv_user_id',$seller['mv_user_id']);
    									    $seller = $seller_data[0];
    									    
    									    
    									    
    									?>
    									
    									
    									
    									<div class="col-md-3 filter">
    										<div class="ibox">
    											<div class="ibox-content product-box">
    												
    												<div class="block-image" >
    													
    													<a href="package.php?p=<?php echo $seller['mv_user_id']; ?>"><img class="" style="width:100%; height:210px;" src="img/userprofile/<?php echo $seller["mv_user_image"]; ?>"></a>
    													
    												</div>
    												<div class="product-desc">
    								
    				
    													<p class="product-name"> <?php echo $seller["mv_merchant_cname"]; ?></p>
    													    <div class="m-t-xs">
    													        <h5 class="text-info">
                                    								Description
                                    							</h5>
                                    							<?php 
                                    							
                                    							    if($seller["mv_merchant_intro"] == NULL){
                                    							        $show_intro = 'No Description';
                                    							    }else{
                                    							        $show_intro = $seller["mv_merchant_intro"];
                                    							    }
                                    							
                                    							?>
                                    							
    													        <p class=""> <?php echo $show_intro; ?></p>
    													    </div>
    												    
    													</div>
    												</div>
    											</div>
    										</div>
    									
    							    	<?php }   
									    
									    
									}
		
									?>
								
								
								
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
	
	<script src="js/plugins/dataTables/datatables.min.js"></script>
	<script src="js/plugins/dataTables/dataTables.bootstrap4.min.js"></script>
	
	
	<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>
	
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
	    
	</script>
	

	
</body>
</html>
