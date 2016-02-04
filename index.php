<?php

date_default_timezone_set("Asia/Manila");

// sample : php index.php admin password 192.168.1.104 81 ftp_host ftp_user ftp_pass "/home/folder"

$HOST = $argv[3];
$PORT = $argv[4];
$USERNAME = $argv[1];
$PASSWORD  = $argv[2];
$ftp_host = $argv[5];
$ftp_user = $argv[6];
$ftp_pass = $argv[7];
$ftp_base_folder = $argv[8];

$url = "http://" . $HOST . ":" . $PORT . "/snapshot.cgi?user=" . $USERNAME . "&pwd=" . $PASSWORD  . "&" . rand(1,1000);

$filename =  date("y-m-d-his") . ".jpg";
$local_filename = "images/". $filename;

// download first from cam
download_image($url, $local_filename);

// upload to file server
upload_file($ftp_host, $ftp_user, $ftp_pass, $ftp_base_folder, $filename);

/*
* utility functions
*/

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

function upload_file($ftp_server, $ftp_user_name, $ftp_user_pass, $ftp_base_folder, $file){
    $remote_file =  $ftp_base_folder . '/' . $file;
    $local_file = 'images/'.$file;

    // set up basic connection
    $conn_id = ftp_connect($ftp_server);

    // login with username and password
    $login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

    ftp_pasv($conn_id, true);
    
    // upload a file
    if (ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY)) {
      echo "successfully uploaded $file\n";
      unlink($local_file);
    } else {
     echo "There was a problem while uploading $file\n";
    }

    // close the connection
    ftp_close($conn_id);    
}


