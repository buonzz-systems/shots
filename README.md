# Shots

A PHP script to upload images captured by your Sricam CCTV Camera

## Requirements

* PHP >= 5
* vsftpd
* Ubuntu 14


##  Installation



### FTP Server
You need to setup first the FTP server so it can accept passive mode connection. To do this:

edit config file by 

```
sudo vi /etc/vsftpd.conf 
```

then make sure the following values matches up in the server

```
file_open_mode=777
local_umask=002
pasv_enable=YES
pasv_max_port=12050
pasv_min_port=12000
port_enable=YES
pasv_address=<your servers ip address>
anonymous_enable=NO
local_enable=YES
write_enable=YES

```

Open ports to allow passive mode
```
sudo ufw allow 12000:12050/tcp
``` 

Make sure you open those range as well in your firewall


### Monitoring Server

This should be the computer that is able to access the camera via LAN.
In your local computer, use the following syntax to capture image from camera and upload it to your ftp server

```
php index.php admin yourpass 192.168.1.106 81 ftp_host ftp_user ftp_pass  "/ftp_folder/location"
```

change the values above with appropriate one.


### Schedule the capture process in cron tab

create a run.sh file with the following contents:
```
/usr/bin/php pathto_repo/shots/index.php admin yourpass 192.168.1.106 81 ftp_host ftp_user ftp_pass  "/ftp_folder/location"
```
change values accordingly

then enter the following in your cron tab
```
crontab -e
```
input the following as new line
```
* * * * *  bash pathto_repo/shots/run.sh
```

it will now capture image from your cam and upload it to your server