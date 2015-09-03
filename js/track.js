/*!
 * Piwik Tracking
 * 
 * Copyright (c) 2015 Klaus Herberth <klaus@jsxc.org> <br>
 * Released under the MIT license
 * 
 * @author Klaus Herberth <klaus@jsxc.org>
 * @license MIT
 */

var _paq = _paq || [];

(function() {
   "use strict";
   
   var piwik = (typeof localStorage !== 'undefined') ? OC.localStorage.getItem('piwik') : null;
   
   if (piwik && (piwik.validUntil || 0) >  (new Date()).getTime() / 1000 && !oc_debug) {
      track(piwik.siteId, piwik.url);
   } else {
      OC.AppConfig.getValue('piwik', 'piwik', {}, function(piwik) {
         piwik = JSON.parse(piwik);
         
         if (piwik.siteId && piwik.url) {
            piwik.validUntil = (new Date()).getTime() + (piwik.validity * 1000);
            
            OC.localStorage.setItem('piwik', piwik);

            track(piwik.siteId, piwik.url);
         }
      });
   }
   
   function track(siteId, url) {
      var app = null;
      var path = window.location.pathname;
      var pathparts = path.match(/index\.php\/apps\/([a-z0-9]+)\/?/i) || path.match(/index\.php\/([a-z0-9]+)(\/([a-z0-9]+))?/i);

      if(pathparts.length >= 2) {
         app = pathparts[1];
         
         if (app === 's') {
            app = 'share';
            
            _paq.push(['setCustomVariable','2','Shares', pathparts[3], 'page']);
         }
         
         _paq.push(['setCustomVariable','1','App', app, 'page']);
      }

      if (OC && OC.currentUser) {
         _paq.push(['setUserId', OC.currentUser]);
      }

      //_paq.push(['setDownloadClasses', ['action-download', 'piwik_download']]);
      // _paq.push(['enableLinkTracking']);

      _paq.push(['setTrackerUrl', url+'piwik.php']);
      _paq.push(['setSiteId', siteId]);

      $(function(){
         _paq.push(['trackPageView']);
      });

      if (typeof Piwik === 'undefined') {
         var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
         g.type='text/javascript'; g.async=true; g.defer=true; g.src=url+'piwik.js'; s.parentNode.insertBefore(g,s);
      }
   }
}());
