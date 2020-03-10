<?php
include_once('../connection/PDO_db_function.php');
	$db = new DB_Functions(); 
	
	$id = $_REQUEST['p'];
    //echo 'ID:'.$id;
    $state = $db->where('*','mv_user_state','mv_state_id',$id);
    
 
 
    
  
?>
<form role="form" id="form" method="post" enctype="multipart/form-data">
							 
                <div class="modal-header">
                    
                    <div class="m-b-md">
                       	<h5>Merchant Location at <?php echo $id; ?>  </h5>
                
                    </div>
                </div>
                <div class="modal-body text-center">
                    
                   <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox ">
                                        <div id="map_canvas" style="height:600px;">
                
		                		        </div>
                                    </div>
                                </div>
                            </div>
                </div>
                <div class="modal-footer">
                    
                </div>
	</form>
	 
	<script>
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
 
?>
 <script>
  var locations = [<?php 
      
 foreach($state as $row){
    $col = 'mv_user_id = ? AND mv_user_type = ?';
    $opt = array($row['mv_user_id'],4);
    $user1 = $db->advwhere('*','mv_user',$col,$opt);
 

 
 
  echo "'".$user1[0]['mv_merchant_address']."',";
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