<?php
	include_once('inc/init.php');
	$db = new DB_Functions(); 
	$PageName = "orderlist";
	require_once('inc/header.php');
?>

<link href="css/plugins/dataTables/datatables.min.css" rel="stylesheet">
<link href="css/plugins/blueimp/css/blueimp-gallery.min.css" rel="stylesheet">
<link href="css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
<link href="css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<link href="css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
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
					<h2>Order List</h2>
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="index.php">Home</a>
						</li>
						<li class="breadcrumb-item active">
							<strong>Order</strong>
						</li>
					</ol>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
			
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				

				<br>
				
				<?php
                                
                           
                                    
                    $from = $_REQUEST['from'];
                    $to = $_REQUEST['to'];
                    
                    if($to == '' || $to == NULL){
                        $to = date('Y-m-d H:i:s');
                    }
                    
                    // SELECT * FROM `mv_order` where mv_order_date BETWEEN '2018-12-10' AND '2018-12-16'
                    
                    $from = strtotime($from);
                    $from = date('Y-m-d', $from); 
                    
                    $to = strtotime($to);
                    $to = date('Y-m-d', $to);
                    
                  
                
                ?>
				
				<div class="row">
					<div class="col-md-9 text-center">						
						
					</div>
					<div class="col-md-3 text-center">
						<a data-toggle="modal" class="btn btn-primary btn-lg btn-block" href="#summary"> &nbsp;View Summary</a>
						
					</div>	
									
					
				</div>
				<br>
				
				
				
				<div class="modal inmodal" id="summary" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							<form role="form" id="form" action="soap_func.php?type=additem&tb=user" method="post" enctype="multipart/form-data">
									<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
									
									<h4 class="modal-title">Order Summary</h4>
								</div>
								<div class="modal-body">
								    
    									    <?php 
									        
                                            
								            $col = 'SUM(mv_order_item_qty)';
								            $tb = 'mv_order JOIN mv_order_item ON mv_order.mv_order_id = mv_order_item.mv_order_id ';
                							$opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? ';
                							$arr=array($from,$to,1);
                							$result=$db->advwhere($col,$tb,$opt,$arr);
                							$total_item = $result[0]['SUM(mv_order_item_qty)'];
				
											
											?>
								    
								    
								    
									
									<div class="ibox-content">
                                    	<div class="col-lg-12">
                                    		<div class="contact-box ">
                                			
                                		    	<h2 class="m-b-xs"><strong>Total Item</strong></h2>
                                			
                                
                                		    	<br>
                                		        	<table class="table">
                                		        	    
                                    			    	<thead>
                                    			    	</thead>
                                    			    	
                                    			    	<tbody>
                                    			    	    
                                    			    	    
                                        					<tr>
                                            					<td>Total Item Quantity</td>
                                            					<td><?php echo $total_item; ?></td>
                                            				</tr>

                                            			
                                        						<tr>
                                        							<td></td>
                                        							<td></td>
                                        						</tr>
                                						</tbody>
                                						
                                					</table>	
                                					
                                					<div class="table-responsive m-t">
                                                        <table class="table invoice-table">
                                                            <thead>
                                								<tr>
                                									<th>Item List</th>
                                									<th>Quantity</th>
                                						
                                								</tr>
                                							</thead>
                                                            <tbody>
                                								
                                								
                                								<?php 
                                								    
                                								    
                                								    
                                								    $i=1;

                                									
                                									$col = "SUM(mv_order_item_qty),mv_item_name";
                                            	                    $tb = 'mv_order_item JOIN mv_order ON mv_order_item.mv_order_id=mv_order.mv_order_id JOIN mv_item ON mv_item.mv_item_id = mv_order_item.mv_item_id ';
                                            	                    
                                            	                    $opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? GROUP BY mv_item_name ORDER BY mv_item.mv_item_name ASC';
                                        							$arr=array($from,$to,1);
                                        							$result=$db->advwhere($col,$tb,$opt,$arr);

                                            	                    
                                									foreach($result as $row){
                                								
                                								?>
                                								
                                								
                                								<tr>
                                								    
                                								    <?php 
                                								    
                                    								    
                                    								    $tb = 'mv_order_item JOIN mv_item ON mv_order_item.mv_item_id = mv_item.mv_item_id';
                                                                        $result = $db->where('mv_order_item_desc',$tb,'mv_item_name',$row["mv_item_name"]);
                                                                        $desc = $result[0];
                                								        
                                								    
                                								    ?>
                                								    
                                
                                								    
                                									<td><div><strong><?php echo $row["mv_item_name"]; ?></strong></div>

                                									
                                									
                                									
                                									<small><?php echo $desc["mv_order_item_desc"]; ?></small></td>
                                									<td><?php echo $row["SUM(mv_order_item_qty)"]; ?></td>
                                									

                                								</tr>
                                								
                                								<?php

                                            					} 
                                            					
                                            					?>
	
                                							</tbody>
                                						</table>
                                					</div>
                                					
                                					
                                					
                                					
                                					
                                				
                                					
                                				</div>
                                			</div>
                                		</div>
									
								    
									
	
								</div>
								<div class="modal-footer">
								    <a href="admin_print_summary.php?p=<?php echo $from; ?>&&q=<?php echo $to; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Print </a>
									<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>


								</div>
								
							</form>
						</div>
					</div>
				</div>

				
				<div class="row">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Order Ranged <?php   echo '  from: '.$from; echo ' to: '.$to;  ?></h5>
								
								
							</div>
							<div class="ibox-content">
							        
                                    
                                
                                
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" id="datatable">
									     

										<thead>
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>User name</th>
											<th>State</th>
											<th>Item name</th>
											
											<th>Category</th>
											<th>Suc-category</th>
											<th>Description</th>
											<th>Price</th>
											<th>Qty</th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
                                            
								            $i=1;
								            $tb = 'mv_order JOIN mv_order_item ON mv_order.mv_order_id = mv_order_item.mv_order_id JOIN mv_item ON mv_order_item.mv_item_id = mv_item.mv_item_id';
                							$opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? ';
                							$arr=array($from,$to,1);
                							$result=$db->advwhere('*',$tb,$opt,$arr);
				
											foreach($result as $row){
											?>
											
										<tr>
										    
										    <?php 
										    
										        $subcate = $db->where('mv_sub_product_name, mv_product_id','mv_sub_product','mv_sub_product_id',$row['mv_sub_product_id']);
											    $sub_cate_name = $subcate[0]['mv_sub_product_name'];
											    
											    $cate1 = $db->where('mv_product_name','mv_product','mv_product_id',$subcate[0]['mv_product_id']);
											    $cate_name = $cate1[0]['mv_product_name'];
										    
										        $username = $db->where('mv_user_fullname','mv_user','mv_user_id',$row['mv_user_id']);
											    $username = $username[0]['mv_user_fullname'];
										    
										    ?>
										    
										    
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_order_date"]; ?></td>
											<td><?php echo $username; ?></td>
											<td><?php echo $row["mv_order_state"]; ?></td>
											<td><?php echo $row["mv_item_name"]; ?></td>
											
											<td><?php echo $cate_name; ?></td>
											<td><?php echo $sub_cate_name; ?></td>
											<td><?php echo $row["mv_order_item_desc"]; ?></td>
											<td><?php echo $row["mv_order_item_unit"]; ?></td>
                                            <td><?php echo $row["mv_order_item_qty"]; ?></td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
										<tfoot>
											<tr>
												<th>No</th>
											<th>Date</th>
											<th>User name</th>
											<th>State</th>
											<th>Item name</th>
											
											<th>Category</th>
											<th>Suc-category</th>
											<th>Description</th>
											<th>Price</th>
											<th>Qty</th>
											</tr>
										</tfoot>
									</table>
								</div>
								
							</div>
						</div>
						
							<div class="ibox ">
		                					<div class="ibox-title">
		                						<h5>Order Location Ranged <?php   echo '  from: '.$from; echo ' to: '.$to;  ?></h5>
		                						
		                						
		                					</div>
		                				<div class="ibox-content">
		                						
		                					<div class="wrapper wrapper-content  animated fadeInRight">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div id="map_canvas" style="height:600px;">
                
		                		        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
							</div>
							</div>
						
					</div>
					
					
					
				</div>
				
				<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog"  aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content animated fadeIn">
							
						</div>
					</div>
				</div>
				
				 <div class="modal inmodal" id="completed" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content animated bounceInRight">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                    <i class="fa fa-laptop modal-icon"></i>
                                    <h4 class="modal-title">Completed Order</h4>
                                    
                                </div>
                                <div class="modal-body text-center">
                                    <h2><strong>You are <span class="text-danger">Completed This Order </span>. You are not allow to change this order status</strong></h2>
                                            
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                    
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
    	
    	 <!-- google map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAu0cFqXOlYgu93OD1SgI8TNWBaTcErV_8" type="text/javascript"></script>


		<!-- Page-Level Scripts -->
		<script>

		
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
    		
    		//google map configuration
  var delay = 100;
  var retry = 0;
  var infowindow = new google.maps.InfoWindow();
  var latlng = new google.maps.LatLng(1.362048, 103.827762);
  var mapOptions = {
    zoom: 12,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var geocoder = new google.maps.Geocoder(); 
  var map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
  var bounds = new google.maps.LatLngBounds();
  var no = 0;
  function geocodeAddress(address, next) {
    geocoder.geocode({address:address}, function (results,status)
      { 
         if (status == google.maps.GeocoderStatus.OK) {
          var p = results[0].geometry.location;
          var lat=p.lat();
          var lng=p.lng();
		  no++;
          createMarker(address,lat,lng);
          var index = locations.indexOf(address);
          if (index > -1) {
            locations.splice(index, 1);
          }
        }
        else {
           if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            nextAddress--;
            delay++;
          } else {
                }   
        }
        next();
      }
    );
  }
 function createMarker(add,lat,lng) {
   var contentString = "<a href='https://www.google.com/maps/place/"+add+"' target='_blank'>"+add+"</a>";
   var marker = new google.maps.Marker({
     position: new google.maps.LatLng(lat,lng),
     map: map,
           });

  google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent(contentString); 
     infowindow.open(map,marker);
   });

   bounds.extend(marker.position);

 }
 </script>
 <?php
 $opt= 'mv_order_date >= ? AND mv_order_date <= ? AND mv_order_status <= ? ';
 $arr=array($from,$to,1);
 $getaddr = $db->advwhere('*','mv_order',$opt,$arr);
 
 ?>
 <script>
  var locations = [<?php foreach($getaddr as $row){
      
if($row['mv_order_postcode'] !='' && $row['mv_order_postcode'] !=null){
 $postsymbol=',';
 }
 else{
 $postsymbol='';
 }
 
 if($row['mv_order_state'] !='' && $row['mv_order_state'] !=null){
 $statesymbol=',';
 }
 else{
 $statesymbol='';
 }
 
 if($row['mv_order_city'] !='' && $row['mv_order_city'] !=null){
 $citysymbol='&nbsp';
 }
 else{
 $citysymbol='';
 }
 
//  $userfullname = $db->where('co_user_fullname','mv_user',"mv_user_id",$row['mv_user_id']);
//  $userfullname = $userfullname[0]['co_user_fullname'];
 
 
  echo "'".$row['mv_order_addr']."$postsymbol".$row['mv_order_postcode']."$citysymbol".$row['mv_order_city']."$statesymbol".$row['mv_order_state']."',";
  } ?>];
  var nextAddress = 0;
  function theNext() {
    if (nextAddress < locations.length) {
      setTimeout('geocodeAddress("'+locations[nextAddress]+'",theNext)', delay);
      nextAddress++;
    } else {
      map.fitBounds(bounds);
      console.log(locations);
      nextAddress = 0;
      if(retry < 3){
          retry++;
          theNext();
      }
    }
  }
  theNext();



			
		</script>
		
		
	</body>
</html>
