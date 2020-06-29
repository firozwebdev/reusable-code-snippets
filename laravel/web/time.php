<?php



  $dt = new DateTime($item->created_at);
  $tz = new DateTimeZone('Asia/Dhaka');

   $dt->setTimezone($tz);
echo $dt->format('F j, Y, g:i a');  // output:   June 11, 2020, 1:39 pm

// by default in laravel created_at, updated_at , these two columns is formated as a date not string, thats why
//we can apply format method

{{ $item->created_at->format('m/d/Y') }}

//function inside model

public function getTime()
{
    $dt = new DateTime($this->created_at);
    $tz = new DateTimeZone('Asia/Dhaka');

    $dt->setTimezone($tz);
    return $dt->format('F j, Y, g:i a');
}