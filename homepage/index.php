<?php
include "./plugins/functions.php";

// if you feel uncomfortable leaving your gmail password plain-text
// in a file like this, feel free to leave the field blank
// -- the inbox counter will not display, but it won't break any
// other functions. however if you leave the address field blank,
// the calendar won't show
// -- note you must also be logged into google/gmail in your
// general browser for calendar to show, as it relies on those
// cookies
$gmailAddress = "address@domain.com";
$gmailPassword = "";

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

// you can find the WOEID number for your local city by navigating to
// http://weather.yahoo.com
// -- search for your city, then copy/paste the numerical code that
// is located at the end of the URL
$weatherWOEID = "2475687";
// accepts either "f" or "c" (Farenheit or Celcius)
$weatherTempUnit = "f";

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>home</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/scripts.js"></script>
  </head>
  <body>
    <div class="wrapper">
      <div class="grid">
        <div class="row-1">
          <div class="label-h">
            <h1>search</h1>
          </div>
          <form method="POST" id="search" onsubmit="combine_action(this);">
            <input type="text" id="sinput" value="">
            <select id="stype">
              <option value="https://encrypted.google.com/#q=">Google</option>
              <option value="https://www.youtube.com/results?search_query=">YouTube</option>
              <option value="http://songmeanings.com/query/?query=">Lyrics</option>
            </select>
          </form>
        </div>
        <div class="row-2">
          <div class="col-1">
            <div class="label-v">
              <h1>links</h1>
            </div>
            <div class="list-links">
              <h2>communication</h2>
              <ul>
                <li><a href="https://mail.google.com/mail/u/0/?pli=1#inbox">Gmail<?php echo gmailUnreadCount($gmailAddress, $gmailPassword); ?></a></li>
                <li><a href="https://app.mysms.com">MySMS</a></li>
              </ul>
              <h2>work & finance</h2>
              <ul>
                <li><a href="#">Your Workplace</a></li>
                <li><a href="http://www.progressive.com">Progressive</a></li>
                <li><a href="#">Your Bank</a></li>
                <li><a href="http://www.verizonwireless.com">Verizon Wireless</a></li>
              </ul>
              <h2>school & development</h2>
              <ul>
                <li><a href="http://panel.dreamhost.com">DreamHost</a></li>
                <li><a href="https://courses.edx.org/dashboard">EdX</a></li>
                <li><a href="https://github.com/heru-ra">GitHub</a></li>
                <li><a href="http://my.pcc.edu">PCC</a></li>
              </ul>
              <h2>entertainment</h2>
              <ul>
                <li><a href="http://portland.craigslist.com">Craigslist</a></li>
                <li><a href="http://www.facebook.com">Facebook</a></li>
                <li><a href="http://grooveshark.com">Grooveshark</a></li>
                <li><a href="http://www.imgur.com">Imgur</a></li>
                <li><a href="http://www.reddit.com">Reddit<?php echo redditUnreadCount($redditFeedKey, $redditUsername); ?></a></li>                
                <li><a href="https://www.youtube.com">YouTube</a></li>
              </ul>
            </div>
            <div class="col-1-row-2">
              <div class="label-v">
                <h1>weather</h1>
              </div>
              <div class="feed-weather">
<?php echo weatherForecast($weatherWOEID, $weatherTempUnit); ?>
              </div>
            </div>        
          </div>
          <div class="col-2">
            <div class="label-v">
<?php
  // valid tab names, for cross reference
  $tabs = array("calendar", "shows", "reddit");
  
  // display the last visited tab label
  // -- if no or an invalid cookie value is found, default to the
  // calendar tab label
  if($_COOKIE["last_tab"] == "calendar" || $_COOKIE["last_tab"] == false || $_COOKIE["last_tab"] != in_array($_COOKIE["last_tab"], $tabs) ) {
    echo "              <h1 id=\"id-label-calendar\">calendar</h1><h1 id=\"id-label-shows\" style=\"display: none\">shows</h1><h1 id=\"id-label-reddit\" style=\"display: none\">reddit</h1>";
  }
  if($_COOKIE["last_tab"] == "shows") {
    echo "              <h1 id=\"id-label-calendar\" style=\"display: none\">calendar</h1><h1 id=\"id-label-shows\">shows</h1><h1 id=\"id-label-reddit\" style=\"display: none\">reddit</h1>";
  }
  if($_COOKIE["last_tab"] == "reddit") {
    echo "              <h1 id=\"id-label-calendar\" style=\"display: none\">calendar</h1><h1 id=\"id-label-shows\" style=\"display: none\">shows</h1><h1 id=\"id-label-reddit\">reddit</h1>";
  }
