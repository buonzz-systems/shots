<?php

date_default_timezone_set("Asia/Manila");

// sample : php index.php admin password 192.168.1.109 81

$HOST = $argv[3];
$PORT =$argv[4];
$USERNAME = $argv[1];
$PASSWORD  = $argv[2];

$url = "http://" . $HOST . ":" . $PORT . "/snapshot.cgi?user=" . $USERNAME . "&pwd=" . $PASSWORD  . "&" . rand(1,1000);

download_image($url, "images/". date("y-m-d-his") . ".jpg");

function download_image($image_url, $image_file){
    $fp = fopen ($image_file, 'w+');             

    $ch = curl_init($image_url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // enable if you want
    curl_setopt($ch, CURLOPT_FILE, $fp);          // output to file
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1000);      // some large value to allow curl to run for a long time
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_VERBOSE, true);   // Enable this line to see debug prints
    curl_exec($ch);

    curl_close($ch);                              // closing curl handle
    fclose($fp);                                  // closing file handle
}