$(function() {
  'use strict';
  var _time = 15*1000; //15s
  $('.fader').each(function(){
    var $fader = $(this),
        $unit = $(this).find('.unit'),
        _size = $fader.find('.unit').size() -1,
        _new = 0;
    $unit.eq(0).addClass('active');
    if (_size>0) {
      setInterval(function(){
        var _cur = $fader.find('.unit').index(($fader.find('.unit.active')));
        $fader.find('.unit').removeClass('active');
        if (_cur < _size) {
          _new = _cur + 1;
        } else {
          _new = 0;
        }
        $fader.find('.unit').eq(_new).addClass('active');
      }, _time);
    }
  });
});