 function initMap() { 

          var myLatLng = {lat:24.280201, lng:89.920603};

          var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: myLatLng,
            scrollwheel: false,
          });

          var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            icon: "img/logo.png",
            
           // title: ''
          });
          
          var infowindow = new google.maps.InfoWindow({
            content: "Your Company Name"
         });
         google.maps.event.addListener(marker, 'mouseover', function () {
         infowindow.open(map, marker);
         });
         infowindow.open(map, marker);
         }