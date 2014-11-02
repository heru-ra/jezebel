<?php
  include "../plugins/functions.php";
  include "../settings.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/scripts.js"></script>
  </head>
  <body style="padding: 0!important">
    <base target="_parent" />
    <div id="feed-reddit" class="feed-reddit">
<?php
  echo feedReddit($redditFeedKey, $redditUsername, $redditFeedLimit, $time24hr, $dateFormat);
?>
    </div>
    <script src="/js/jquery/1.11.0/jquery.min.js"></script>
  </body>
</html>
