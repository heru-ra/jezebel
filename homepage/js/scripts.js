// functions to set and get cookies
function setCookie(name,value,expire_days) {
  var expire_date = new Date();
  expire_date.setDate(expire_date.getDate() + expire_days);
  var value = escape(value) + ((expire_days==null) ? "" : ";domain=;expires="+expire_date.toUTCString());
  document.cookie = name + "=" + value;
}

function getCookie(name) {
  var pattern = RegExp(name + "=.[^;]*");
  matched = document.cookie.match(pattern)
  if (matched) {
    var cookie = matched[0].split('=');
    return cookie[1];
  }
  return false;
}


// a function to check is a supplied url location is external
function isExternal(url) {
    var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
    if (typeof match[1] === "string" && match[1].length > 0 && match[1].toLowerCase() !== location.protocol) return true;
    if (typeof match[2] === "string" && match[2].length > 0 && match[2].replace(new RegExp(":("+{"http:":80,"https:":443}[location.protocol]+")?$"), "") !== location.host) return true;
    return false;
}


// a function that handles our quicksearch bar
function searchSubmit(form) {
  // check if a scheme name was passed, and select the proper search engine
  // if one was found
  $("#search-engine option").each(function() {
    var search_type_value = $(this).val();
    var search_input_value = $('#search-input').val();
    var scheme = $(this).attr('data-scheme');

    if (search_input_value.indexOf(scheme) == 0) {
      document.getElementById('search-engine').value = search_type_value;
      $('#search-input').val(function(index, value) {
        return value.replace(scheme, '');
      });
    }
  });
  
  // combine option and input values to create the form action
  form.action = document.getElementById('search-engine').value+document.getElementById('search-input').value;
  
  // remember the last engine used, via cookie
  setCookie('last_engine',document.getElementById('search-engine').value,7);
  
  // if the option data-method attribute was set to "GET" use that, intead of POST
  if ($("#search-engine option:selected").attr('data-method') === 'GET') form.method="GET";
};


// a function that remedies the (prior) need to manually adjust the position of our
// feed tabs if we wanted to change the height of row-2 and it's info column children
// -- now the math is done for us!
function tabsAlign() {
  var col_2_offsets = $('#col-2').offset();
  var tabs_left = col_2_offsets.left + $('#col-2').width() - $('#tabs').width() / 2 + $('#tabs').height() / 2;
  var tabs_top = col_2_offsets.top + $('#tabs').width() / 2 - $('#tabs').height() / 2;
  document.getElementById("tabs").style.left = tabs_left + 'px';
  document.getElementById("tabs").style.top = tabs_top + 'px';
}


// a function to display a feed error
function feedError(title,text) {
  window.parent.document.getElementById("feed-error-wrapper").style.zIndex = '1';
  window.parent.document.getElementById("feed-error-wrapper").style.display = 'table-row';
  window.parent.document.getElementById("feed-error").innerHTML = '<span class="error-title">' + title + '</span><br /><span class="error-text">' + text + '</span>';
}


// a function that handles the loading of tabbed feeds
function loadFeed(name,url,customerror) {
  // hide our error overlay, in case it was being displayed, and then
  // bring up our loading animation overlay
  document.getElementById("feed-error-wrapper").style.display = 'none';
  document.getElementById("feed-loading").style.display = 'inline';
  
  // set a cookie to remember the visited tab
  setCookie('last_tab',name,7);  
  // load the proper url in our feeds iframe
  $('#iframe-feed-tabbed').attr('src',url);
  // set the feed label to the clicked tab name
  $("#label-feed").text(name);
  
  // go through our tabs, and set the unselected style to those we
  // didn't click, and a selected style to the one we did
  $("#tabs ul li").each(function() {
    $(this).removeClass('tabs-selected').addClass('tabs-unselected');
    if ($(this).attr('id') == 'tab-' + name) {
     $(this).removeClass('tabs-unselected').addClass('tabs-selected');
    }
  });

  // if the url is external and a special custom error was provided,
  // nest the error behind the iframe, so that if the url doesn't load
  // we see the custom error exposed behind it
  // -- note this is a cheap, semi-functional workaround for issues
  // with cross-domain security in iframes, which so far in testing only
  // seems to work properly with Gecko-based browsers
  if (isExternal(url) == true && customerror) {
    feedError('error loading ' + name + ' feed',customerror);
    document.getElementById("feed-error-wrapper").style.zIndex = '-1';
  }
  
  // some more custom error workarounds, specifically for when there is
  // no data connection found or otherwise feeds designated with a custom
  // error reach a timeout limit of 10 seconds
  // -- this too only seems to work on Gecko-based browsers
  if (customerror) {
    $("#iframe-feed-tabbed").load(url, function(responseText, statusText, xhr){
      if (statusText == "error") {
        feedError('error loading ' + name + ' feed',customerror);
        setTimeout(function(){ document.getElementById("feed-loading").style.display = 'none'; }, 10000);
      }
    });
    $("#iframe-feed-tabbed").load(function(){
      document.getElementById("feed-error-wrapper").style.zIndex = '-1';
      document.getElementById("feed-loading").style.display = 'none';
    });
  } else {
    $("#iframe-feed-tabbed").load(function(){
      document.getElementById("feed-error-wrapper").style.zIndex = '1';
      document.getElementById("feed-loading").style.display = 'none';
    });
  }  
}


// a function that performs a workaround on Chrome-based browsers, so that
// if a cross-domain feed doesn't load, we don't get bounced back
// to the previously loaded feed url instead of displaying our custom error
// -- it apparently also works on dwb, which was previously displaying
// the same issue
function loadFeedChromeCheck(name,url,customerror) {
  if (navigator.appVersion.indexOf("Chrome/") != -1) {
    // if Chrome-based, load a blank page before continuing to attempt
    // to load the feed, that way if we are bounced back our src returns
    // to something we can work with
    $('#iframe-feed-tabbed').attr('src','about:blank');
  }
  $("#iframe-feed-tabbed").load(url, function(responseText, statusText, xhr){
    loadFeed(name,url,customerror);
    return;
  });
}


// the functions contained below run if the browser window is resized
$(window).resize(function() {
  // auto-align our feed tabs
  tabsAlign();
});


// the functions contained below run once the document is loaded
$(document).ready(function() {
  // a hack for those using chromium, so it will display our scratchpad
  // textarea without cutting about 8px off the right side, for some odd reason
  // -- it also styles our buttons and dropdowns to look proper, since chromium
  // doesn't seem to like to fully utilize our GTK+ theme
  if (navigator.appVersion.indexOf("Chrome/") != -1) {
    $('#scratchpad-wrapper').addClass('scratchpad-wrapper-chrome-hack');
    $('#search-engine').addClass('scratchpad-wrapper-chrome-hack');
  }

  // auto-align our feed tabs
  tabsAlign();
  
  // adjust col-1-row-1 (links) height, so that it fills in any negative space
  // between it and col-1-row-2 (weather) if there is any, thus forcing the
  // weather feed flush with the bottom of col-2's feeds
  document.getElementById("col-1-row-1").style.height = $('#col-1').height() - $('#col-1-row-2').height() + 'px';
  
  // if a cookie for our last used search engine is defined, use it
  if (getCookie("last_engine")) {
    document.getElementById("search-engine").value = decodeURIComponent(getCookie("last_engine"));
  }
  
  // iframe height is a fickle thing, and this function sets the iframe
  // containing our scratchpad to the same height as it's contents
  $('#iframe-scratchpad').load(function() {
    this.style.height = $(this.contentWindow.document).height() + 'px';
  });
});
