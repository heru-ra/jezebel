<?php
  include "./plugins/functions.php";
  include "./settings.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <title>home</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
  </head>
  <body>
    <div class="wrapper">
      <div class="inline-block grid">
        <div id="row-1" class="row-1">
          <div class="label-horiz">
            <h1>search</h1>
          </div>
          <form id="search" method="POST" onsubmit="searchSubmit(this);">
            <input id="search-input" type="text" value="">
            <select id="search-engine">
              <!-- use the data-scheme attributes in the options below to set search engine  -->
              <!-- scheme names, which can be used to quickly choose a search engine without -->
              <!-- having to manually use the dropdown to the right of the search text field -->
              <!-- EXAMPLE:                                                                  -->
              <!-- typing "y: nyan cat" and hitting enter will search YouTube for "nyan cat" -->
              <option value="https://encrypted.google.com/#q=" data-scheme="g: " data-method="GET">Google</option>
              <option value="https://encrypted.google.com/#tbm=isch&q=" data-scheme="gi: " data-method="GET">Google (Images)</option>
              <option value="http://songmeanings.com/query/?query=" data-scheme="s: ">SongMeanings</option>
              <option value="https://en.wikipedia.org/wiki/Special:Search?search=" data-scheme="w: ">Wikipedia</option>
              <option value="https://www.youtube.com/results?search_query=" data-scheme="y: ">YouTube</option>
            </select>
          </form>
        </div>
        <div id="row-2" class="row-2">
          <div id="col-1" class="table-cell col-1">
            <div id="col-1-row-1" class="col-1-row-1">
              <div class="label-vert">
                <h1>links</h1>
              </div>
              <div id="list-links" class="list-links">
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
                  <li><a href="#">Your College</a></li>
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
            </div>
            <div id="col-1-row-2" class="col-1-row-2">
              <div class="label-vert">
                <h1>weather</h1>
              </div>
              <div class="feed-weather">
<?php echo weatherForecast($weatherWOEID, $weatherTempUnit, $weatherCacheTime); ?>
              </div>
            </div>        
          </div>
          <div id="col-2" class="table-cell col-2">
            <div class="label-vert">
              <h1 id="label-feed">&nbsp;</h1>
            </div>
            <div class="feed-tabbed">
              <div id="feed-loading" class="feed-loading"></div>
              <div id="feed-error-wrapper" class="feed-error-wrapper"><div id="feed-error" class="table-cell feed-error"></div></div>
              <iframe id="iframe-feed-tabbed" src="about:blank" width="100%" height="100%" frameborder="0" scrolling="vertical" seamless></iframe>
            </div>
            <div id="tabs" class="tabs">
<?php echo generateTabs($tabs, $tabsCustomLoadErrors); ?>
            </div>
          </div>
        </div>
        <div class="row-3">
          <iframe id="iframe-scratchpad" src="scratchpad.php" frameborder="0" scrolling="no" seamless></iframe>
        </div>
      </div>
    </div>
    <script src="/js/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/scripts.js"></script>
<?php echo detectTabCookie($_COOKIE["last_tab"], $tabs, $tabsCustomLoadErrors); ?>
  </body>
</html>
