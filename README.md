# owncloud_piwik
Track owncloud users with [Piwik](https://piwik.org).

## Requirements
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
