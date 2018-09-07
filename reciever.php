<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap-grid.css'/>

<!-- Styles -->
<style>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }

    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }

    .top-right {
        position: absolute;
        right: 10px;
        top: 18px;
    }

    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }

    .links > a {
        color: #636b6f;
        padding: 0 25px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }

    .m-b-md {
        margin-bottom: 30px;
    }
</style>
<style>
    /* Set the size of the div element that contains the map */
    #map {
        height: 400px;  /* The height is 400 pixels */
        width: 100%;  /* The width is the width of the web page */
    }
</style>

<script src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.3/socket.io.js"></script>
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
<title>Title of the document</title>

</head>

<body>


<h3>My Google Maps Demo</h3>
<!--The div element for the map -->
<div id="map"></div>
<script>

    function addVehicleMarker(props){

        var marker = new google.maps.Marker({
            position:props.coords,
            map:map,
            //marker icon default olsun
            id:props.id
        });

        window.markers.push(marker);

        // Check for customicon
        if(props.iconImage){
            // Set icon image
            marker.setIcon(props.iconImage);
        }

        // Check content
        if(props.content){
            var infoWindow = new google.maps.InfoWindow({
                content:props.content
            });

            marker.addListener('click', function(){
                infoWindow.open(map, marker);
            });

            google.maps.event.addListener(marker, 'mouseover', function() {
                infoWindow.open(map, marker);
            });

            marker.addListener('mouseout', function() {
                infoWindow.close();
            });
        }
    }

    function deleteAllVehicleMarkes(){

        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
        markers = [];
    }


    // Initialize and add the map
    function initMap() {

        console.log('haritaya geldi');
        // Map options
        var options = {
            zoom:5,
            center:{lat: 41.0082, lng: 28.9784},
            mapTypeControlOptions: {
                mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain',
                    'styled_map']
            }

        }

        // New map
        window.map = new google.maps.Map(document.getElementById('map'), options);
        window.markers = [];

    }

</script>
<!--Load the API from the specified URL
* The async attribute allows the browser to render the page while the API loads
* The key parameter will contain your own API key (which is not needed for this tutorial)
* The callback parameter executes the initMap() function
-->
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDaN_E7XCRhuW-sVlZYM5YijjwXcMFuw0I&callback=initMap">
</script>


	<script>
		var socket = io.connect('//127.0.0.1:3001');

		socket.on('connect', function () {
			console.log('connected');

			socket.on('broadcast', function (data) {
				console.log(data);
                /*
                * Tüm markerleri siliyoruz. Burada sadece mükerrer olan marker da silinebilinirdi.
                * */
				deleteAllVehicleMarkes();

                for (i = 0; i < data.length; i++) {

                    addVehicleMarker({
                        coords:{lat: data[i].latitude, lng: data[i].longitude},
                        content:'<h3>Araç  ID : ' + data[i].vehicleID + ' <h3> <br >' + 'Eklenme Zamanı : ' + data[i].date,
                        id : data[i].vehicleID
                    });
                }
			});

			socket.on('disconnect', function () {
				console.log('disconnected');
			});
		});
	</script>

</body>

</html> 