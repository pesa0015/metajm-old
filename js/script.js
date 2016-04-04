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
var xhttp = new XMLHttpRequest();
var baseUrl = 'http://46.101.90.3';

function firstToUpperCase( str ) {
    return str.substr(0, 1).toUpperCase() + str.substr(1);
}

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
var chooseServiceList = document.getElementById('choose-service');
function checkCheckbox(checkbox) {
  if (!checkbox.checked)
    checkbox.checked = true;
  else
    checkbox.checked = false;
}
function serviceCheckbox() {
  if (this.className === 'label-service') {
    checkCheckbox(this.previousSibling);
  }
}
function getCompanyInfo(company_id) {
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      var data = JSON.parse(xhttp.responseText);
      if (parseInt(data[0].employers_visible) == 1)
        document.getElementById('choose-stylist').style.display = 'block';
      else
        document.getElementById('choose-stylist').style.display = 'none';
    }
  }
  xhttp.open('POST', baseUrl + '/mobile_api/post/company_info.php', false);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('company_id=' + company_id);
}
function renderService(id, description, price, time) {
  return '<input type="checkbox" name="service' + id + '" value="' + id +'" class="input-service"><label class="label-service" for="service' + id + '"><span class="service-description">' + description + '</span><span class="service-price"> ' + price + ' kr</span><span class="service-time">' + time + 'h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>';
}
function getServices(company_id, company_data) {
  // console.log(company_data[0].innerHTML);
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      console.log(xhttp.responseText);
      var data = JSON.parse(xhttp.responseText);
      if (data.length > 0) {
        var nextCategory = false;
        var previousCategory = null;
        for (var i = 0; i < data.length; i++) {
          nextCategory = (previousCategory !== data[i].category_name) ? true : false;
          if (nextCategory) {
            $(chooseServiceList).append('<div class="service-category">' + data[i].category_name + '</div>');
            $(chooseServiceList).append(renderService(data[i].id, data[i].description, data[i].price, data[i].time));
            document.getElementsByClassName('label-service')[i].addEventListener('click', serviceCheckbox, false);
          }
          else {
            $(chooseServiceList).append(renderService(data[i].id, data[i].description, data[i].price, data[i].time));
            document.getElementsByClassName('label-service')[i].addEventListener('click', serviceCheckbox, false);
          }
          previousCategory = data[i].category_name;
        }
      }
      // console.log(data);
      // console.log(categories);
      document.getElementById('no-position').style.display = 'none';
      document.getElementById('selected-company').style.display = 'block';
      document.getElementById('company-name').innerHTML = company_data[0].innerHTML;
      document.getElementById('company-address').innerHTML = company_data[1].innerHTML;
      start.style.backgroundImage = 'url(img/2.jpg)';
      $('html, body').animate({scrollTop: 0}, 1500);
    }
  }
  xhttp.open('POST', baseUrl + '/mobile_api/post/services.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('company_id=' + company_id);
}

send.addEventListener('click', function() {
  event.preventDefault();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      var companies = JSON.parse(xhttp.responseText);
      gMap.style.display = 'block';
      companyList.style.display = 'block';
      initialize(lat.value, lng.value, companies);
      function isEven(n) {
        return (n % 2 == 0) ? 'even' : 'odd';
      }

      for (var i = 0; i < companies.length; i++) {
        $(companyList).append('<div class="company company-' + isEven(i) + '" data-id="' + companies[i].id + '"><h3 class="company-name">' + companies[i].Bolagsnamn + '</h3><p class="company-address">' + companies[i].Adress + '</p><p class="company-postalcode">' + companies[i].Postnr.substring(0,3) + ' ' + companies[i].Postnr.substring(3,5) + ' ' + companies[i].Postort +'</p></div>');
        document.getElementsByClassName('company')[i].addEventListener('click', function() {
          getCompanyInfo(this.getAttribute('data-id'));
          getServices(this.getAttribute('data-id'), this.childNodes);
        });
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
function renderStyle(event, padding, color) {
  event.target.style.padding = padding
  event.target.style.color = color;
}
var selectedDay = document.getElementById('choose-day');
var chooseTime = document.getElementById('choose-time');
var datePicker = document.getElementById('date-picker');
selectedDay.addEventListener('click', function() {
  if (datePicker.style.display == 'none')
    datePicker.style.display = 'inline-block';
  if (chooseTime.style.display == 'inline-block')
    chooseTime.style.display = 'none';
});
function getTimes(day) {
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      selectedDay.firstChild.innerHTML = day + ' ';
      datePicker.style.display = 'none';
      chooseTime.style.display = 'inline-block';
    }
  }
  xhttp.open('POST', baseUrl + '/mobile_api/post/times.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('company_id=' + 3605 + '&day=' + day);
}

$('#date-picker').datepicker({
  dateFormat: 'yy-mm-dd',
  firstDay: 1,
  onSelect: function(date) {
    getTimes(date);
  }
});
var loginModal = document.getElementById('login-modal');
var loginAs = null;
var error = document.getElementById('error');
function login() {
  var input = {};
  input.user = document.getElementById('username').value;
  input.password = document.getElementById('password').value;
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      if (parseInt(xhttp.responseText) == 1) {
        if (loginAs === 'private')
          location.reload(true);
        else
          location.replace('company/todo');
      }
      if (xhttp.responseText === 'wrong username') {
        error.innerHTML = 'Email eller telefon stämmer inte';
      }
      if (xhttp.responseText === 'wrong password') {
        error.innerHTML = 'Fel lösenord';
      }
    }
  }
  xhttp.open('POST', baseUrl + '/mobile_api/post/auth.' + loginAs + '.php', true);
  xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhttp.send('login=' + JSON.stringify(input));
}
function showLoginModal(person) {
  if (person === 'private') {
    document.getElementById('login-as').innerHTML = 'Logga in som privatperson';
    document.getElementById('login-user').innerHTML = 'Email eller personnr';
  }
  else {
    document.getElementById('login-as').innerHTML = 'Logga in som stylist';
    document.getElementById('login-user').innerHTML = 'Email eller telefon';
  }
  loginAs = person;
  document.getElementById('login').addEventListener('click', login);
  document.getElementById('password').onkeydown = function(e){
     if(e.keyCode == 13){
       login();
     }
  };
  setTimeout(function() {
    loginModal.className += ' md-show';
  }, 500);
  document.getElementsByClassName('md-overlay')[0].addEventListener('click', function(event) {
    loginModal.className = 'md-modal md-effect-1';
  });
}
var notyInit = false;
document.getElementById('show-login-modal').addEventListener('click', function(event) {
  var message = noty({
    text: 'Hur vill du logga in som?',
    layout: 'center',
    theme: 'relax',
    animation: {
      open: {height: 'toggle'}, 
        close: {height: 'toggle'},
        easing: 'swing',
        speed: 500 
    },
    closeWith: ['click'],
    buttons: [{
      addClass: 'btn btn-primary', text: 'Privatperson', onClick: function ($noty) {    
        $noty.close();
        showLoginModal('private');
      }
    },
    {
      addClass: 'btn btn-danger', text: 'Stylist', onClick: function ($noty) {
        $noty.close();
        showLoginModal('stylist');
      }
    }]
  });
  document.getElementsByClassName('noty_buttons')[0].style.textAlign = 'center';
  notyInit = true;
});
document.addEventListener('click', function(event) {
  if (!notyInit && event.target.className.substring(0,4) !== 'noty')
    $.noty.closeAll();
  notyInit = false;
});