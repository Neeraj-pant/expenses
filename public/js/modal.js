$('.button').click(function(){
  var buttonId = $(this).attr('id');
  $('#modal-container').removeAttr('class').addClass(buttonId);
  $('body').addClass('modal-active');
})
$('.modal-open').click(function(){
  var buttonId = 'one';
  $('#modal-container').removeAttr('class').addClass(buttonId);
  $('body').addClass('modal-active');
})
$('.close-modal').click(function(){
  $('div[id^=modal-container]').addClass('out');
  $('body').removeClass('modal-active');
});
$('.modal-open-2').click(function(){
  var buttonId = 'one';
  $('#modal-container-2').removeAttr('class').addClass(buttonId);
  $('body').addClass('modal-active');
})