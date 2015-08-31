<?php
$filename = $argv[1];
$f = fopen($filename,"r");
$m = fopen('encoded.csv',"w");
while ($line = fgets($f)) {
  fwrite($m,md5(trim($line,"\n"))."\n");
}
