<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>home</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script type="text/javascript">
      function combine_action(form) {
        // combine option and input values to create the form action
        form.action = document.getElementById('stype').value+document.getElementById('sinput').value;
        
        // if Google option is selected, we must use GET method instead of POST
        if (document.getElementById('stype').value === 'https://encrypted.google.com/#q=') form.method="GET";
      }
    </script>
  </head>
  <body>
    <div class="wrapper">
      <div class="grid">
        <div class="row-1">
          <div class="horizlabel">
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
            <div class="vertlabel">
              <h1>links</h1>
            </div>
            <div class="links">
              <h2>communication</h2>
              <ul>
                <li><a href="http://mail.google.com">Gmail</a></li>
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
                <li><a href="http://www.github.com">GitHub</a></li>
                <li><a href="#">Your College</a></li>
                <li><a href="http://www.teamtreehouse.com">Treehouse</a></li>
              </ul>
              <h2>entertainment</h2>
              <ul>
                <li><a href="http://www.craigslist.com">Craigslist</a></li>
                <li><a href="http://grooveshark.com">Grooveshark</a></li>
                <li><a href="http://www.imgur.com">Imgur</a></li>
                <li><a href="http://www.reddit.com">Reddit</a></li>
                <li><a href="http://www.youtube.com">YouTube</a></li>
              </ul>
            </div>
            <div class="col-1-row-2">
              <div class="vertlabel">
                <h1>weather</h1>
              </div>
              <div class="weather">
<?php
function ProcessRSSFeed($url) {
  global $rss;
  global $rss_temp;
  $rss_temp = $rss->get($url);
}

// include lastRSS plugin
include "./plugins/lastRSS.php";

// create lastRSS object
$rss = new lastRSS;

// set cache dir and time limit
$rss->cache_dir = './cache';
$rss->cache_time = 4800;

// process weather RSS feed (Portland, OR 97239)
ProcessRSSFeed("http://weather.yahooapis.com/forecastrss?p=97239");

// perform formatting manipulation, then print data
// note: sloppy str_replaces are sloppy, but they work for now
//       --will clean up in future
foreach ($rss_temp['items'] as $item) {
  
  // remove unnecessary text and images that come before current conditions
  $startTagPos = strrpos($item[description], "<![CDATA[");
  $endTagPos = strrpos($item[description], "<b>Current");
  $tagLength = $endTagPos - $startTagPos;
  $item[description] = substr_replace($item[description], "", $startTagPos, $tagLength);

  // remove unnecessary text and links that come after the forecast
  $startTagPos = strrpos($item[description], "\n<br />\n<a href=\"http://us.rd.yahoo.com");
  $endTagPos = strrpos($item[description], "]]>");
  $tagLength = $endTagPos - $startTagPos + 3;
  $item[description] = substr_replace($item[description], "", $startTagPos, $tagLength);

  // give it the style we want
  $item[description] = str_replace("<BR />\n<BR /><b>Forecast:</b><BR />\n", "<br />\n<br />\n", $item[description]);
  $item[description] = str_replace("<b>Current Conditions:</b><br />\n", "                <strong>now</strong> ", $item[description]);
  $item[description] = str_replace("Mon -", "<strong>mon</strong>", $item[description]);
  $item[description] = str_replace("Tue -", "<strong>tue</strong>", $item[description]);
  $item[description] = str_replace("Wed -", "<strong>wed</strong>", $item[description]);
  $item[description] = str_replace("Thu -", "<strong>thu</strong>", $item[description]);
  $item[description] = str_replace("Fri -", "<strong>fri</strong>", $item[description]);
  $item[description] = str_replace("Sat -", "<strong>sat</strong>", $item[description]);
  $item[description] = str_replace("Sun -", "<strong>sun</strong>", $item[description]);
  $item[description] = str_replace("High:", "<br /><em>High:</em>", $item[description]);
  $item[description] = str_replace("Low:", "<em>Low:</em>", $item[description]);
  $item[description] = str_replace(".", "", $item[description]);
  $item[description] = str_replace("\n", "\n                ", $item[description]); // this is just me being compulsive about proper source indentation
  
  // boom
  echo "$item[description]\n";
}
?>
              </div>
            </div>        
          </div>
          <div class="col-2">
            <div class="vertlabel">
              <h1>shows</h1>
            </div>
            <div class="show_feed">
              <ul>
<?php
// venue RSS feeds
$rss_shows = array(
  'http://acousti.co/feeds/venue_id/11585-doug-fir-lounge',
  'http://acousti.co/feeds/venue_id/11593-hawthorne-theatre',
  'http://acousti.co/feeds/venue_id/1433-wonder-ballroom',
  'http://acousti.co/feeds/venue_id/5776-mississippi-studios',
  'http://acousti.co/feeds/venue_id/1228-mcmenamins-crystal-ballroom'
);

$rss_shows_merged = array();
$rss_shows_sorted = array();

// process each venue feed and merge into one array
foreach ($rss_shows as $url) {
  ProcessRSSFeed($url);
  $rss_shows_merged = array_merge_recursive($rss_shows_merged, $rss_temp);
}

// perform (sloppy) formatting manipulation on merged array
// and then add entries into a new, cleaner array
foreach ($rss_shows_merged['items'] as $item) {
  
  // remove the show date at end of title, since we will later print it separately
  $startTagPos = strrpos($item[title], " (");
  $endTagPos = strrpos($item[title], ")");
  $tagLength = $endTagPos - $startTagPos + 1;
  $item[title] = substr_replace($item[title], "", $startTagPos, $tagLength);
  
  // stylize the venue names themselves, and shorten specific ones if we wish
  $item[title] = str_replace("Doug Fir Lounge", "<em>Doug Fir Lounge</em>", $item[title]);
  $item[title] = str_replace("Mississippi Studios", "<em>Mississippi Studios</em>", $item[title]);
  $item[title] = str_replace("Wonder Ballroom", "<em>Wonder Ballroom</em>", $item[title]);
  $item[title] = str_replace("Hawthorne Theatre", "<em>Hawthorne Theatre</em>", $item[title]);
  $item[title] = str_replace("McMenamin's Crystal Ballroom", "<em>Crystal Ballroom</em>", $item[title]);
  
  // add to dat new array
  $rss_shows_sorted[$item[pubDate]] = "<a href=\"$item[link]\">$item[title]</a>";
}

// sort new array, via leading timestamp keys
ksort($rss_shows_sorted);

// format timestamps to a readable (lowercase) format then print shows
foreach ($rss_shows_sorted as $key => $item) {
  $shortdate = strtolower(gmdate("M d", $key));
  echo "                <li><strong>$shortdate</strong>$item</li>\n";
}
?>
              </ul>
            </div>
          </div>
        </div>
        <div class="row-3">
<?php
// if scratchpad form submitted, write textarea contents to file
if(array_key_exists('scratchpad', $_POST)) {
  $file_open = fopen("scratchpad","w+");
  fwrite($file_open, $_POST['scratchpad']);
  fclose($file_open);
}
?>
          <form action="<?=$PHP_SELF?>" method="POST">
            <textarea name="scratchpad" rows=5 class="scratchpad"><?php
// open scratchpad file and print contents in textarea
$textfile = file ("scratchpad");
foreach ($textfile as $line) {
  echo $line;
}
?></textarea>    
            <div class="horizlabel">
              <h1>scratchpad</h1>
            </div>
            <button type="submit">Save</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
