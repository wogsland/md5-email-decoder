<?php
$start = time();

if (isset($argv[1])) {
  //get the encoded emails
  $filename = $argv[1];
  $f = fopen($filename,"r");
  $codes = array();
  while ($line = fgets($f)) {
    $codes[] = trim($line,"\n");
  }

  //setup optional write file
  if (isset($argv[2])) {
    $filename = $argv[2];
    $solved = fopen($filename,"w");
  }
  $emails = array();
  $count_codes = count($codes);
  while (count($emails) < $count_codes) {
    echo "after ".($sec = time()-$start)." ".count($emails)." hits on ".$count_codes;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.';
    $string = '';
    $random_string_length = rand(1,5);
    for ($i = 0; $i < $random_string_length; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    $test = $string."@gmail.com";
    echo ": trying $test\n";
    foreach ($codes as $k => $code) {
      if (md5($test) == $code) {
        $i = count($emails);
        $emails[$i]['code'] = $code;
        $emails[$i]['decode'] = $test;
        $emails[$i]['time'] = $sec;
        if (isset($solved)) {
          fwrite($solved,"$code $test $sec\n");
        }
        unset($codes[$k]);
      }
    }
  }
  print_r($emails);
} else {
  echo "usage:
        php decode.php file_to_decode
        php decode.php file_to_decode file_to_store_decodes\n";
}
