###jezebel/homepage

---

![homepage](https://github.com/heru-ra/jezebel/blob/master/homepage/screenshot.png "homepage")

---

##11/01/2014

**CSS**
+ Organized and cleaned up ./css/style.css, making alterations and additions  
  to style any new elements and features  
+ Changed border radius and color on a few elements, to reflect  
  changes made in my local theme

**JS/JQUERY**
+ Added isExternal(url) function to check if feed urls are internal or  
  external domain sources  
+ Recoded the search bar function searchSubmit(form) for increased  
  flexibility, and to use a new search engine dropdown attributes and  
  specifications  
  + Added quick-search engine scheme name support (see comments on  
    line 24 of ./index.php for more info)  
  + Search engines can now be specified to submit using GET (instead  
    of POST) via the data-method="GET" attribute setting  
  + Last search engine now recalled via cookie  
+ Added tabsAlign() function so that feed tabs automatically align  
  themselves, no longer requiring manual adjustment when col height is  
  altered  
+ Added feedError(title,text) function to handle and display feed  
  errors  
+ Added loadFeed(name,url,customerror) function, used by tabs, to  
  handle the loading of associated feeds to the feed iframe, apply  
  all dynamic styling changes, set recall cookies, process custom  
  errors for temperamental feeds, and apply loading overlays  
  + Added ./img/ajax-loader.gif as a feed loading animation overlay  
+ Added loadFeedChromeCheck(name,url,customerror) as a workaround  
  for some quirks and inconsistencies with error displays in Chromium  
  and dwb. Works as a frontend to loadFeed()  
+ Added $(window).resize() function, to call tabsAlign() if browser  
  dimensions change  
+ Added functions to $(document).ready() to automatically adjust  
  #col-1 row heights and alignment (./js/scripts.js line 175) and adjust  
  #iframe-scratchpad height equal to it's contents (./js/scripts.js line  
  185)
  
**PHP**
+ Moved all ./index.php settings variables to their own ./settings.php  
  file, for easier inclusion in other files  
  + Added $time24hr var to adjust time display between 12 and 24 hour  
    formats  
  + Added $dateFormat var to adjust date formats to either DMY, YMD,  
    or MDY  
  + Added $weatherCacheTime var to set refresh rate of the weather  
    feed data  
  + Added $tabs array, which is used in the new tab generation system,  
    to create, delete, or edit tab names and feed URLs  
  + Added $tabsCustomLoadErrors array, used to set special custom  
    errors intended to be applied in conjunction with tabs/feeds  
    hosted on external domains (see comments on line 42 of ./settings.php)  
  + Added $showsCacheTime var to set refresh rate of the shows feed data  
  + Added $scratchRows var to adjust the height of the scratchpad  
    textarea  
+ Added detectTabCookie($cookievalue, $tabarray, $customerrors)  
  function to help us handle the loading of the last tab visited  
+ Added generateTabs($tabarray, $customerrors) function to handle the  
  automatic generation of feed tabs specified in the $tabs array  
  of ./settings.php  
+ Created workaround for bug where blank lastRSS results were being  
  cached while there was no internet connection (see comments on  
  line 160 of ./plugins/functions.php)  
+ Tabbed feeds now load on demand from individual local .php files  
  (./feeds) or external URLS, into the #iframe-feed-tabbed iframe, thus  
  speeding up initial homepage load times and making feed system more  
  flexible  
+ Added Reddit feed links to user overview and to submission sub-reddits  
+ Replaced various unicode arrows and other symbols with their  
  equivalent (HTML-friendly) numeric character references  
+ Cleaned up and altered bits and pieces of code in both ./index.php  
  and ./plugins/functions.php to accomodate new features and functions,  
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
