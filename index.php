<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Frisörbokning</title>
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div id="start">
        <div id="start-background">
            <div id="no-position">
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
            </div>
            <div id="selected-company"></div>
        </div>
    </div>
    <div id="map"></div>
    <div id="company-list"></div>
<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="https://cdn.firebase.com/js/client/2.3.2/firebase.js"></script>
<script src="https://maps.google.com/maps/api/js?libraries=places"></script>
<script src="vendor/locationpicker.jquery.js"></script>
<script src="js/script.js"></script>
</body>
</html>