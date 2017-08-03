var geocoder;
var marker;
var latLng;
var latLng2;
var map;
function initialize() {
  geocoder = new google.maps.Geocoder();
  latLng = new google.maps.LatLng(-0.21006886022414328 ,-78.49149465662231);
  map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom:13,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.TERRAIN,
    disableDefaultUI: true,
    fullscreenControl: true,
    styles:[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]
  });


    marker = new google.maps.Marker({
    position: latLng,
    title: 'Arrastra el marcador si quieres moverlo',
    map: map,
    draggable: true
  });

     google.maps.event.addListener(map, 'click', function(event) {
     updateMarker(event.latLng);
   });
      geocodePosition(latLng);
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Arrastrando...');
  });
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Arrastrando...');
    updateMarkerPosition(marker.getPosition());
  });
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Arrastre finalizado');
    geocodePosition(marker.getPosition());
  });
}
google.maps.event.addDomListener(window, 'load', initialize);
function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
      updateMarkerAddress(responses[0].formatted_address);
    } else {
      updateMarkerAddress('No puedo encontrar esta direccion.');
    }
  });
}
function codeLatLon() {
      str= document.form_mapa.longitud.value+" , "+document.form_mapa.latitud.value;
      latLng2 = new google.maps.LatLng(document.form_mapa.latitud.value ,document.form_mapa.longitud.value);
      marker.setPosition(latLng2);
      map.setCenter(latLng2);
      geocodePosition (latLng2);
}
function codeAddress() {
        var address = document.form_mapa.direccion.value;
          geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
           } else {
            alert('Error! no existe : ' + status);
          }
        });
      }
function codeAddress2 (address) {
          geocoder.geocode( { 'address': address}, function(results, status) {
          if (status == google.maps.GeocoderStatus.OK) {
             updateMarkerPosition(results[0].geometry.location);
             marker.setPosition(results[0].geometry.location);
             map.setCenter(results[0].geometry.location);
             document.form_mapa.direccion.value = address;
           } else {
            alert('Error no se encuentrá este lugar');
          }
        });
      }
function updateMarkerStatus(str) {
  document.form_mapa.direccion.value = str;
}
function updateMarkerPosition (latLng) {
  document.form_mapa.longitud.value =latLng.lng();
  document.form_mapa.latitud.value = latLng.lat();
}
function updateMarkerAddress(str) {
  document.form_mapa.direccion.value = str;
}
function updateMarker(location) {
        marker.setPosition(location);
        updateMarkerPosition(location);
        geocodePosition(location);
      }
