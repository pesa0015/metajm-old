<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Frisörbokning</title>
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="http://saeedalipoor.github.io/icono/icono.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div id="start" style="background-image:url(img/2.jpg);">
        <div id="start-background">
            <div id="no-position" style="display:none;">
                <h1 id="intro">Hitta och boka tid till valfri tjänst</h1>
                <form id="geolocation">
                   <div id="row-1" class="row">
                        <input type="checkbox" name="hair" data-title="Frisör" value="valuable" id="hair"/><label class="services" for="hair"></label>
                        <input type="checkbox" name="nail" data-title="Nagelvård" value="valuable" id="nail"/><label class="services" for="nail"></label>
                        <input type="checkbox" name="dental" data-title="Tandvård" value="valuable" id="dental"/><label class="services" for="dental"></label>
                        <input type="checkbox" name="tattoo" data-title="Tatuering" value="valuable" id="tattoo"/><label class="services" for="tattoo"></label> 
                        <span id="submit" class="ion-ios-search"></span>
                    </div>
                    <div id="row-2" class="row">
                        <input type="button" id="get-location" value="Hitta min position">
                        <input type="text" id="address" placeholder="Ange address">
                        <input type="hidden" id="lat" name="lat">
                        <input type="hidden" id="lng" name="lng">
                    </div>
                </form>
                <div style="text-align: center;"><a href="login" style="color: #FFFFFF; text-decoration: none;">Logga in</a></div>
            </div>
            <div id="selected-company">
                <div id="company-data">
                    <h3 id="company-name">FOUR</h3>
                    <div id="company-address">Burgårdsgatan 15</div>
                    <div id="day-area">
                        <!-- <input type="hidden" id="date-picker"> -->
                        <div id="date-picker"></div>
                        <div id="choose-day">Välj dag <i class="ion-ios-arrow-down"></i></div>
                        <!-- <div id="chosen-day">1 feb</div> -->
                    </div>
                </div>
                <div id="choose-service">
                    <div class="service-category">Klippning</div>
                    <input type="checkbox" name="test1" value="3" class="input-service"><label class="label-service" for="test1"><span class="service-description">Man</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test2" value="1" class="input-service"><label class="label-service" for="test2"><span class="service-description">Kvinna</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test3" value="5" class="input-service"><label class="label-service" for="test3"><span class="service-description">Barn</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <div class="service-category">Färgning</div>
                    <input type="checkbox" name="test1" value="3" class="input-service"><label class="label-service" for="test1"><span class="service-description">Man</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test2" value="1" class="input-service"><label class="label-service" for="test2"><span class="service-description">Kvinna</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test3" value="5" class="input-service"><label class="label-service" for="test3"><span class="service-description">Barn</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <div class="service-category">Klippning</div>
                    <input type="checkbox" name="test1" value="3" class="input-service"><label class="label-service" for="test1"><span class="service-description">Man</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test2" value="1" class="input-service"><label class="label-service" for="test2"><span class="service-description">Kvinna</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test3" value="5" class="input-service"><label class="label-service" for="test3"><span class="service-description">Barn</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <div class="service-category">Färgning</div>
                    <input type="checkbox" name="test1" value="3" class="input-service"><label class="label-service" for="test1"><span class="service-description">Man</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test2" value="1" class="input-service"><label class="label-service" for="test2"><span class="service-description">Kvinna</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test3" value="5" class="input-service"><label class="label-service" for="test3"><span class="service-description">Barn</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <div class="service-category">Klippning</div>
                    <input type="checkbox" name="test1" value="3" class="input-service"><label class="label-service" for="test1"><span class="service-description">Man</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test2" value="1" class="input-service"><label class="label-service" for="test2"><span class="service-description">Kvinna</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                    <input type="checkbox" name="test3" value="5" class="input-service"><label class="label-service" for="test3"><span class="service-description">Barn</span><span class="service-price"> 170 kr</span><span class="service-time">1h</span><i class="ion-plus"></i><i class="ion-minus"></i></label>
                </div>
            </div>
        </div>
    </div>
    <div id="map"></div>
    <div id="company-list"></div>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/locale/sv.js"></script>
<!-- <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->
<script src="vendor/jquery-ui.min.js"></script>
<script>
    // var datePicker = $('#date-picker');
    // $(datePicker).datepicker({
    //     onSelect: function(date) {
    //         alert(date);
    //     }
        // selectWeek: true,
        // inline: true,
        // startDate: '01/01/2000',
        // firstDay: 1
    // });
//   $(document).mouseup(function (e)
// {
//     var container = $('#day-area');

//     if (!container.is(e.target) // if the target of the click isn't the container...
//         && container.has(e.target).length === 0) // ... nor a descendant of the container
//     {
//         $(datePicker).hide();
//     }
// });
  </script>
<script src="https://cdn.firebase.com/js/client/2.3.2/firebase.js"></script>
<script src="https://maps.google.com/maps/api/js?libraries=places"></script>
<script src="vendor/locationpicker.jquery.js"></script>
<script src="js/script.js"></script>
</body>
</html>