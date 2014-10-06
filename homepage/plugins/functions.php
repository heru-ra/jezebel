<?php
include "lastRSS.php";

function gmailUnreadCount($address, $pass) {
  // check if necessary values were passed
  if ($address != false && $pass != false) {
    $rss = new lastRSS;
    $rss_temp = $rss->get("https://mail.google.com/mail/feed/atom", $address, $pass);
    // if unread count higher than 0, display counter
    if ($rss_temp[fullcount] > 0) {
      return " (<em>$rss_temp[fullcount]</em>)";
    }
  }
}

function redditUnreadCount($feed, $user) {
  // check if necessary values were passed
  if ($feed != false && $user != false) {
    $rss = new lastRSS;
    $rss_temp = $rss->get("http://www.reddit.com/message/unread/.rss?feed=$feed&user=$user");
    // if unread count higher than 0, display counter
    if ($rss_temp[items_count] > 0) {
      return " (<em>$rss_temp[items_count]</em>)";
    }
  }
}

function weatherForecast($woeid, $tempunit) {
  // check if necessary values were passed
  if ($woeid != false) {
    $rss = new lastRSS;
    
    // set cache dir and a refresh rate of 1hr (3600 seconds)
    $rss->cache_dir = "./cache";
    $rss->cache_time = 3600;
    
    // check if a temperature unit was specified
    if ($tempunit != "f" && $tempunit != "c") {
      // no unit was properly specified, default to Farenheit
      $tempunit = "f";
    }
    
    // process weather RSS feed
    $rss_temp = $rss->get("http://weather.yahooapis.com/forecastrss?w=$woeid&u=$tempunit");

    // check if we could retrieve the source feed
    if ($rss_temp != false) {
      foreach ($rss_temp["items"] as $item) {
        // remove unnecessary text and images that come before current conditions
        $item[description] = preg_replace("'<!(.*?)<b>'si", "<b>", $item[description]);

        // remove unnecessary text and links that come after the forecast
        $item[description] = preg_replace("'\\n<br />\\n<a href=\"http://us\.rd\.yahoo\.com(.*?)]]>'si", "", $item[description]);

        // give it the style we want
        $item[description] = preg_replace("', (.*?) 'si", ", <em>$1</em> °", $item[description]);
        $item[description] = str_replace("<b>Current Conditions:</b><br />\n", "                <div class=\"table-row\"><strong>now</strong><div class=\"table-cell\">", $item[description]);
        $item[description] = str_replace("<br />", "</em></div></div>", $item[description]);
        $item[description] = str_replace("<BR />\n<BR /><b>Forecast:</b><BR />\n", "</div></div><br />\n", $item[description]);
        $item[description] = preg_replace("'(Mon|Tue|Wed|Thu|Fri|Sat|Sun) - 'esi", "'<div class=\"table-row\"><strong>'.strtolower('$1').'</strong><div class=\"table-cell\">'", $item[description]);
        $item[description] = str_replace(" High: ", "<br />High: <em>", $item[description]);
        $item[description] = str_replace(" Low: ", "</em> Low: <em>", $item[description]);
        $item[description] = str_replace(".", "", $item[description]);
        $item[description] = str_replace("\n", "\n                ", $item[description]); // this is just me being compulsive about proper source indentation
        
        // print the forecast
        return "$item[description]\n";
      }
    } else {
      // couldn't load source feed, return error
      return "                <span class=\"error\">Could not load weather feed:</span> Please check your internet connection and/or configuration.\n";
    }
  } else {
    // a necessary value was missing, return error
    return "                <span class=\"error\">Could not load weather feed:</span> No WOEID was provided in configuration.\n";
  }
}

