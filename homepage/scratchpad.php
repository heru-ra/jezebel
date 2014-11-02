<?php
  include "./plugins/functions.php";
  include "./settings.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="/css/style.css">
  </head>
  <body style="padding: 0!important">
    <div id="scratchpad-wrapper" class="scratchpad-wrapper">
<?php
  // if scratchpad form submitted, write textarea contents to file
  if(array_key_exists('scratchpad', $_POST)) {
    $file_open = fopen("scratchpad","w+");
    fwrite($file_open, $_POST['scratchpad']);
    fclose($file_open);
}
?>
      <form action="<?=$PHP_SELF?>" method="POST">
        <textarea name="scratchpad" rows=<?php
  // set row height to user supplied value
  if ($scratchRows != false && is_int($scratchRows)) {
    echo $scratchRows;
  } else {
    // no value or proper value supplied, default to 6 rows
    echo "6";
  }
?> class="scratchpad"><?php
  // open scratchpad file and print contents in textarea
  $textfile = file ("scratchpad");
  foreach ($textfile as $line) {
    echo $line;
}
?></textarea>    
        <div class="label-horiz">
          <h1>scratchpad</h1>
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
    <script src="/js/jquery/1.11.0/jquery.min.js"></script>
    <script src="/js/scripts.js"></script>
  </body>
</html>
