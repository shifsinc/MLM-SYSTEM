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
<body onload="onload();">
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
				
				
				

				
				<div class="row">
					<div class="col-lg-12">
						
						<div class="ibox ">
							<div class="ibox-title">
								<h5>Order List</h5>
								
								
							</div>
							<div class="ibox-content">
							        
							    <div class="form-group" id="data_5">
                                    <label class="font-normal">Range select</label>
                                    <form role="form" id="form_get_order" method="post">
                                        
                                    <div class="input-daterange input-group" id="datepicker">
                                        
                                        <input type="text" class="form-control-sm form-control" name="min" id="min" value="" />
                                        <span class="input-group-addon">to</span>
                                        <input type="text" class="form-control-sm form-control" name="max" id="max" value="" />
                                        &nbsp;
                                        
                                        
                                        <a id="get_order"  class="btn btn-white btn-xs" onclick="get_order();" ><i class="fa fa-search" ></i> Search </a>
                                        
                                    </div>
                                    </form>  
                                </div> 
							      
                                <script type="text/javascript">
                                    var from;
                                    var to;
                                    function onload() { 
                                        
                                        from = document.getElementById("min");
                                        to = document.getElementById("max");
                                    }
                                    function get_order(){
                                       
                                        window.open("ranged_order.php?from=" + from.value + "&to=" + to.value,'_blank');
                                    }
                                </script>


                                        
        
                                
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" id="datatable">
									     

										<thead>
										<tr>
											<th>No</th>
											<th>Order user</th>
											<th>State</th>
											<th>Package</th>
											<th>Wholesaler</th>
											<th>Payment Price</th>
											<th>Date</th>
											<th>Pay Method</th>
											<th>Status</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									    <?php 
									        
   
								            $i=1;
								// 			$tb = 'mv_order JOIN mv_user ON mv_order.mv_user_id=mv_user.mv_user_id JOIN mv_package ON mv_package.mv_package_id=mv_order.mv_package_id';
								// 			$result = $db->get('*',$tb,1);
											
											$col='*';
                                            $tb='mv_order JOIN mv_user ON mv_order.mv_user_id=mv_user.mv_user_id JOIN mv_package ON mv_package.mv_package_id=mv_order.mv_package_id';
                                            $opt='mv_order.mv_order_status != ?';
                                            $arr=array(9);
                                            $result=$db->advwhere($col,$tb,$opt,$arr);
											
											foreach($result as $row){
											    
											    $wholesaler_id = $row["mv_user_id"];
											    $wholesaler = $db->where('*','mv_user','mv_user_id',$wholesaler_id);
											    $wholesaler_cname = $wholesaler[0]['mv_merchant_cname'];
											    
											?>
											
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["mv_user_fullname"]; ?></td>
											<td><?php echo $row["mv_order_state"]; ?></td>
											<td><?php echo $row["mv_package_name"]; ?></td>
											<td><?php echo $wholesaler_cname; ?></td>
												<?php
    						    
                    						    $package = $row["mv_order_type"];
                    						    if($package == 1)
                    						    {
                    						        $showpacakge = "Self Select";
                    						        $color = " text-success";
                    						        $random_btn = "";
                    						    }else if($package == 2)
                    						    {
                    						        $showpacakge = "Food Bank";
                    						        $color = " text-warning";
                    						        $random_btn = "";
                    						    }else if($package == 3)
                    						    {
                    						        $showpacakge = "Random";
                    						        $color = " text-danger";
                    						        $random_btn = '<a href="itemgrid.php" value="'.$row["mv_order_id"].'" class="btn btn-white btn-xs" role="button">Link Button</a>';
                    						    }
                    						
                    						?>
											<!--<td class="<?php echo $color; ?>"><?php echo $showpacakge; ?></td>-->
								        	<td><?php echo $row["mv_order_price"]; ?> <!--V-Points--></td>	

											
											<td><?php echo $row["mv_order_date"]; ?></td>
											
											<?php
    						    
                    						    $status = $row["mv_order_status"];
                    						    if($status == 0)
                    						    {
                    						        $show = "Pending";
                    						        $color = " text-danger";
                    						        $link = "myModal";
                    						        $remote= 'data-remote="ajax/order_edit.php?p='.$row['mv_order_id'].'"';
                    						        $hidden = "";  //cancel button
                    						        $hiddenaction = ""; // action button
                    						    }else if($status == 1)
                    						    {
                    						        $show = "Approved";
                    						        $color = " text-warning";
                    						        $link = "myModal";
                    						        $remote= 'data-remote="ajax/order_edit.php?p='.$row['mv_order_id'].'"';
                    						        $hidden = "";
                    						        $hiddenaction = "";
                    						    }else if($status == 2)
                    						    {
                    						        $show = "Delivered";
                    						        $color = " text-info";
                    						        $link = "myModal";
                    						        $remote= 'data-remote="ajax/order_edit.php?p='.$row['mv_order_id'].'"';
                    						        $hidden = "hidden";
                    						        $hiddenaction = "";
                    						        
                    						    }else if($status == 3)
                    						    {
                    						        $show = "Cancelled";
                    						        $color = " text-dark";
                    						        $hidden = "hidden";
                    						        $hiddenaction = "hidden";
                    						        $remote = '';
                    						    }
                    						    else if($status == 4)
                    						    {
                    						        $show = "Complete";
                    						        $color = " text-success";
                    						        $link = "completed";
                    						        $hidden = "hidden";
                    						        $hiddenaction = "";
                    						        $remote = '';
                    						    }
                    						    
                    						    
                    						    $pay_type = $row["mv_order_pay_type"];
                    						    if($pay_type == 2){
                    						        
                    						        $show_paytype = 'Card';
                    						        $show_paytype_color = 'text-warning';
                    						        
                    						    }else{
                    						        $show_paytype = 'Points';
                    						        $show_paytype_color = 'text-info';
                    						    }
                    						
                    						?>
											
											<td class="<?php echo $show_paytype_color; ?>"><?php echo $show_paytype; ?></td>
											<td class="<?php echo $color; ?>"><?php echo $show; ?></td>
											<td class="text-center">
											    <div class="btn-group">
												<a data-remote="ajax/order_info.php?p=<?php echo $row['mv_order_id']; ?>&q=<?php echo $onpage ?>" class="btn btn-white btn-xs" data-toggle="modal" data-target="#myModal">View More</a>
												<a <?php echo $hiddenaction; ?> <?php echo $remote; ?> class="btn btn-white btn-xs" data-toggle="modal" data-target="#<?php echo $link; ?>">Action</a>
											
												<a data-remote="ajax/order_cancel.php?p=<?php echo $row['mv_order_id']; ?>" <?php echo $hidden; ?> class="btn btn-white btn-xs " data-toggle="modal" data-target="#myModal">Cancel</a>
												
											    </div>
											</td>
										</tr>
										
										<?php $i++; } ?>
									</tbody>
										<tfoot>
											<tr>
												<th>No</th>
    											<th>Order user</th>
    											<th>State</th>
    											<th>Package</th>
    											<th>Wholesaler</th>
    											<th>Payment Price</th>
    											<th>Date</th>
    											<th>Pay Method</th>
    											<th>Status</th>
    											<th></th>
											</tr>
										</tfoot>
									</table>
								</div>
								
							</div>
						</div>
						
							<!--div class="ibox ">
		                					<div class="ibox-title">
		                						<h5>Order Location</h5>
		                						
		                						
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
							</div-->
						
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

        <!-- Chosen -->
        <script src="js/plugins/chosen/chosen.jquery.js"></script>	
        
		<!-- blueimp gallery -->
		<script src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
		
		<!-- Jquery Validate -->
		<script src="js/plugins/validate/jquery.validate.min.js"></script>
		
	    <!-- Date range use moment.js same as full calendar plugin -->
        <script src="js/plugins/fullcalendar/moment.min.js"></script>
        
        <!-- Data picker -->
        <script src="js/plugins/datapicker/bootstrap-datepicker.js"></script>
        
         <!-- google map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAu0cFqXOlYgu93OD1SgI8TNWBaTcErV_8" type="text/javascript"></script>

		
		<!-- Page-Level Scripts -->
		<script>
		     $('.chosen-select').chosen({width: "100%"});
		
				$(document).ready(function(){
    	    	$('.dataTables-example').DataTable({
    	    	    "order": [[ 6, "desc" ]],
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
		
		
        	$('body').on('click', '[data-toggle="modal"]', function(){
                $($(this).data("target")+' .modal-content').load($(this).data("remote"));
            });    
		

            
            $('#data_5 .input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true
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
             $getaddr = $db->get('*','mv_order',1);
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
