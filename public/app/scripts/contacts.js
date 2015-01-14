/*global google */
/*global console */
/*global _IJITSU_ */
/* jshint devel:true, unused:false, camelcase: false */

$(function() {
  'use strict';
  
  var $container = $('body.contacts .content.contacts-block > .holder');

  $container.masonry({
    //columnWidth: 290,
    itemSelector: '.subject'
  });
  
  var bounds = new google.maps.LatLngBounds();
  
  var markerIcon = { url: '../images/ico-marker.svg'};
  
  var mapOptions = {
      zoom: 16,
      disableDefaultUI: true,
      navigationControl: false,
      //center: new google.maps.LatLng(47.2333330,39.7000000),
      mapTypeControl: false,
      streetViewControl: false,
      //mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [{featureType:'landscape',stylers:[{saturation:-100},{lightness:65},{visibility:'on'}]},{featureType:'poi',stylers:[{saturation:-100},{lightness:51},{visibility:'on'}]},{featureType:'road.highway',stylers:[{saturation:-100},{visibility:'on'}]},{featureType:'road.arterial',stylers:[{saturation:-100},{lightness:30},{visibility:'on'}]},{featureType:'road.local',stylers:[{saturation:-100},{lightness:40},{visibility:'on'}]},{featureType:'transit',stylers:[{saturation:-100},{visibility:'on'}]},{featureType:'administrative.province',stylers:[{visibility:'on'}]/**/},{featureType:'administrative.locality',stylers:[{visibility:'on'}]},{featureType:'administrative.neighborhood',stylers:[{visibility:'on'}]/**/},{featureType:'water',elementType:'labels',stylers:[{visibility:'on'},{lightness:-25},{saturation:-100}]},{featureType:'water',elementType:'geometry',stylers:[{hue:'#ffff00'},{lightness:-25},{saturation:-97}]}]
  };
  
  if (document.getElementById('contacts-map')) {
    var map = new google.maps.Map(document.getElementById('contacts-map'), mapOptions);
  
    var jsonUrl = $('#contacts-map').attr('data-json');
    $.each(_IJITSU_.map_json, function(index, value){
      setTimeout(function() {
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(value.lat, value.lng),
          map: map,
          animation: google.maps.Animation.DROP,
          icon: markerIcon,
        });
        var infowindow = new google.maps.InfoWindow({
          content: '<div class="iwinow">' + value.text + '</div>'
        });
        
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map, marker);
        });
        bounds.extend(marker.position);
        map.fitBounds(bounds);
      }, index * 300);
    });
  }
  
});