function feedShows($venues) {
  echo "              <ul>";
  // check if necessary values were passed
  if ($venues != false) {
    $rss = new lastRSS;
    
    // set cache dir and a refresh rate of 3hrs (10800 seconds), because
    // the show feed urls are notoriously slow and we don't really need
    // to update the info all that often
    $rss->cache_dir = "./cache";
    $rss->cache_time = 10800;

    $rss_shows_merged = array();
    $rss_shows_sorted = array();

    // process each venue feed and merge into one array
    foreach ($venues as $url) {
      $rss_temp = $rss->get($url);
      $rss_shows_merged = array_merge_recursive($rss_shows_merged, $rss_temp);
    }
    
    // check if we could retrieve the source feeds
    if ($rss_shows_merged != false) {
      // perform formatting manipulation on merged array and then add
      // entries into a new, cleaner array
      foreach ($rss_shows_merged["items"] as $item) {
        
        // remove the show date at end of title, since we will later
        // print it separately
        $item[title] = preg_replace("' \((January|February|March|April|May|June|July|August|September|October|November|December)(.*?)[0-9]{4}\)'si", "", $item[title]);
                
        // if the show has been cancelled, make it very apparent
        $item[title] = str_replace("(CANCELLED)", "(<span class=\"error\">CANCELLED</span>)", $item[title]);
        
        // stylize the venue names themselves, and shorten specific ones
        // if we wish
        $item[title] = str_replace("Doug Fir Lounge", "<em>Doug Fir Lounge</em>", $item[title]);
        $item[title] = str_replace("Mississippi Studios", "<em>Mississippi Studios</em>", $item[title]);
        $item[title] = str_replace("Wonder Ballroom", "<em>Wonder Ballroom</em>", $item[title]);
        $item[title] = str_replace("Hawthorne Theatre", "<em>Hawthorne Theatre</em>", $item[title]);
        $item[title] = str_replace("McMenamin's Crystal Ballroom", "<em>Crystal Ballroom</em>", $item[title]);
        $item[title] = str_replace("Roseland Theater", "<em>Roseland Theater</em>", $item[title]);
        $item[title] = str_replace("Branx", "<em>Branx</em>", $item[title]);
        
        // add to dat new array
        $rss_shows_sorted[$item[pubDate]] = "<a href=\"$item[link]\" class=\"table-cell\">$item[title]</a>";
      }

      // sort new array, via leading timestamp keys
      ksort($rss_shows_sorted);

      // format timestamps to readable formats then print shows
      foreach ($rss_shows_sorted as $key => $item) {
        $shortdate = strtolower(date("M d", $key));
        $longdate = date("D, M j, Y", $key);
        echo "                <li class=\"table-row\"><div title=\"$longdate\" alt=\"$longdate\" class=\"table-cell\"><strong>$shortdate</strong></div>$item</li>\n";
      }
    } else {
      // couldn't load source feed, return error
      return "                <li><span class=\"error\">Could not load shows feed:</span><br />Please check your internet connection and/or configuration.</li>\n";
    }
  } else {
    // a necessary value was missing, return error
    return "                <li><span class=\"error\">Could not load shows feed:</span><br />No venues were provided in configuration.</li>\n";
  }
  echo "              </ul>";
}

