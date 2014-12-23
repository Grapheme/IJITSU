/* jshint devel:true, unused:false, strict:false */

var _IJITSU_ = {};

function _log(msg) {
  console.log(msg);
}

_IJITSU_.setYear = function(){
  var now = new Date();
  var year = now.getFullYear();
  $('#footer .curent-year').text(year);
};

$(function() {
  _IJITSU_.setYear();
});