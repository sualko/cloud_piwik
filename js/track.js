/* global OC, oc_debug */

var _paq = _paq || [];

(function() {
   "use strict";

   var options;

   try {
      options = JSON.parse('%OPTIONS%');
   } catch (err) {}

   if (!options || !options.url || !options.siteId) {
      return;
   }

   if (options.url[options.url.length - 1] !== '/') {
      options.url += '/';
   }

   var app = null;
   var path = window.location.pathname;
   var pathParts = path.match(/(?:index\.php\/)?apps\/([a-z0-9]+)\/?/i) || path.match(/(?:index\.php\/)?([a-z0-9]+)(\/([a-z0-9]+))?/i) || [];

   if (pathParts.length >= 2) {
      app = pathParts[1];

      if (app === 's') {
         // rewrite app name
         app = 'share';

         var shareValue = $('input[name="filename"]').val();

         if (shareValue) {
            shareValue = pathParts[3] + ' (' + shareValue + ')';

            // save share id + share name in slot 3
            _paq.push(['setCustomVariable', '3', 'ShareNodes', shareValue, 'page']);
         } else {
            shareValue = pathParts[3];
         }

         // save share id in slot 2
         _paq.push(['setCustomVariable', '2', 'Shares', pathParts[3], 'page']);
      }

      // save app name in slot 1
      _paq.push(['setCustomVariable', '1', 'App', app, 'page']);
   }

   if (OC && OC.currentUser && options.trackUser) {
      // set user id
      _paq.push(['setUserId', OC.currentUser]);
   }

   if (options.trackDir === 'on' || options.trackDir === true) {
      // track file browsing

      $('#app-content').delegate('>div', 'afterChangeDirectory', function() {
         // update title and url for next page view
         _paq.push(['setDocumentTitle', document.title]);
         _paq.push(['setCustomUrl', window.location.href]);
         _paq.push(['trackPageView']);
      });
   }

   // set piwik options
   _paq.push(['setTrackerUrl', options.url + 'piwik.php']);
   _paq.push(['setSiteId', options.siteId]);

   if (app !== 'files' || options.trackDir !== 'on') {
      // track page view
      _paq.push(['trackPageView']);
   }

   if (typeof Piwik === 'undefined') {
      // load piwik library
      var d = document,
         g = d.createElement('script'),
         s = d.getElementsByTagName('script')[0];
      g.type = 'text/javascript';
      g.async = true;
      g.defer = true;
      g.src = options.url + 'piwik.js';
      s.parentNode.insertBefore(g, s);
   }
}());
