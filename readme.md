# Shots

A PHP application to upload images captured by your Sricam CCTV Camera

## Installation

Clone the repo to your server

```
git clone https://github.com/buonzz-systems/shots.git shots.domain.com
cd shots.domain.com
composer install
chmod -R 777 storage
```

adjust the env
```
cp .env.example .env
```

adjust the camera IP and settings

```
vi config/shots.php
```


setup the virtualhost by creating file in `/etc/nginx/sites-available/shots.domain.com`

```
server {
  server_name shots.domain.com;
 
  root /home/shots.domain.com/public;
 
  access_log /var/log/nginx/shots.domain.com.access.log;
 
  index index.php index.html index.htm;
 
  location / {
      try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    try_files $uri =404;
    fastcgi_pass unix:/var/run/php5-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
  }

  # serve static files directly
  location ~* \.(jpg|jpeg|gif|css|png|js|ico|html)$ {
    access_log off;
    expires max;
  }
 
  location ~ /\.ht {
    deny  all;
  }
}
```

add it to enabled sites

```
sudo ln -s /etc/nginx/sites-available/shots.buonzz.com /etc/nginx/sites-enabled/shots.buonzz.com
```