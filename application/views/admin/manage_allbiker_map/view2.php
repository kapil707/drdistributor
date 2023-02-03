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
		<form method="get">
			<div class="form-group">
        <div class="col-sm-4">
          <div class="col-sm-6 text-right">
                <label class="control-label" for="form-field-1">
                    Select date
                </label>
            </div>
            <div class="col-sm-6" id="data_5">
              <div class='input-group date input-daterange'>
                <input type='text' class="form-control" value="<?= $vdt; ?>" name="vdt" />
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </div>
          </div>
        </div>
				<div class="col-sm-4">
          <div class="col-sm-6 text-right">
              <label class="control-label" for="form-field-1">
                  Select Users
              </label>
          </div>
          <div class="col-sm-6">
              <select name="altercode" id="altercode" data-placeholder="Select Status" class="chosen-select" >
              <?php foreach($dropdown as $row) { ?>
              <option value="<?php echo $row->altercode; ?>" <?php if($row->altercode==$altercode) { ?> selected <?php } ?>>
              <?php echo $row->name; ?> (<?php echo $row->altercode; ?>)
              </option>
              <?php } ?>
            </select>
          </div>
        </div>
				<div class="col-xs-2">
					<button type="submit" class="btn btn-primary block full-width m-b" name="Submit" value="Submit">Submit</button>
				</div>
				<div class="col-xs-2">
					<button type="submit" class="btn btn-primary block full-width m-b" name="Notification" value="Notification">Notification</button>
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
		if(empty($altercode)){ 
			foreach($dropdown as $row) {
			$row->name = $row->name." - (". $row->altercode.") <br> Date / Time:-".$row->date.",".$row->time; ?>
			["<?= $row->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
				<?php 
				$i++;
			} 
      $latitude = "28.5183163";
      $longitude = "77.279475";?>
      ['DRD Office', <?= $latitude;?>, <?= $longitude;?>, <?= $i; ?>] 
      <?php
		} else {
			foreach($result as $row) {
        if ($i == 1) {
          $row1 = $this->db->query("SELECT * FROM `tbl_master` where altercode='$row->user_altercode' order by id asc")->row();
        }
        $row1->name = $row1->name." - (". $row1->altercode.") <br> Date / Time:-".$row->date.",".$row->time;
        if ($i == 1) { ?>
        ["<?= $row1->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
        <?php } $i++;
        }
        ?>
        ["<?= $row1->name; ?>", <?= $row->latitude; ?>, <?= $row->longitude; ?>, <?= $i; ?>],
        <?php
        $latitude  = $row->latitude;
        $longitude = $row->longitude;
		} ?>
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
	<?php
		if(!empty($altercode)){ ?>
		var flightPlanCoordinates = [
			<?php
			foreach($result as $row) { ?>
        {lat: <?= $row->latitude; ?>, lng: <?= $row->longitude; ?>},
			<?php } ?>
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