<?php



  $dt = new DateTime($item->created_at);
  $tz = new DateTimeZone('Asia/Dhaka');

$dt->setTimezone($tz);
echo $dt->format('F j, Y, g:i a');  // output:   June 11, 2020, 1:39 pm