?>
            </div>
<?php
  // if calendar was last visited tab, or cookie value not found or
  // invalid, display feed
  if($_COOKIE["last_tab"] == "calendar" || $_COOKIE["last_tab"] == false || $_COOKIE["last_tab"] != in_array($_COOKIE["last_tab"], $tabs) ) {
    echo "            <div id=\"id-feed-calendar\" class=\"feed-calendar\">";
  } else {
    echo "            <div id=\"id-feed-calendar\" class=\"feed-calendar\"  style=\"display: none\">";
  }
?>
              <div class="feed-calendar-error"><span class="error">Could not load calendar:</span><br />Please check your internet connection and/or make sure you are logged into Google services.</div>
              <iframe src="https://www.google.com/calendar/embed?showSubscribeButton=0&showTitle=0&showPrint=0&showTabs=0&showTz=0&wkst=1&bgcolor=%232c2c2c&src=<?php echo "$gmailAddress"?>&color=%23FF0000" width="100%" height="100%" frameborder="0" scrolling="no" seamless></iframe>
            </div>
<?php
  // if shows was last visited tab, display feed
  if($_COOKIE["last_tab"] == "shows") {
    echo "            <div id=\"id-feed-shows\" class=\"feed-shows\">";
  } else {
    echo "            <div id=\"id-feed-shows\" class=\"feed-shows\"  style=\"display: none\">";
  }
  
  echo feedShows($showsFeedVenues);
?>
            </div>
<?php
  // if reddit was last visited tab, display feed
  if($_COOKIE["last_tab"] == "reddit") {
    echo "            <div id=\"id-feed-reddit\" class=\"feed-reddit\">";
  } else {
    echo "            <div id=\"id-feed-reddit\" class=\"feed-reddit\"  style=\"display: none\">";
  }
  
  echo feedReddit($redditFeedKey, $redditUsername, $redditFeedLimit);
?>
            </div>
            <div class="tabs-feed">
              <ul>
<?php
  // select the last visited tab, or default to calendar
  if($_COOKIE["last_tab"] == "calendar" || $_COOKIE["last_tab"] == false || $_COOKIE["last_tab"] != in_array($_COOKIE["last_tab"], $tabs) ) {
    echo "                <li id=\"id-tabs-feed-calendar\" class=\"tabs-selected\"><a href=\"#\">calendar</a></li><li id=\"id-tabs-feed-shows\" class=\"tabs-unselected\"><a href=\"#\">shows</a></li><li id=\"id-tabs-feed-reddit\" class=\"tabs-unselected\"><a href=\"#\">reddit</a></li>";
  }
  if($_COOKIE["last_tab"] == "shows") {
    echo "                <li id=\"id-tabs-feed-calendar\" class=\"tabs-unselected\"><a href=\"#\">calendar</a></li><li id=\"id-tabs-feed-shows\" class=\"tabs-selected\"><a href=\"#\">shows</a></li><li id=\"id-tabs-feed-reddit\" class=\"tabs-unselected\"><a href=\"#\">reddit</a></li>";
  }
  if($_COOKIE["last_tab"] == "reddit") {
    echo "                <li id=\"id-tabs-feed-calendar\" class=\"tabs-unselected\"><a href=\"#\">calendar</a></li><li id=\"id-tabs-feed-shows\" class=\"tabs-unselected\"><a href=\"#\">shows</a></li><li id=\"id-tabs-feed-reddit\" class=\"tabs-selected\"><a href=\"#\">reddit</a></li>";
  }
?>
              </ul>
            </div>
          </div>
        </div>
        <div class="row-3">
          <iframe src="scratchpad.php" frameborder="0" scrolling="no" seamless></iframe>
        </div>
      </div>
    </div>
  </body>
</html>
