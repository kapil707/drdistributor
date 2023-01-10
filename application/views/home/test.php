<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-messaging.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.8.1/firebase-database.js"></script>

<script>
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey: "AIzaSyA7Q-_wz3aCoMtJy1qQMzjZ48upRQQW4E8",
  authDomain: "fir-demo1-a6592.firebaseapp.com",
  databaseURL: "https://fir-demo1-a6592.firebaseio.com",
  projectId: "fir-demo1-a6592",
  storageBucket: "fir-demo1-a6592.appspot.com",
  messagingSenderId: "655571690509",
  appId: "1:655571690509:web:c61bd46cb903d00c01a144"
};

firebase.initializeApp(firebaseConfig);
/*const fcm = firebase.messaging();
fcm.getToken({
  vapidkey: 'BDIsEm8UnMByHcaVTAP0AoJU6RWXGCvnrT_9FgyU_Mjy-P-NtQLdYqDv-JXzzC1rh0ikJn_xhAQXuWxyWQxant8'
}).then((token)=>{
  console.log('getToken: ',token);
});*/

firebase.database().ref('Riderapp/live_location/user_id457').on('value',(sanpshot)=>{
  getLatitude = sanpshot.child("getLatitude").val();
  getLongitude = sanpshot.child("getLongitude").val();
//alert(getLatitude)
  //initMap();
})
</script>
<div id="map" style="height:500px;width:100%;"></div>
<script>
  var getLatitude;
  var getLongitude;
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var locations = [ 
    ["hii",getLatitude,getLongitude, 1],
   ];
   //alert(getLatitude)
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 18,
      center: new google.maps.LatLng(getLatitude, getLongitude),
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