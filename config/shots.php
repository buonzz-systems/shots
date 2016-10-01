<?php

return [

    'cameras' => [
        array('hostname'=> '192.168.1.104', 
              'username' => 'admin', 
              'password' => env('DEFAULT_CAMERA_PASSWORD', 'pass'),
              'port' => 81),
        array('hostname'=> '192.168.1.106', 
              'username' => 'admin', 
              'password' => env('DEFAULT_CAMERA_PASSWORD', 'pass'),
              'port' => 81)
    ]
];
