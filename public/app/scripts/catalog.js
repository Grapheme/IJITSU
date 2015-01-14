$(function() {
  'use strict';
  
  function detailClose(callback) {
    $('.detail-view.active').slideUp(500, function(){
      $('.detail-view.active').find('.detail').remove();
      $('.detail-view').removeClass('active');
      callback();
      $('.detail-view').each(function(){
        if (!$(this).is('.active')) {
          $(this).prev('.mark').css({
            'left': -50
          });
        }
      });
    });
  }
  
  $('body.catalog .content a.col').click(function(e){
    if (!$(this).is('.active')) {
      $('body.catalog .content a.col').removeClass('active');
      $(this).addClass('active');
      
      var $detail = $(this).find('.detail').clone(),
          $detailContainer = $(this).closest('.content').next('.mark').next('.detail-view'),
          $colors = $detail.find('.colors .unit'),
          $bigImg = $detail.find('.left .visual div').eq(0),
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
            $bigImg.css({
              'background-image':'url('+src+')'
            }).addClass('show');
          });
        });
        
        $colors.eq(0).click();
        
        $closeBtn.click(function(){
          $('.mark').css({
            'left': -50
          });
          detailClose(function(){
            $('body.catalog .content a.col').removeClass('active');
          });
        });
        
        $detailContainer.prev('.mark').css({
          'left': leftPx,
          'opacity': 1
        });
        $detailContainer.slideDown(500);
      });
    } else {
      $('.mark').css({
        'left': -50
      });
      detailClose(function(){
        $('body.catalog .content a.col').removeClass('active');
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