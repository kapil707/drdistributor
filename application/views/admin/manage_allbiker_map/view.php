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
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
       }
    </style>
		<form method="get">
			<div class="form-group">
				<div class="col-xs-2">
					<input type="text" class="form-control" placeholder="altercode" required name="altercode" value="<?= $_GET['altercode']; ?>">
				</div>
				<div class="col-xs-2">
					<div class="input-group clockpicker" data-autoclose="true">
						<input type="text" class="form-control" placeholder="time1" required name="time1" value="<?= $_GET['time1']; ?>">
						<span class="input-group-addon">
							<span class="fa fa-clock-o"></span>
						</span>
					</div>
				</div>
				<div class="col-xs-2">
					<div class="input-group clockpicker" data-autoclose="true">
						<input type="text" class="form-control" placeholder="time2" required name="time2" value="<?= $_GET['time2']; ?>">
						<span class="input-group-addon">
							<span class="fa fa-clock-o"></span>
						</span>
					</div>
				</div>
				<div class="col-xs-2">
					 <div class="form-group" id="data_1">
						<div class="input-group date">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input type="text" class="form-control" placeholder="date" required name="date" value="<?= $_GET['date']; ?>">
						</div>
					</div>
				</div>
				<div class="col-xs-2">
					<button type="submit" class="btn btn-primary block full-width m-b" name="Submit" value="Submit">Submit</button>
				</div>
			</div>
		</form>
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
   if($_GET["altercode"]==""){
		$query = $this->db->query("SELECT * FROM `tbl_master` WHERE `longitude`!=''")->result();
   }
   else { 
		$altercode  = $_GET["altercode"];
		$time1      = $_GET["time1"];
		$time2      = $_GET["time2"];
		$date 	    = $_GET["date"];
		$vdt = DateTime::createFromFormat("d-M-yy" , $date);
		$date = $vdt->format('Y-m-d');
		$query = $this->db->query("SELECT * FROM `tbl_master` WHERE `altercode`='$altercode'")->row();
		$user_id = $query->id;
		$query = $this->db->query("SELECT * FROM `tbl_deliver_info` WHERE `user_id`='$user_id' and time>='$time1' and time<='$time2' and date='$date'")->result();
   }
   foreach($query as $row) { 
	if($_GET["altercode"]!=""){
		$row->name = $row->time;
	}
	else{
		$row->name = $row->name." - (". $row->altercode.") <br> Time:-".$row->time.",".$row->date;
	}
	?>
		["<?= $row->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
   <?php 
   $i++;
   } 
   $latitude = "28.5183163";
   $longitude = "77.279475";
   
   if($_GET["altercode"]==""){
   ?>
		['DRD Office', <?= $latitude;?>, <?= $longitude;?>, <?= $i; ?>]
   <?php }else {  
	   $latitude = $row->latitude;
	   $longitude = $row->longitude;?>
		["<?= $row->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
   <?php } ?>
    ];

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 12,
      center: new google.maps.LatLng(<?= $latitude;?>, <?= $longitude;?>),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {  
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map
      });

      google.maps.event.addListener(marker, 'click', (function(marker, i) {
        return function() {
          infowindow.setContent(locations[i][0]);
          infowindow.open(map, marker);
        }
      })(marker, i));
    }
	<?php
		if($_GET["altercode"]!=""){ ?>
	var flightPlanCoordinates = [
	<?php
			$altercode  = $_GET["altercode"];
			$time1      = $_GET["time1"];
			$time2      = $_GET["time2"];
			$date 	    = $_GET["date"];
			$query = $this->db->query("SELECT * FROM `tbl_master` WHERE `altercode`='$altercode'")->row();
			$user_id = $query->id;
			$query = $this->db->query("SELECT * FROM `tbl_deliver_info` WHERE `user_id`='$user_id' and time>='$time1' and time<='$time2' and date='$date'")->result();
	   foreach($query as $row) { ?>
          {lat: <?= $row->latitude; ?>, lng: <?= $row->longitude; ?>},
	   <?php }?>
        ];
        var flightPath = new google.maps.Polyline({
          path: flightPlanCoordinates,
          geodesic: true,
          strokeColor: '#FF0000',
          strokeOpacity: 1.0,
          strokeWeight: 2
        });

        flightPath.setMap(map);
		<?php } ?>
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