<?php
$useragent = $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    header('Location: mobile');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Frisörbokning</title>
    <noscript>
        <meta http-equiv="refresh" content="0;url=activate-javascript">
    </noscript>
    <link rel="stylesheet" type="text/css" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="http://saeedalipoor.github.io/icono/icono.min.css">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="vendor/component.css">
    <link rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="md-modal md-effect-1" id="login-modal">
        <div class="md-content">
            <h3 id="login-as"></h3>
            <div>
                <p id="login-user"></p>
                <input type="text" id="username">
                <p>Lösenord</p>
                <input type="password" id="password">
                <button id="login">Logga in</button>
                <p id="error"></p>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
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
                <div id="show-login-modal" style="color:#FFFFFF;text-align:center;cursor:pointer;">Logga in</div>
            </div>
            <div id="selected-company" style="display:none;">
                <div id="company-data">
                    <h3 id="company-name"></h3>
                    <div id="company-address"></div>
                    <div id="day-area">
                        <div id="date-picker"></div>
                        <div id="choose-day"><span>Välj dag </span><i class="ion-ios-arrow-down"></i></div>
                        <div id="choose-time" style="margin-top:15px;display:none;float:right;">
                            <div>09:00</div>
                            <div>09:30</div>
                            <div>10:00</div>
                            <div>10:30</div>
                            <div>11:00</div>
                            <div>11:30</div>
                            <div>12:00</div>
                            <div>12:30</div>
                            <div>13:30</div>
                            <div>14:00</div>
                            <div>14:30</div>
                            <div>15:00</div>
                            <div>15:30</div>
                            <div>16:00</div>
                        </div>
                    </div>
                </div>
                <div id="choose-service">
                    <select id="choose-stylist" style="color:#FFFFFF;margin:-50px 0px 0px 0px;position:absolute;display:none;">
                        <option value="" selected>Välj frisör</option>
                    </select>
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
<script src="vendor/jquery.noty.packaged.min.js"></script>
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
<script src="vendor/classie.js"></script>
<script src="vendor/modalEffects.js"></script>
<script src="js/script.js"></script>
</body>
</html>