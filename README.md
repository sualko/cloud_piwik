# Piwik/Matomo for your Cloud
Track [Nextcloud](https://nextcloud.com) users with [Piwik/Matomo](https://matomo.org).

## Requirements
- Nextcloud >= 11
- Working Piwik/Matomo installation (tested with 2.14.3)
- Empty custom variable slots on index 1, 2 and 3

## What will be tracked?
- Normal Piwik/Matomo stuff (url, page title, browser, ...)
- User ID aka Owncloud user
- App in first custom variable
- Share ID in second custom variable (<code>index.php/s/SHARE_ID</code>)
- Share ID + folder or file name in third custom variable

## What will not be tracked?
- Download
- Outlink

## Installation
- Download and extract to <code>CLOUD_DIR/apps/piwik/</code>
- Enable app
- If needed create a new site in your Piwik/Matomo installation
- Insert Piwik/Matomo site id and url on the cloud admin page (e.g. site id: <code>1</code>, url: <code>//domain.tld/piwik/</code>)
- If Piwik/Matomo is hosted under a different domain as your cloud you maybe need to use one of two possible proxy methods:
 - Add <code>RewriteRule "^piwik/(.*)$" "http://piwik.tld/$1" [P]</code> to your <code>.htaccess</code>
 - a2enmod proxy
 - Add <code>ProxyPass /piwik/ http://piwik.tld/</code> to your apache VirtualHost section
