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
			    if($onpage == 2){
	
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
                                

                    $cate = $_REQUEST['cate'];
                    $user_cate1 = $db->where('*','mv_product','mv_product_id',$cate);
                    $user_cate = $db->where('*','mv_user_product','mv_product_id',$cate);
                ?>
				
				

				
				

				
				<div class="row">
					<div class="col-lg-12">
					    
							<div class="ibox ">
            					<div class="ibox-title">
            						<h5>Merchant Category:  <?php echo $user_cate1[0]['mv_product_name']; ?></h5>

            						
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
    	
    	 <!-- google map -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAu0cFqXOlYgu93OD1SgI8TNWBaTcErV_8" type="text/javascript"></script>


		<!-- Page-Level Scripts -->
		<script>

    		
    	 //google map configuration
    	 var locations = [<?php 
      
 foreach($user_cate as $row){
    $col = 'mv_user_id = ? AND mv_user_type = ? AND mv_user_status =?';
    $opt = array($row['mv_user_id'],4,1);
    $user1 = $db->advwhere('*','mv_user',$col,$opt);
    $shopname =$user1[0]['mv_merchant_shopname'];


 
 
  echo "'".$user1[0]['mv_merchant_address'].',&nbsp'.$shopname."',";
   } ?>];
  var shopname = [<?php 
      


 
  echo "'".$user1[0]['mv_merchant_shopname']."',";
   ?>];
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
