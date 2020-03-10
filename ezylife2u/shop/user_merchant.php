<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "user_merchant";
	require_once('inc/header.php');
?>
 

<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
 <link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">

<body onload="onload();">
    <div id="wrapper">
        <?php require_once('inc/nav.php'); ?>
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<?php require_once('inc/top_nav.php'); ?>
			<!-- Content write here START -->
			<?php 
			
				$user_state = $db->where("mv_state_id","mv_user_state","mv_user_id",$your_id);
                $user_state = $user_state[0]['mv_state_id'];
			    if($onpage == 2){
			        
			    
			
			 ?>
			
			<div class="row wrapper border-bottom white-bg page-heading">
				<div class="col-lg-10">
					<h2>Merchant</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.html">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Merchant</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			<div class="row wrapper border-bottom gray-bg page-heading">
			    	    <div class="col-lg-12">

                            <br>
                            <input type="text" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Search">
                        </div>
                             
			    	    </div>
			    	    
			<div class="row wrapper border-bottom gray-bg page-heading">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Find Merchant</h5>
								
								
							</div>
							<div class="ibox-content">
							        
							   	<form role="form" id="form_edit"  method="post" enctype="multipart/form-data">

            		            	<div class="form-group">
                                           <label class="font-normal">Category<span class="text-danger"><strong></strong></span></label>
                                            <div>
                                                <select  name="cate" id="cate"   class="chosen-select" id="under_state" tabindex="2" >
                                                    
                                                   
                                                <?php 
									    
        								            $i=1;
        											$tb = 'mv_product';
        											$opt = "mv_product_status = ? AND mv_user_type = ?";
                                                  	$arr = array(1,4);
        											$result = $db->advwhere('*',$tb,$opt,$arr);
    											foreach($result as $state){
    											?>
                                                <option selected value="<?php echo $state['mv_product_id']; ?>"><?php echo $state['mv_product_name']; ?></option>
                                                
                                               <?php $i++; } ?>
                                                </select>
                                            </div>
                                    </div>
                        
                        	
                    		
                    		
                    		 
                    		
                    		<div class="modal-footer">
                    		    
                    	    	<a id="get_order"  class="btn btn-white btn-xs" onclick="get_order();" ><i class="fa fa-search" ></i> Search </a>
                    			<!--<a data-remote="ajax/merchant_findmarket.php?p=12" class="btn btn-white btn-xs " onclick="get_order();">Find</a>-->

                    		</div>
                    		
                            <script type="text/javascript">
                                var category;

                                function onload() { 
                                    
                                    category = document.getElementById("cate");

                                }
                                function get_order(){
                                   
                                    window.open("merchant_map.php?cate=" + category.value,'_blank');
                                }
                            </script>
                    		
                    	</form>
                   
								
							</div>
						</div>
				
					</div>

				</div>    	    
			    	    
			
			<div class="wrapper wrapper-content animated fadeInRight">
	
				<div class="row">
				    
					<?php 
                    
                    
                    $col = "*";
                    $tb = "mv_user JOIN mv_user_state on mv_user.mv_user_id = mv_user_state.mv_user_id";
                    $chkcol = "mv_user_type = ? AND mv_state_id = ? AND mv_user.mv_user_status = ? AND mv_user.mv_user_status != ? ";
                    $arr = array(4,$user_state,1,9);
				    $result = $db->advwhere($col,$tb,$chkcol,$arr);
                    
					foreach($result as $row){
					?>
				    
				    
                    <div class="col-lg-3 filter">
                        <div class="contact-box center-version">
        
                            <div style="  display: block;
                                          background-color: #ffffff;
                                          padding: 20px;
                                          text-align: center;">
                                

                                <div class="lightBoxGallery">
                                     <?php if($row['mv_user_image']!="") 
                                        {  
                                    ?>
                                        	<a href="img/userprofile/<?php echo $row["mv_user_image"]; ?>"  data-gallery=""><img alt="image" class="feed-photo img-thumbnail" src="img/userprofile/<?php echo $row["mv_user_image"]; ?>" style="width:80px;height:80px;"></a>
                        					<!--<img alt="image" class="feed-photo img-thumbnail" src="img/userprofile/<?php echo $row["mv_user_image"]; ?>" style="width:80px;height:80px;">-->
                					<?php 
                                            
                                        }
                    					else{
                					?>
                        					<img alt="image" class="feed-photo img-thumbnail" src="img/userprofile/img.jpg" style="width:80px;height:80px;" />
                					<?php
                					    }
                    				?>
                                    
                                </div>
                           
        
                                
        
        
                                <h3 class="m-b-xs"><strong><?php echo $row["mv_merchant_shopname"];  ?></strong></h3>
        
                                <div class="font-bold"><a href="<?php echo $row["mv_merchant_link"];  ?>">Merchant Link</a></div>
                                <address class="m-t-md">
                                    <!--<strong></strong><br>-->
                                    <?php echo $row["mv_merchant_address"];  ?><br>
                                    <abbr title="Phone">Phone:</abbr> <?php echo $row["mv_user_phnum"];  ?>
                                </address>
                                <br>
                                
                                <?php 
                                    
                                    $open = $row["mv_merchant_start_time"];
                                    $close = $row["mv_merchant_end_time"];
                                    
                                    $open = strtotime($open);
                                    $close = strtotime($close);
                                    
                                    $open = date('H:i', $open); 
                                    $close = date('H:i', $close);
                                    
                                ?>
                                
                                <div class="font-bold">Operation Hour: <?php echo $open;  ?> - <?php echo $close;  ?></div>
                               
                                <div class="font-bold">Off Day     : <?php echo $row["mv_merchant_close_day"];  ?></div>
                            </div>
                            <div class="contact-box-footer">
                                <div class="m-t-xs btn-group">

                                    <!--<a href=""  class="btn btn-xs btn-white"><i class="fa fa-user-plus"></i> More</a>-->
                                     	<a data-remote="ajax/merchant_market.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Maker</a>
                                     		<a data-remote="ajax/merchant_bill.php?p=<?php echo $row['mv_user_id']; ?>" class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Bill</a>
                                </div>
                            </div>
        
                        </div>
                    </div>

                  <?php  } ?>
				    
				    
		

					
				</div>
				
					
				
			</div>
			
			<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content animated fadeIn">
					    
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
			
			
			<?php  
			    }
			    else
			    {
			        echo "YOU ARE NOT USER, U CANNOT LANDING THIS PAGE";
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

	  <!-- google map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAu0cFqXOlYgu93OD1SgI8TNWBaTcErV_8" type="text/javascript"></script>
        
         <script src="js/plugins/chosen/chosen.jquery.js"></script>
	
	<!-- Page-Level Scripts -->
	<script>
	
	
	
	
	$('body').on('click', '[data-toggle="modal"]', function(){
        $($(this).data("target")+' .modal-content').load($(this).data("remote"));
    });  
    
	$(document).ready(function(){

         $("#filter").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".filter").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        
	});

	 $('.chosen-select').chosen({width: "100%"});
		
		
		
	</script>
	
	
</body>
<?php
	
?>
</html>
