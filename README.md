# SnipeIT
This plugin will display the Asset-Tag of the device, if it can find a device with the same serial number in snipe-it.


## Install
Copy the plugin to `app/Plugins/snipeit` of your LibreNMS installation.


## Configure

add these 2 config entries:

```
$config['snipeit']['api_host'] = "snipeit.example.com";
$config['snipeit']['api_token'] = "SUPERSECRETTOKEN";

```
