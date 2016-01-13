<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div id="start">
        <header>
            <div id="logo">My Chair</div>
            <ul id="menu">
                <li>Snabbaste tiden</li>
                <li>Media</li>
                <li>Anslut mitt företag</li>
                <li>Kontakt</li>
            </ul>
        </header>
        <form id="geolocation">
            <div id="position-area">
                <input type="text" class="position" placeholder="Ange adress eller stad">
                <input type="button" class="position" value="Hitta min position">
            </div>
            <button id="submit" class="ion-checkmark-round"></button>
        </form>
    </div>
<?php if (!isset($_COOKIE['geolocation'])): ?>
<button id="click">Hitta min position</button>
<?php else: ?>
    <div id="map"></div>
<?php endif; ?>

    <div id="map"></div>
    <div id="company-list"></div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
    <script>
      function initialize(lat, lng, companies) {
        var mapCanvas = document.getElementById('map');
        var mapOptions = {
          center: new google.maps.LatLng(lat, lng),
          zoom: 12,
          scrollwheel: false,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions);

        var infowindow = new google.maps.InfoWindow();

        for (i = 0; i < companies.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(companies[i].lat, companies[i].lng),
            map: map
          });
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(companies[i].Bolagsnamn);
              infowindow.open(map, marker);
            }
          })(marker, i));
      }

        // console.log(companies.length);
      }
      
      document.getElementById('click').addEventListener('click', function() {
            if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                // var baseUrl = 'http://46.101.90.3/mobile_api';
                var baseUrl = 'http://localhost:8888/metajm';
                function loadContent(e, lat, lng) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (xhttp.readyState == 4 && xhttp.status == 200) {
                            var companies = JSON.parse(xhttp.responseText);
                            // var html = '';
                            initialize(lat, lng, companies);
                            for (var i = 0; i <= companies.length-1; i++) {
                                // html += '<div class="company">' + companies[i].Bolagsnamn + '</div>';
                                $(e).append('<div class="company">' + companies[i].Bolagsnamn + '</div>');
                            };
                            // document.getElementById(e).innerHTML = html;
                            // console.log(companies);
                        }
                    }
                    xhttp.open('POST', baseUrl + '/mobile_api/post/companies.php', true);
                    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                    xhttp.send('lat=' + lat + '&lng=' + lng);
                }
                loadContent($('#company-list'), pos.lat, pos.lng);
                // console.log(pos);
                // console.log(pos.lat);
                // initialize(pos.lat, pos.lng);
                $('html, body').animate({
                    scrollTop: $('#map').offset().top
                }, 2000);
            })
        }
        });
        // $(document).ready(function (){
        //     $('#click').click(function (){
        //         $('html, body').animate({
        //             scrollTop: $('#test').offset().top
        //         }, 2000);
        //     });
        // });
    </script>	
</body>
</html>