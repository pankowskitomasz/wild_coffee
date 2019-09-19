$(function() {
    $('.lazy').Lazy();
});

$("input, textarea").on("paste",function(){
    return false;
});

function checkFormText(){
    var inputArray = $("input[type='text']");
    var rgx = new RegExp(/[^a-zA-Z]+$/i);  
    for(var i=0;i<inputArray.length;i++){
        if(inputArray[i].value.match(rgx)){
            return false;
        }
    }
    return true;
}

function checkFormTel(){
    var inputArray = $("input[type='tel']");
    var rgx = new RegExp(/[^0-9]+$/i);  
    for(var i=0;i<inputArray.length;i++){
        if(inputArray[i].value.match(rgx)){
            return false;
        }
    }
    return true;
}

function checkFormEmail(){
    var inputArray = $("input[type='email']");
    var rgx = new RegExp(/[^a-zA-Z0-9.@]+$/i);
    for(var i=0;i<inputArray.length;i++){
        if(inputArray[i].value.match(rgx)){
            return false;
        }
    }
    return true;
}

function checkFormTextarea(){
    var inputArray = $("input[type='textarea']");
    var rgx = new RegExp(/[^a-zA-Z0-9.,!?#\- ]+$/i);
    for(var i=0;i<inputArray.length;i++){
        if(inputArray[i].value.match(rgx)){
            return false;
        }
    }
    return true;
}

function checkForm(){
    if(checkFormText()===true
        && checkFormTel()===true
        && checkFormEmail()===true
        && checkFormTextarea()===true){
            return true;
        }
    return false;
}

function swapTarget(){
    $("form").eq(0).attr("action","confirm.php");
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
}

function acceptPrivacyPolicy(){
    setCookie("privacy_accepted","1",1);
    $("#privacyModal").modal('hide');
}

function gpdrDeclaration(){
    if(getCookie("privacy_accepted")!="1"){
        $("#privacyModal").modal();
    }
}

function pointsMap() {
	var opts = {
	    center: new google.maps.LatLng(-33.8605473, 151.0632209),
	    zoom:11,
	    maxZoom:11,
	    panControl: false,
	    zoomControl: true,
	    mapTypeControl: false,
	    scaleControl: false,
	    streetViewControl: false,
	    overviewMapControl: false,
	    rotateControl: false,
	    scrollwheel: false
	};
	var map = new google.maps.Map(document.getElementById("map-container"),opts);
	var point1 = new google.maps.Marker({
	 	position: new google.maps.LatLng(-33.8605473, 151.0632209),
	 	map: map,
	 	animation: google.maps.Animation.Drop
	});
}
$("#modal-portfolio, #modal-portfolio *").click(function(){
    $(this).modal('hide');
});
$(".thumbnail-link").click(function(){
    var imgFile = $(this).find("img").attr("src");
    $("#modal-portfolio img").attr("src",imgFile);
    $("#modal-portfolio").modal();
});

gpdrDeclaration();
setTimeout(swapTarget,11000);