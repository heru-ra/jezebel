function combine_action(form) {
  // combine option and input values to create the form action
  form.action = document.getElementById('stype').value+document.getElementById('sinput').value;
  
  // if Google option is selected, we must use GET method instead of POST
  if (document.getElementById('stype').value === 'https://encrypted.google.com/#q=') form.method="GET";
};

// a function to set cookies that we will use to remember things, such as
// the last tab visited
function setCookie(name,value,expire_days) {
  var expire_date=new Date();
  expire_date.setDate(expire_date.getDate() + expire_days);
  var value=escape(value) + ((expire_days==null) ? "" : ";domain=;expires="+expire_date.toUTCString());
  document.cookie=name + "=" + value;
}

$(document).ready(function() {
  // a hack for those using chromium, so it will display our scratchpad
  // textarea without cutting about 8px off the right side, for some odd reason
  // -- it also styles our buttons and dropdowns to look proper, since chromium
  // doesn't seem to like to fully utilize our GTK+ theme
  if (navigator.appVersion.indexOf("Chrome/") != -1) {
    $('#id-iframe-wrapper').addClass('iframe-wrapper-chrome-hack');
    $('#stype').addClass('iframe-wrapper-chrome-hack');
  }
  
  // calendar feed tab was clicked
  $('#id-tabs-feed-calendar').click(function() {
    setCookie('last_tab','calendar',7);
    $('#id-label-calendar').show();
    $('#id-feed-calendar').show()
    $('#id-label-shows').hide();
    $('#id-feed-shows').hide();
    $('#id-label-reddit').hide();
    $('#id-feed-reddit').hide();
    $('#id-tabs-feed-calendar').removeClass('tabs-unselected').addClass('tabs-selected');
    $('#id-tabs-feed-shows').removeClass('tabs-selected').addClass('tabs-unselected');
    $('#id-tabs-feed-reddit').removeClass('tabs-selected').addClass('tabs-unselected');
  });
  
  // shows feed tab was clicked
  $('#id-tabs-feed-shows').click(function() {
    setCookie('last_tab','shows',7);
    $('#id-label-calendar').hide();
    $('#id-feed-calendar').hide();
    $('#id-label-shows').show();
    $('#id-feed-shows').show();
    $('#id-label-reddit').hide();
    $('#id-feed-reddit').hide();
    $('#id-tabs-feed-calendar').removeClass('tabs-selected').addClass('tabs-unselected');
    $('#id-tabs-feed-shows').removeClass('tabs-unselected').addClass('tabs-selected');
    $('#id-tabs-feed-reddit').removeClass('tabs-selected').addClass('tabs-unselected');
  });
  
  // reddit feed tab was clicked
  $('#id-tabs-feed-reddit').click(function() {
    setCookie('last_tab','reddit',7);
    $('#id-label-calendar').hide();
    $('#id-feed-calendar').hide();
    $('#id-label-shows').hide();
    $('#id-feed-shows').hide();
    $('#id-label-reddit').show();
    $('#id-feed-reddit').show();
    $('#id-tabs-feed-calendar').removeClass('tabs-selected').addClass('tabs-unselected');
    $('#id-tabs-feed-shows').removeClass('tabs-selected').addClass('tabs-unselected');
    $('#id-tabs-feed-reddit').removeClass('tabs-unselected').addClass('tabs-selected');
  });
});
