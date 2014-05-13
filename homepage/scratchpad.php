<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <script src="/js/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/scripts.js"></script>
  </head>
  <body style="padding: 0!important">
    <div id="id-iframe-wrapper" class="iframe-wrapper">
<?php
// if scratchpad form submitted, write textarea contents to file
if(array_key_exists('scratchpad', $_POST)) {
  $file_open = fopen("scratchpad","w+");
  fwrite($file_open, $_POST['scratchpad']);
  fclose($file_open);
}
?>
      <form action="<?=$PHP_SELF?>" method="POST">
        <textarea name="scratchpad" rows=6 class="scratchpad"><?php
// open scratchpad file and print contents in textarea
$textfile = file ("scratchpad");
foreach ($textfile as $line) {
  echo $line;
}
?></textarea>    
        <div class="label-h">
          <h1>scratchpad</h1>
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
  </body>
</html>
