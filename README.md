# owncloud_piwik
Track [owncloud](https://owncloud.org) users with [Piwik](https://piwik.org).

## Requirements
- Owncloud >= 8
- Working piwik installation (tested with 2.14.3)
- Empty custom variable slots on index 1 and 2

## What will be tracked?
- Normal piwik stuff (url, page title, browser, ...)
- User ID aka Owncloud user
- App in first custom variable
- Share ID in second custom variable (<code>index.php/s/SHARE_ID</code>)

## What will not be tracked?
- Download
- Outlink
- File directory

## Installation
- Download and extract to <code>OWNCLOUD_DIR/apps/piwik/</code>
- Enable app
- If needed create a new site in your piwik installation
- Insert piwik site id and url on the owncloud admin page (e.g. site id: <code>1</code>, url: <code>//domain.tld/piwik/</code>)
- If you are using owncloud 8 and piwik is hosted under a different domain as owncloud you need to use one of two possible proxy methods:
 - Add <code>RewriteRule "^piwik/(.*)$" "http://piwik.tld/$1" [P]</code> to your <code>.htaccess</code>
 - Add <code>ProxyPass /piwik/ http://piwik.tld/</code> to your apache VirtualHost section
