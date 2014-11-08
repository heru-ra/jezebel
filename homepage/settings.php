<?php
  // set below to true, to display timestamps in 24hr format
  $time24hr = false;
  // accepted date formats are "DMY", "YMD", and "MDY"
  // -- default is MDY
  // -- note this doesn't affect the calendar feed, because it
  // plays by your Google server-side settings
  $dateFormat = "MDY";

  // if you feel uncomfortable leaving your gmail password plain-text
  // in a file like this, feel free to leave the field blank
  // -- the inbox counter will not display, but it won't break any
  // other functions. however if you leave the address field blank,
  // the calendar won't show
  // -- note you must also be logged into google/gmail in your
  // browser session for calendar to show, as it relies on those
  // cookies
  $gmailAddress = "address@domain.com";
  $gmailPassword = "";
  
  // you can find the WOEID number for your local city by navigating to
  // http://weather.yahoo.com
  // -- search for your city, then copy/paste the numerical code that
  // is located at the end of the URL
  $weatherWOEID = "2475687";
  // accepts either "f" or "c" (Farenheit or Celcius)
  // default is Farenheit
  $weatherTempUnit = "f";
  // amount of time to cache weather feed (in seconds)
  // -- default and recommended value is 1800 (0.5 hr)
  $weatherCacheTime = 1800;
  
  // add whatever tab names and feed urls you want to include, and the
  // proper tabs and attributes will be automatically generated for you
  // format is: "tab name" => "url"
  $tabs = array(
    "calendar" => "https://www.google.com/calendar/embed?showSubscribeButton=0&showTitle=0&showPrint=0&showTabs=0&showTz=0&wkst=1&bgcolor=%232c2c2c&src=$gmailAddress&color=%23FF0000",
    "shows" => "http://localhost/feeds/shows.php",
    "reddit" => "http://localhost/feeds/reddit.php"
  );
  
  // these are meant to be used with tab feeds whose source will not be
  // hosted on the local domain, thus limiting our ability to gather
  // information about their state because of cross-domain security
  // -- see the comments on lines 100, 111, and 135 of the
  // ./js/scripts.js file for more information on how/why this is used,
  // and potential limitations
  $tabsCustomLoadErrors = array(
    "calendar" => "please check your internet connection, configuration, and/or make sure you are logged into Google services"
  );

  // your individual reddit feed key can be found by navigating to
  // https://ssl.reddit.com/prefs/feeds/
  // -- under the "private listings" section, open the "your front page"
  // JSON link, then copy/paste the key in the "feed" field of the URL
  $redditFeedKey = "";
  $redditUsername = "BusterSkeetin";
  // number of reddit comments in history to show in feed
  // -- the higher you go, the more noticible the lag in load time
  // ** max is 100 **
  $redditFeedLimit = 25;

  // venues to use in shows feed -- visit
  // http://acousti.co/songkick
  // for more info on how to use Songkick in conjunction with
  // the acousti.co RSS feed service, and finding venue ids
  $showsFeedVenues = array(
    'http://acousti.co/feeds/venue_id/11585-doug-fir-lounge',
    'http://acousti.co/feeds/venue_id/11593-hawthorne-theatre',
    'http://acousti.co/feeds/venue_id/1433-wonder-ballroom',
    'http://acousti.co/feeds/venue_id/5776-mississippi-studios',
    'http://acousti.co/feeds/venue_id/1228-mcmenamins-crystal-ballroom',
    'http://acousti.co/feeds/venue_id/32177-roseland-theater',
    'http://acousti.co/feeds/venue_id/604921-branx'
  );
  // amount of time to cache shows feed (in seconds)
  // -- default and recommended value is 10800 (3 hrs)
  // because the feeds are notoriously slow, and don't
  // get updated frequently
  $showsCacheTime = 10800;
  
  // height in px or em you want the #row-2 columns to be,
  // i.e. the links + weather feed and the tabbed feeds
  // -- default is 400px
  $row2height = "400px";

  // height in rows you want the scratchpad to be
  // -- default is 6
  $scratchRows = 6;
?>
