var marker;
var map;
var cycle = new google.maps.MarkerImage();
var _markers = [];
var choices =  [];
var options =[];
var markeroptions = []
var marker_youarehere;
var marker_cross;
var apotheken = "http://localhost:8888/ZendFrameworkTest/public/index/getjson/type/apotheken";
var ziekenhuizen = "http://localhost:8888/ZendFrameworkTest/public/index/getjson/type/ziekenhuizen";
var dierenartsen = "http://localhost:8888/ZendFrameworkTest/public/index/getjson/type/dierenartsen";
var huisartsen = "http://localhost:8888/ZendFrameworkTest/public/index/getjson/type/huisartsen";
var huisartsenwachtposten = "http://localhost:8888/ZendFrameworkTest/public/index/getjson/type/huisartsenwachtposten";
var infowindow = new google.maps.InfoWindow();


function initialize() {
    marker_orange = new google.maps.MarkerImage('img/markeroranje.png',
        new google.maps.Size(50, 70),
        new google.maps.Point(0,0),
        new google.maps.Point(12, 32),
        new google.maps.Size(25, 35)
    );
        
    marker_blue = new google.maps.MarkerImage('img/markerblauw.png',
        new google.maps.Size(50, 70),
        new google.maps.Point(0,0),
        new google.maps.Point(12, 32),
        new google.maps.Size(25, 35)
    );
        
    marker_green = new google.maps.MarkerImage('img/markergroen.png',
        new google.maps.Size(50, 70),
        new google.maps.Point(0,0),
        new google.maps.Point(12, 32),
        new google.maps.Size(25, 35)
    );
        
    marker_purple = new google.maps.MarkerImage('img/markerpaars.png',
        new google.maps.Size(50, 70),
        new google.maps.Point(0,0),
        new google.maps.Point(12, 32),
        new google.maps.Size(25, 35)
    );
        
    marker_red = new google.maps.MarkerImage('img/markerrood.png',
        new google.maps.Size(50, 70),
        new google.maps.Point(0,0),
        new google.maps.Point(12, 32),
        new google.maps.Size(25, 35)
    );
        
    marker_cross = new google.maps.MarkerImage('img/marker.png',
        new google.maps.Size(50, 70),  
        new google.maps.Point(0,0),
        new google.maps.Point(12.5, 34),
        new google.maps.Size(25, 35)
    );
       
    //LINK OPTIONS TO MARKERS
    options.push("apotheken");             markeroptions.push(marker_green);
    options.push("ziekenhuizen");          markeroptions.push(marker_red);
    options.push("dierenartsen");          markeroptions.push(marker_orange);
    options.push("huisartsen");            markeroptions.push(marker_blue);
    options.push("huisartsenwachtposten"); markeroptions.push(marker_purple);
    
  var mapOptions = {
    zoom: 11,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    center: new google.maps.LatLng(51.054398, 3.725224)
  };

  map = new google.maps.Map(document.getElementById("googlemap"), mapOptions);
  google.maps.event.addListenerOnce(map, 'bounds_changed', function(){
		getGeoLocation();
	});
}

function getGeoLocation(){
	if(Modernizr.geolocation){
		navigator.geolocation.getCurrentPosition(geoSuccess, geoError, { maximumAge: 60000, timeout: 10000, enableHighAccuracy: true});
	}else{
		geoFallBack();
	}
}

function geoSuccess(position){
	var coordinates = position.coords;
	_currentGeoPositionGoogleMapMarker = new google.maps.Marker({
		position: new google.maps.LatLng(coordinates.latitude, coordinates.longitude),
		map:map,
		title: "My Current Position",
		icon: marker_cross
	})
	map.setCenter(_currentGeoPositionGoogleMapMarker.getPosition());
        loadData(coordinates);
}
function geoError(error){
	switch(error.code){
		//TIMEOUT
		case 3:
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
			break;
		//POSITION UNAVAILABLE
		case 2:
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
			break;
		//PERMISSION DENIED --> FALLBACK
		case 1:
			geoFallBack();
			break;
		default:
			navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
			break;
	};
}
function geoFallBack(){

}