function feedReddit($feed, $user, $limit) {
  // check if necessary values were passed
  if ($feed != false && $user != false) {
    // check if a history limit was specified
    if ($limit != false) {
      // if the history limit was set to over 100, default to 100,
      // and shame on you for not reading my configuration comments
      if ($limit > 100) {
        $limit = 100;
      }
    } else {
      // no limit was specified, default to 25
      $limit = 25;
    }
    
    // retrieve Reddit user profile
    $json_reddit_profile = file_get_contents("https://www.reddit.com/user/$user/about.json");

    // check if we could retrieve the source feed
    if ($json_reddit_profile != false) {
      // an array of the specific info tags we want to look for
      $redditTags = array("link_karma","comment_karma");

      // set up the iterator
      $jsonIterator = new RecursiveIteratorIterator(
          new RecursiveArrayIterator(json_decode($json_reddit_profile, TRUE)),
          RecursiveIteratorIterator::SELF_FIRST);

      // run through iterator array, parsing out specified tags
      foreach ($jsonIterator as $key => $val) {
        if ($key != "") {
          if (in_array($key, $redditTags)) {
            // differentiate between that sweet, sweet link and comment karma
            if ($key == "link_karma") { 
              $linkKarma = $val;
            } else {
              $commentKarma = $val;
            }
          }
        }
      }
      // print reddit username and karma count
      echo "              <h3>$user</h3> <span class=\"reddit-karma\">karma: <em title=\"$linkKarma link karma\" alt=\"$linkKarma link karma\">$linkKarma</em>/<em title=\"$commentKarma comment karma\" alt=\"$commentKarma comment karma\">$commentKarma</em></span>\n";
    }
    
    // retrieve Reddit user comment history
    $json_reddit_comments = file_get_contents("https://www.reddit.com/user/$user/.json?feed=$feed&user=$user&limit=$limit");

    // check if we could retrieve the source feed
    if ($json_reddit_comments != false) {
      // an array of the specific info tags we want to look for
      $redditTags = array("kind","domain","selftext_html","thumbnail","permalink","is_self","url","title","link_title","subreddit","gilded","score","controversiality","body_html","link_id","created_utc","num_comments");

      // set up the iterator
      $jsonIterator = new RecursiveIteratorIterator(
          new RecursiveArrayIterator(json_decode($json_reddit_comments, TRUE)),
          RecursiveIteratorIterator::SELF_FIRST);

      $json_reddit_sorted["items"] = array();
      $a = 0;
      
      // run through iterator array, parsing out specified tags
      // and adding them to a new, cleaner array
      foreach ($jsonIterator as $key => $val) {
        if ($key != "") {
          if (in_array($key, $redditTags)) {
            $json_reddit_sorted["items"][$a][$key] = $val;
          }
          // the last tag in a comment item's data seems to be the
          // "distinguished" tag, so we will use it a cue to increase
          // our counter
          if ($key == "distinguished") { 
            $a++;
          }
        }
      }

      foreach ($json_reddit_sorted["items"] as $item) {
        // format comment date
        $shortdate = date("m/d/y &#8594; g:iA", $item[created_utc]);
          
        // if history item is a comment
        if ($item[kind] == "t1") {
          // format link id so it's url-friendly
          $item[link_id] = str_replace("t3_", "", $item[link_id]);
          
          // format quotation marks in post title so they're html-friendly
          $item[link_title] = str_replace("\"", "&quot;", $item[link_title]);
          
          // do a little bit of crappy reddit-esque comment html formatting
          // and let us feel dishonor at the rudimentary way we are doing
          // it
          $item[body_html] = str_replace("&lt;", "<", $item[body_html]);    
          $item[body_html] = str_replace("&gt;", ">", $item[body_html]);
          $item[body_html] = str_replace("&amp;lt;", "&lt;", $item[body_html]);    
          $item[body_html] = str_replace("&amp;gt;", "&gt;", $item[body_html]);
          $item[body_html] = str_replace("&amp;#39;", "'", $item[body_html]);
          $item[body_html] = str_replace("&amp;quot;", "\"", $item[body_html]);
          $item[body_html] = str_replace("<em>", "<i>", $item[body_html]);
          $item[body_html] = str_replace("</em>", "</i>", $item[body_html]);
          $item[body_html] = str_replace("<strong>", "<b>", $item[body_html]);
          $item[body_html] = str_replace("</strong>", "</b>", $item[body_html]); 
          $item[body_html] = str_replace("<a href=\"/r/", "<a href=\"http://www.reddit.com/r/", $item[body_html]);
          $item[body_html] = str_replace("<a href=\"/u/", "<a href=\"http://www.reddit.com/u/", $item[body_html]);
          $item[body_html] = preg_replace("'(<div class=\"md\">|</div>)'si", "", $item[body_html]);

          // start to print the comment
          echo "              <a href=\"http://www.reddit.com/$item[link_id]\" title=\"$item[link_title]\" alt=\"$item[link_title]\" class=\"block reddit-title-link\"><span class=\"reddit-title\">$item[link_title]</span></a>\n";
          echo "              <ul>\n";
          echo "                <li class=\"table-row\">\n";
          echo "                  <div class=\"table-cell\">\n";
          
          // display appropriate arrow depending on karma score
          if ($item[score] > 0) {
            // received positive points
            echo "                    <span class=\"reddit-upvote\">&#11014;$item[score]</span><br />\n";
          } else {
            if ($item[score] == 0) {
              // received zero points
              echo "                    <span class=\"reddit-zerovote\">&#11021;$item[score]</span><br />\n";
            } else {
              // received negative points
              echo "                    <span class=\"reddit-downvote\">&#11015;$item[score]</span><br />\n";
            }
          }
          
          // if comment was controversial, show the Reddit Dagger of Controversy™
          if ($item[controversiality] == 1) {
            echo "                    <span title=\"Controversial submission\" alt=\"Controversial submission\" class=\"reddit-dagger\">&#8224;</span>\n";
          }
          
          // if comment was gilded, show us
          if ($item[gilded] > 0) {
            // if comment was gilded more than once, show how many times
            if ($item[gilded] > 1) {
              echo "                    <span title=\"Gifted gold for this submission\" alt=\"Gifted gold for this submission\" class=\"reddit-gold\"><span class=\"reddit-goldstar\">&#9733;</span>&times;$item[gilded]</span>\n";
            } else {
              echo "                    <span title=\"Gifted gold for this submission\" alt=\"Gifted gold for this submission\" class=\"reddit-goldstar\">&#9733;</span>\n";
            }
          }
          
          echo "                  </div>\n";
          echo "                  <span class=\"block\">$shortdate &#8594; /r/$item[subreddit]</span>\n";
          echo "                  <div class=\"table-row\"><span class=\"table-cell reddit-icon\">&#8627;</span><span class=\"table-cell reddit-comment\">$item[body_html]</span></div>\n";
          echo "                </li>\n";
          echo "              </ul>\n";
        }
        
        // if history item is a link or self post
        if ($item[kind] == "t3") {
          // format quotation marks in post title so they're html-friendly
          $item[title] = str_replace("\"", "&quot;", $item[title]);
          
          // sort out our post thumbnails
          if ($item[thumbnail] == "self") {
            // post is a self-post
            $imageThumbnail = "<img src=\"http://i.imgur.com/fYM6L7b.png\" class=\"post-link\">";
          } else {
            if ($item[thumbnail] == "" || $item[thumbnail] == "default") {
              // post thumbnail is unavailable or default
              $imageThumbnail = "<img src=\"http://i.imgur.com/jG23lud.png\" class=\"post-link\">";
            } else {
              // post has a user content thumbnail
              $imageThumbnail = "<img src=\"$item[thumbnail]\" class=\"post-link\">";
            }
          }
          
          // check for post comments, and properly format our plurals
          $commentCount = "";
          if ($item[num_comments] != 0) {
            if ($item[num_comments] > 1) {
              $commentCount = "<br />&#8594; <a href=\"http://www.reddit.com$item[permalink]\"><em>$item[num_comments]</em> comments</a>";
            } else {
              $commentCount = "<br />&#8594; <a href=\"http://www.reddit.com$item[permalink]\"><em>$item[num_comments]</em> comment</a>";
            }
          }
          
          // start to print the post
          echo "              <a href=\"http://www.reddit.com$item[permalink]\" title=\"$item[title]\" alt=\"$item[title]\" class=\"block reddit-title-link\"><span class=\"reddit-title\">$item[title]</span></a>\n";
          echo "              <ul>\n";
          echo "                <li class=\"table-row\">\n";
          echo "                  <div class=\"table-cell\">\n";
          
          // display appropriate arrow depending on karma score
          if ($item[score] > 0) {
            // received positive points
            echo "                    <span class=\"reddit-upvote\">&#11014;$item[score]</span><br />\n";
          } else {
            if ($item[score] == 0) {
              // received zero points
              echo "                    <span class=\"reddit-zerovote\">&#11021;$item[score]</span><br />\n";
            } else {
              // received negative points
              echo "                    <span class=\"reddit-downvote\">&#11015;$item[score]</span><br />\n";
            }
          }
          
          // if post was controversial, show the Reddit Dagger of Controversy™
          if ($item[controversiality] == 1) {
            echo "                    <span title=\"Controversial submission\" alt=\"Controversial submission\" class=\"reddit-dagger\">&#8224;</span>\n";
          }
          
          // if post was gilded, show us
          if ($item[gilded] > 0) {
            // if post was gilded more than once, show how many times
            if ($item[gilded] > 1) {
              echo "                    <span title=\"Gifted gold for this submission\" alt=\"Gifted gold for this submission\" class=\"reddit-gold\"><span class=\"reddit-goldstar\">&#9733;</span>&times;$item[gilded]</span>\n";
            } else {
              echo "                    <span title=\"Gifted gold for this submission\" alt=\"Gifted gold for this submission\" class=\"reddit-goldstar\">&#9733;</span>\n";
            }
          }
          
          echo "                  </div>\n";
          echo "                  <span class=\"block\">$shortdate &#8594; /r/$item[subreddit]</span>\n";
          echo "                  <div class=\"table-row\"><div class=\"table-row\"><span class=\"table-cell reddit-icon\"><a href=\"$item[url]\">$imageThumbnail</a></span><span class=\"table-cell reddit-post\">($item[domain])$commentCount</span></div></div>\n";
          
          // if the post is a self/text post, we also want to print the
          // text it contained
          if ($item[is_self] == "true") {
            // again with the crappy formatting
            $item[selftext_html] = str_replace("&lt;", "<", $item[selftext_html]);
            $item[selftext_html] = str_replace("&gt;", ">", $item[selftext_html]);
            $item[selftext_html] = str_replace("&amp;lt;", "&lt;", $item[selftext_html]);    
            $item[selftext_html] = str_replace("&amp;gt;", "&gt;", $item[selftext_html]);
            $item[selftext_html] = str_replace("&amp;#39;", "'", $item[selftext_html]);
            $item[selftext_html] = str_replace("&amp;quot;", "\"", $item[selftext_html]);
            $item[selftext_html] = str_replace("<em>", "<i>", $item[selftext_html]);
            $item[selftext_html] = str_replace("</em>", "</i>", $item[selftext_html]);
            $item[selftext_html] = str_replace("<strong>", "<b>", $item[selftext_html]);
            $item[selftext_html] = str_replace("</strong>", "</b>", $item[selftext_html]);
            $item[selftext_html] = str_replace("<a href=\"/r/", "<a href=\"http://www.reddit.com/r/", $item[selftext_html]);
            $item[selftext_html] = str_replace("<a href=\"/u/", "<a href=\"http://www.reddit.com/u/", $item[selftext_html]);
            $item[selftext_html] = preg_replace("'(<!-- SC_ON -->|<!-- SC_OFF -->|<div class=\"md\">|</div>)'si", "", $item[selftext_html]);
          
            // print the self text
            echo "                  <div class=\"table-row\"><div class=\"table-row\"><span class=\"table-cell reddit-icon\">&#8627;</span><span class=\"table-cell reddit-comment\">$item[selftext_html]</span></div></div>\n";
          }

          echo "                </li>\n";
          echo "              </ul>\n";
        }
      }
    } else {
      // couldn't load source feed, return error
      return "                <span class=\"error\">Could not load reddit feed:</span><br />Please check your internet connection and/or configuration.\n";
    }
  } else {
    // a necessary value was missing, return error
    return "                <span class=\"error\">Could not load reddit feed:</span><br />No feed key and/or username were provided in configuration.\n";
  }
}
?>
