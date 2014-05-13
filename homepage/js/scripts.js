function combine_action(form) {
  // combine option and input values to create the form action
  form.action = document.getElementById('stype').value+document.getElementById('sinput').value;
  
  // if Google option is selected, we must use GET method instead of POST
  if (document.getElementById('stype').value === 'https://encrypted.google.com/#q=') form.method="GET";
};

$(document).ready(function() {
  // a hack for those using chromium, so it will display our scratchpad
  // textarea without cutting about 8px off the right side, for some odd reason
  // -- it also styles our buttons and dropdowns to look proper, since chromium
  // doesn't seem to like to fully utilize our GTK+ theme
  if (navigator.appVersion.indexOf("Chrome/") != -1) {
    $('#id-iframe-wrapper').addClass('iframe-wrapper-chrome-hack');
    $('#stype').addClass('iframe-wrapper-chrome-hack');
  }
  
  // shows feed tab was clicked
  $('#id-tabs-feed-1').click(function() {
    $('#id-label-shows').show();
    $('#id-feed-shows').show();
    $('#id-label-reddit').hide();
    $('#id-feed-reddit').hide();
    $('#id-tabs-feed-1').removeClass('tabs-unselected').addClass('tabs-selected');
    $('#id-tabs-feed-2').removeClass('tabs-selected').addClass('tabs-unselected');
  });
  
  // reddit feed tab was clicked
  $('#id-tabs-feed-2').click(function() {
    $('#id-label-shows').hide();
    $('#id-feed-shows').hide();
    $('#id-label-reddit').show();
    $('#id-feed-reddit').show();
    $('#id-tabs-feed-1').removeClass('tabs-selected').addClass('tabs-unselected');
    $('#id-tabs-feed-2').removeClass('tabs-unselected').addClass('tabs-selected');
  });
});
