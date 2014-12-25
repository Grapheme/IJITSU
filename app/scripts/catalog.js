$(function() {
  'use strict';
  
  function detailClose(callback) {
    $('.detail-view.active').slideUp(500, function(){
      $('.detail-view.active').find('.detail').remove();
      $('.detail-view').removeClass('active');
      callback();
    });
  }
  
  $('body.catalog .content a.col').click(function(e){
    if (!$(this).is('.active')) {
      $('body.catalog .content a.col').removeClass('active');
      $(this).addClass('active');
      
      var $detail = $(this).find('.detail').clone(),
          $detailContainer = $(this).closest('.content').next('.detail-view'),
          $colors = $detail.find('.colors .unit'),
          $bigImg = $detail.find('.left .visual img').eq(0),
          $closeBtn = $detail.find('.close'),
          leftPx = $(this).offset().left+100;
          
      $detailContainer.addClass('active');
      
      detailClose(function(){
        $detailContainer.addClass('active');
        $detail.appendTo($detailContainer);
        
        $colors.click(function(){
          $colors.removeClass('active');
          $bigImg.removeClass('show');
          $(this).addClass('active');
          var src = $(this).attr('data-big-img');
          $('<img src="'+src+'">').load(function(){
            $bigImg.attr('src', src).addClass('show');
          });
        });
        
        $colors.eq(0).click();
        
        $closeBtn.click(function(){
          detailClose(function(){});
        });
        
        $detailContainer.find('.mark').css({
          'left': leftPx
        });
        $detailContainer.slideDown(500);
      });
    }
    
    e.preventDefault();
  });
  
  var hash = window.location.hash || null;
  
  if(hash) {
    if (hash.split('-')[0]==='#id') {
      var $unit = $(hash);
      $unit.click();
      $unit.blur();
    }
  }
  
});