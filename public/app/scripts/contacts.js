/*global google */
/*global console */
/*global _IJITSU_ */
/*global theme_path */
/* exported theme_path */
/* jshint devel:true, unused:false, camelcase: false */
/*jshint -W038 */

$(function() {
  'use strict';
  
  var $container = $('body.contacts .content.contacts-block > .holder');

  $container.masonry({
    //columnWidth: 290,
    itemSelector: '.subject'
  });
  
  var bounds = new google.maps.LatLngBounds();
  
  /*if ('undefined' === typeof theme_path) {
    var theme_path = '/';// jshint ignore:line
  }*/
  
  var markerIcon = { url: theme_path + '/images/ico-marker.svg'};
  
  var mapOptions = {
      zoom: 16,
      disableDefaultUI: false,
      navigationControl: true,
      scrollwheel: false,
      //center: new google.maps.LatLng(47.2333330,39.7000000),
      mapTypeControl: false,
      streetViewControl: false,
      //mapTypeId: google.maps.MapTypeId.ROADMAP,
      styles: [{featureType:'landscape',stylers:[{saturation:-100},{lightness:65},{visibility:'on'}]},{featureType:'poi',stylers:[{saturation:-100},{lightness:51},{visibility:'on'}]},{featureType:'road.highway',stylers:[{saturation:-100},{visibility:'on'}]},{featureType:'road.arterial',stylers:[{saturation:-100},{lightness:30},{visibility:'on'}]},{featureType:'road.local',stylers:[{saturation:-100},{lightness:40},{visibility:'on'}]},{featureType:'transit',stylers:[{saturation:-100},{visibility:'on'}]},{featureType:'administrative.province',stylers:[{visibility:'on'}]/**/},{featureType:'administrative.locality',stylers:[{visibility:'on'}]},{featureType:'administrative.neighborhood',stylers:[{visibility:'on'}]/**/},{featureType:'water',elementType:'labels',stylers:[{visibility:'on'},{lightness:-25},{saturation:-100}]},{featureType:'water',elementType:'geometry',stylers:[{hue:'#ffff00'},{lightness:-25},{saturation:-97}]}]
  };
  
  if (document.getElementById('contacts-map')) {
    var map = new google.maps.Map(document.getElementById('contacts-map'), mapOptions);
    var infowindow = new google.maps.InfoWindow();
    
    var jsonUrl = $('#contacts-map').attr('data-json');
    
    $.each(_IJITSU_.map_json, function(index, value){
      //setTimeout(function() {
        var marker = new google.maps.Marker({
          position: new google.maps.LatLng(value.lat, value.lng),
          map: map,
          //animation: google.maps.Animation.DROP,
          icon: markerIcon,
        });
        
        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent('<div class="iwinow">' + value.text + '</div>');
          infowindow.open(map, this);
        });
        bounds.extend(marker.position);
        map.fitBounds(bounds);
      //}, index * 300);
    });
  }
  
});