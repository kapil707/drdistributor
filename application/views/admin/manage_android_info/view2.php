<div class="row">
	<?php /* <meta http-equiv="refresh" content="30" />*/ ?>
    <div class="col-xs-12" style="margin-bottom:5px;">
		<?php /* ?>
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
		<?php */ ?>
   	</div>
    <div class="col-xs-12">
	<style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 500px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
        <div id="map"></div>
    <script>
setTimeout(function(){
  initMap();
}, 60000);
// Initialize and add the map
function initMap() {
	// The location of Uluru
	var locations = [
		<?php
		$i = 1;
		foreach($result as $row) {
		$row->name = "(". $row->chemist_id.") <br> Date / Time:-".$row->getdate.",".$row->gettime; ?>
		["<?= $row->name; ?>", <?= $row->getlatitude; ?>, <?= $row->getlongitude; ?>, <?= $i; ?>],
		<?php 
		} 
        $latitude  = $row->getlatitude;
        $longitude = $row->getlongitude;
		?>
	];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(<?= $latitude;?>, <?= $longitude;?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    

    for (i = 0; i < locations.length; i++) {
      if(i!=0)
      {  
        const icon = {
                url: "https://drdweb.co.in/img_v31/marker_b.png", // url
                scaledSize: new google.maps.Size(30, 30), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
          };
          marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          icon:icon
        });
      }
      if(i==0)
      {
        const icon2 = {
              url: "https://drdweb.co.in/img_v31/marker_a.png", // url
              scaledSize: new google.maps.Size(30, 30), // scaled size
              origin: new google.maps.Point(0,0), // origin
              anchor: new google.maps.Point(0, 0) // anchor
        };
        marker = new google.maps.Marker({
          position: new google.maps.LatLng(locations[i][1], locations[i][2]),
          map: map,
          icon:icon2
        });
      }
      
      

      

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
setTimeout(function(){
initMap();
}, 60000);
}
    </script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function
    -->
	<?php $mapapikey =  $this->Scheme_Model->get_website_data("mapapikey") ;?>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?=$mapapikey ?>&callback=initMap">
    </script>
    </div>
</div>