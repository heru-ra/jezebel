###jezebel/homepage

---

![homepage](https://github.com/heru-ra/jezebel/blob/master/homepage/screenshot.png "homepage")

---

##11/01/2014

**CSS**
+ Organized and cleaned up [./css/style.css](https://github.com/heru-ra/jezebel/blob/master/homepage/css/style.css), making alterations and additions  
  to style any new elements and features  
+ Changed border radius and color on a few elements, and webkit scrollbar  
  styles to reflect changes made in my local theme

**JS/JQUERY**
+ Added [isExternal(url)](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L20-L26) function to check if feed urls are internal or  
  external domain sources  
+ Recoded the search bar function [searchSubmit(form)](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L29-L54) for increased  
  flexibility, and to use new search engine dropdown attributes and  
  specifications  
  + Added quick-search engine scheme name support (see comments on  
    [line 24 of ./index.php](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php#L24-L33) for more info)  
  + Search engines can now be specified to submit using GET (instead  
    of POST) via the [data-method="GET"](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php#L29) attribute setting  
  + Last search engine now recalled via cookie  
+ Added [tabsAlign()](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L57-L66) function so that feed tabs automatically align  
  themselves, no longer requiring manual adjustment when col height is  
  altered  
+ Added [feedError(title,text)](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L69-L74) function to handle and display feed  
  errors  
+ Added [loadFeed(name,url,customerror)](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L77-L132) function, used by tabs, to  
  handle the loading of associated feeds to the feed iframe, apply  
  all dynamic styling changes, set recall cookies, process custom  
  errors for temperamental feeds, and apply loading overlays  
  + Added [./img/ajax-loader.gif](https://github.com/heru-ra/jezebel/blob/master/homepage/img/ajax-loader.gif) as a feed loading animation overlay  
+ Added [loadFeedChromeCheck(name,url,customerror)](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L135-L151) as a workaround  
  for some quirks and inconsistencies with error displays in Chromium  
  and dwb. Works as a frontend to [loadFeed()](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L77-L132)  
+ Added [$(window).resize()](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L154-L158) function, to call [tabsAlign()](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L57-L66) if browser  
  dimensions change  
+ Added functions to [$(document).ready()](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L161-L190) to automatically adjust  
  [#col-1-row-X](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php#L39-L81) heights and alignment ([./js/scripts.js line 175](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L175-L178)) and adjust  
  [#iframe-scratchpad](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php#L98) height equal to it's contents ([./js/scripts.js line  
  185](https://github.com/heru-ra/jezebel/blob/master/homepage/js/scripts.js#L185-L189))
  
**PHP/HTML**
+ Moved all [./index.php](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php) settings variables to their own [./settings.php](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php)  
  file, for easier inclusion in other files  
  + Added [$time24hr](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L2-L3) var to adjust time display between 12 and 24 hour  
    formats  
  + Added [$dateFormat](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L4-L8) var to adjust date formats to either DMY, YMD,  
    or MDY  
  + Added [$weatherCacheTime](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L29-L31) var to set refresh rate of the weather  
    feed data  
  + Added [$tabs](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L33-L40) array, which is used in the new tab generation system,  
    to create, delete, or edit tab names and feed URLs  
  + Added [$tabsCustomLoadErrors](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L42-L50) array, used to set special custom  
    errors intended to be applied in conjunction with tabs/feeds  
    hosted on external domains (see comments on [line 42 of ./settings.php](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L42-L50))  
  + Added [$showsCacheTime](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L76-L80) var to set refresh rate of the shows feed data  
  + Added [$scratchRows](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L82-L84) var to adjust the height of the scratchpad  
    textarea  
+ Added [detectTabCookie($cookievalue, $tabarray, $customerrors)](https://github.com/heru-ra/jezebel/blob/master/homepage/plugins/functions.php#L10-L56)  
  function to help us handle the loading of the last tab visited  
+ Added [generateTabs($tabarray, $customerrors)](https://github.com/heru-ra/jezebel/blob/master/homepage/plugins/functions.php#L58-L82) function to handle the  
  automatic generation of feed tabs specified in the [$tabs](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php#L33-L40) array  
  of [./settings.php](https://github.com/heru-ra/jezebel/blob/master/homepage/settings.php)  
+ Created workaround for bug where blank [lastRSS](https://github.com/heru-ra/jezebel/blob/master/homepage/plugins/lastRSS.php) results were being  
  cached while there was no internet connection (see comments on  
  [line 160 of ./plugins/functions.php](https://github.com/heru-ra/jezebel/blob/master/homepage/plugins/functions.php#L160-L166))  
+ Tabbed feeds now load on demand from individual local .php files  
  ([./feeds](https://github.com/heru-ra/jezebel/tree/master/homepage/feeds)) or external URLS, into the [#iframe-feed-tabbed](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php#L90) iframe, thus  
  speeding up initial homepage load times and making feed system more  
  flexible  
+ Added Reddit feed links to user overview and to submission sub-reddits  
+ Replaced various unicode arrows and other symbols with their  
  equivalent (HTML-friendly) numeric character references  
+ Cleaned up and altered bits and pieces of code in both [./index.php](https://github.com/heru-ra/jezebel/blob/master/homepage/index.php)  
  and [./plugins/functions.php](https://github.com/heru-ra/jezebel/blob/master/homepage/plugins/functions.php) to accomodate new features and functions,  
  increase flexibility and compatibility, and make room for growth
  
**NOTES**

As always, this is a work in progress, and even though I try to do  
extensive bug testing using Iceweasel, Chromium, and dwb, I very  
well may have missed something -- if you run across any bugs, please  
submit the issue, or troubleshoot them yourself and then submit a code  
alteration

---

##10/06/2014

+ Added calendar feed, that makes use of Google Calendar
+ Fixed Reddit karma score handling
+ Fixed a few Reddit thumbnail and link-handling bugs
+ Added Reddit controversy dagger and gilding display
+ Tweaked Reddit feed style and layout
+ Tweaked shows feed, so mouse-over show date displays more detail
+ Added cookie support, to remember and recall last feed/tab visited
+ Expanded color pallette of some feeds, to reflect system colors
+ Cleaned up some code

---

##05/12/2014

**A COUPLE THINGS TO NOTE**

Both the "cache" folder and the "scratchpad" file must be given  
CHMOD 777 permissions, so they can be written to properly.

My source uses curl and json routines, so make sure you have the  
according php5 packages installed

There are configuration variables that need to be set within  
the ./index.php source. They are at the very top, and are commented  
for your understanding and convenience.

All the interesting stuff you may want to modify and tweak  
will probably be in ./plugins/functions.php and also have  
been detailedly commented.

I have slightly modified the LastRSS plugin, and all  
modifications are noted at the top of the plugin file  
source itself.

This homepage was designed for use with Firefox/Iceweasel. I  
have done my best to bug test with Chromium, and added a few  
hacks so that it works (and looks) as fluidly as possible.

Other webkit-based browsers seem to be hit or miss; for instance,  
dwb displays flawlessly, while surf still wants to cut off some of  
the scrollbar in our scratchpad when it overflows. Most issues you  
may encounter can probably be remedied by minor margin/padding  
tweaks in ./css/style.css.

As always, this will continue to be a WIP and I will most likely  
push more update commits in future.
