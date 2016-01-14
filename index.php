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
                <input type="text" id="address-or-city" class="position" placeholder="Ange adress eller stad">
                <input type="button" id="get-location" class="position" value="Hitta min position">
            </div>
            <button id="submit" class="ion-checkmark-round"></button>
        </form>
    </div>
<?php if (!isset($_COOKIE['geolocation'])): ?>
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
          styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#6195a0"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"lightness":"0"},{"saturation":"0"},{"color":"#f5f5f2"},{"gamma":"1"}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"lightness":"-3"},{"gamma":"1.00"}]},{"featureType":"landscape.natural.terrain","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#bae5ce"},{"visibility":"on"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#fac9a9"},{"visibility":"simplified"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#787878"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"transit.station.airport","elementType":"labels.icon","stylers":[{"hue":"#0a00ff"},{"saturation":"-77"},{"gamma":"0.57"},{"lightness":"0"}]},{"featureType":"transit.station.rail","elementType":"labels.text.fill","stylers":[{"color":"#43321e"}]},{"featureType":"transit.station.rail","elementType":"labels.icon","stylers":[{"hue":"#ff6c00"},{"lightness":"4"},{"gamma":"0.75"},{"saturation":"-68"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#eaf6f8"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#c7eced"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"lightness":"-49"},{"saturation":"-53"},{"gamma":"0.79"}]}],
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
      
      var getLocation = document.getElementById('get-location');
      var addressOrCity = document.getElementById('address-or-city');
      var send = document.getElementById('submit');
      getLocation.onmouseover = function() {
        document.getElementById('address-or-city').style.opacity = '0.3';
        if (addressOrCity !== document.activeElement) {
            send.style.opacity = '0.3';
            getLocation.style.borderRight = '1px solid #C0C0C0';
        }    
      }
      getLocation.onmouseout = function() {
        document.getElementById('address-or-city').style.opacity = '1';
        if (addressOrCity !== document.activeElement) {
            send.style.opacity = '1';
            getLocation.style.borderRight = 'none';
        }    
      }
      addressOrCity.onclick = function() {
        if (addressOrCity === document.activeElement) {
            getLocation.onmouseover = function() {
                getLocation.style.opacity = '1';
            }
            getLocation.onmouseout = function() {
                getLocation.style.opacity = '0.3';
            }
            addressOrCity.onfocusout = function() {
                getLocation.style.opacity = '1';
            }
        }
      }
      getLocation.addEventListener('click', function() {
            if (navigator.geolocation) {
                getLocation.value = 'Söker..';
                navigator.geolocation.getCurrentPosition(function(position) {
                    getLocation.value = 'Position hittad';
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var baseUrl = 'http://46.101.90.3';
                    
                    function loadContent(e, lat, lng) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function() {
                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                var companies = JSON.parse(xhttp.responseText);
                                initialize(lat, lng, companies);
                                function isEven(n) {
                                    return n % 2 == 0;
                                }

                                for (var i = 0; i <= companies.length-1; i++) {
                                    if (isEven(i))
                                        $(e).append('<div class="company company-even"><h3 class="company-name">' + companies[i].Bolagsnamn + '</h3><p class="company-address">' + companies[i].Adress + '</p><p class="company-postalcode">' + companies[i].Postnr.substring(0,3) + ' ' + companies[i].Postnr.substring(3,5) + ' ' + companies[i].Postort +'</p></div>');
                                    else
                                        $(e).append('<div class="company company-odd"><h3 class="company-name">' + companies[i].Bolagsnamn + '</h3><p class="company-address">' + companies[i].Adress + '</p><p class="company-postalcode">' + companies[i].Postnr.substring(0,3) + ' ' + companies[i].Postnr.substring(3,5) + ' ' + companies[i].Postort +'</p></div>');
                                };
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