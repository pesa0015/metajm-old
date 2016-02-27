var start = document.getElementById('start');
var getLocation = document.getElementById('get-location');
var addressOrCity = document.getElementById('address-or-city');
var send = document.getElementById('submit');
var gMap = document.getElementById('map');
var companyList = document.getElementById('company-list');
var noPosition = document.getElementById('no-position');
var selectedCompany = document.getElementById('selected-company');
var address = document.getElementById('address');
var lat = document.getElementById('lat');
var lng = document.getElementById('lng');
// var baseUrl = 'http://46.101.90.3';
var baseUrl = 'http://localhost:8888/metajm.v2';

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
}

function getCityName(latitude, longitude) {
  var geocoder = new google.maps.Geocoder;
  var coords = {lat: latitude,lng: longitude};

  if (geocoder) {
    geocoder.geocode({ 'location': coords }, function (results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        address.value = results[1].formatted_address;
        lat.value = latitude;
        lng.value = longitude;
      }
      else {
        console.log("Geocoding failed: " + status);
      }
    });
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
      getCityName(pos.lat, pos.lng);
    });
  }
});

var googlePlaces = $('script').filter(function () {
    return ($(this).attr('src') == 'https://maps.google.com/maps/api/js?libraries=places');
}).length;

if (googlePlaces === 1) {
  $(address).locationpicker({
    location: {latitude: 0, longitude: 0},
    inputBinding: {
          latitudeInput: $('#lat'),
          longitudeInput: $('#lng'),
          locationNameInput: $(address)
      },
      enableAutocomplete: true
  });
}

send.addEventListener('click', function() {
  event.preventDefault();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      var companies = JSON.parse(xhttp.responseText);
      gMap.style.display = 'block';
      companyList.style.display = 'block';
      initialize(lat.value, lng.value, companies);
      function isEven(n) {
        if (n % 2 == 0)
          return 'event';
        else
          return 'odd';
      }

      for (var i = 0; i <= companies.length-1; i++) {
        $(companyList).append('<div class="company company-' + isEven(i) + '"><h3 class="company-name">' + companies[i].Bolagsnamn + '</h3><p class="company-address">' + companies[i].Adress + '</p><p class="company-postalcode">' + companies[i].Postnr.substring(0,3) + ' ' + companies[i].Postnr.substring(3,5) + ' ' + companies[i].Postort +'</p></div>');
      }
    $('html, body').animate({
      scrollTop: $('#map').offset().top
    }, 2000);
    }
  }
  xhttp.open('POST', baseUrl + '/mobile_api/post/companies.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('lat=' + lat.value + '&lng=' + lng.value);
});

var x = document.getElementsByClassName('services');
function renderStyle(event, padding, color) {
  event.target.style.padding = padding
  event.target.style.color = color;
}

// for (var i = 0; i <= x.length-1; i++) {
//   x[i].addEventListener('mouseover', function(event) {
//     event.target.innerHTML = event.target.htmlFor;
//     if (!event.target.previousSibling.checked)
//       renderStyle(event, '20px 17px 20px 17px', '#FFFFFF');
//   });
//   x[i].addEventListener('mouseout', function(event) {
//     if (!event.target.previousSibling.checked) {
//       event.target.innerHTML = '';
//       renderStyle(event, '30px', '');
//     }
//     else
//       renderStyle(event, '20px 17px 20px 17px', '#FFFFFF');
//   });
//   x[i].addEventListener('click', function(event) {
//     if (!event.target.previousSibling.checked) {
//       event.target.innerHTML = event.target.htmlFor;
//       renderStyle(event, '20px 17px 20px 17px', '#FFFFFF');
//     }
//     else {
//       event.target.innerHTML = '';
//       renderStyle(event, '30px', '');
//     }
//   });
// }

var body = document.getElementsByTagName('body')[0];

// body.addEventListener('click', function() {
//     calendar.on('child_added', function(childSnapshot, prevChildKey) {
//         console.log(childSnapshot.key());
//     });
// });
      
companyList.addEventListener('click', function() {
  start.style.backgroundImage = 'url(img/2.jpg)';
  $('html, body').animate({scrollTop: $('#selected-company').offset().top}, 1500);
});