function loadData(coordinates){
    for (var i=0;i<options.length;i++)
    {
        var url = "http://localhost:8888/ZendFrameworkTest/public/data/close/type/"+options[i]+"/lat/"+coordinates.latitude+"/long/"+coordinates.longitude;
        cycle = markeroptions[i];
        $.ajax({ 
            type: 'GET', 
            url: url, 
            dataType: 'json',
            success: function (data) { 
                $.each(data, function(index, element) {
                    var markerstyle = new google.maps.MarkerImage();
                    var color;
                    var current;
                    switch(index)
                        {
                        case "apotheken":
                          markerstyle = marker_green;
                          color = "#cae3ae";
                          current = "apotheek";
                          break;
                        case "ziekenhuizen":
                          markerstyle = marker_red;
                          color = "#ebaeae";
                          current = "ziekenhuis";
                          break;
                        case "dierenartsen":
                          markerstyle = marker_orange;
                          color = "#fbdbb1";
                          current = "dierenarts";
                          break;
                        case "huisartsen":
                          markerstyle = marker_blue;
                          color = "#9cc8e8";
                          current = "huisarts";
                          break;
                        case "huisartsenwachtposten":
                          markerstyle = marker_purple;
                          color = "#e2a9d7";
                          current = "huisartsenwachtpost";
                          break;    
                        default:
                          markerstyle = marker_orange;
                        }
                    $("#lijst").append('<li data-role="list-divider">'+index+'</li>');
                    $.each(element, function(index, element) {       
                    if(typeof element.naam == 'undefined'){element.naam = element.naam_wacht;} 
                    if(typeof element.adres == 'undefined'){element.adres = element.straat+"&nbsp"+element.nr;}
                    if(typeof element.huisnr != 'undefined'){element.adres = element.adres +"&nbsp"+element.huisnr;}
                    marker = new google.maps.Marker({
                        map:map,   
                        title: element.naam,
                        icon: markerstyle,
                        content: "<a href='"+current+"/id/"+element.id+"'><h4>"+element.naam+"</h4></a>"+element.adres+"<br />"+element.postcode+" "+element.gemeente,
                        position: new google.maps.LatLng(element.lat, element.long)
                    });
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(this.content);
                        infowindow.open(map,this);
                    });
                    _markers.push(marker);
                    $('body').append('<div data-role="page" data-theme="a" id="'+element.id+'"><div data-role="header" data-position="inline" data-theme="a"><a href="" data-icon="arrow-l"  data-transition="slide" data-direction="reverse" data-rel="back">Back</a><h1>'+element.naam+'</h1></div><div data-role="content" data-theme="a"><h1>'+element.naam+'</h1><h2>Adres:</h2>'+element.adres+'<br />'+element.postcode+' '+element.gemeente+'</div><div data-role="footer" data-id="foo1" data-position="fixed"><div data-role="navbar"><ul><li><a href="#ctm" class="ui-btn-active ui-state-persist">Close To Me</a></li><li><a href="#diensten" data-transition="slide">Over deze app</a></li></ul></div></div></div>').trigger( "create" );;
                    $("#lijst").append('<li><a href="#'+element.id+'" data-transition="slide" >'+element.naam+' <span class="ui-li-count">'+element.afstand.toFixed(1)+' Km</span></a></li>');
                    $("#lijst").listview("refresh");
                });
            });

            }
        });
        }
    }
function getURLParameter(name) {
    return decodeURI(
        (RegExp(name + '=' + '(.+?)(&|$)').exec(location.search)||[,null])[1]
    );
}
$( document ).delegate("#ctm", "pageinit", function() {
  initialize();
});

$( document ).delegate("#detail", "pagebeforeshow", function() {
	 var id = getURLParameter('id')
	var type = getURLParameter('type')
	alert(id);
});



