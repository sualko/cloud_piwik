/* global OC, oc_debug */

var _paq = _paq || [];

(function() {
   "use strict";

   var piwik;

   if (typeof localStorage !== 'undefined') {
      var piwikString = localStorage.getItem('piwik');

      try {
         piwik = JSON.parse(piwikString);
      } catch (err) {}
   }

   if (piwik && (piwik.validUntil || 0) > (new Date()).getTime() && !oc_debug) {
      // use cached options
      track(piwik);
   } else {
      // load options
      $.ajax({
            method: 'GET',
            url: OC.generateUrl('apps/piwik/settings'),
         })
         .done(function(response) {
            var data = response ? response.data : {};

            if (data.siteId && data.url) {
               data.validUntil = (new Date()).getTime() + (data.validity * 1000);

               localStorage.setItem('piwik', JSON.stringify(data));

               track(data);
            }
         });
   }

   function track(options) {
      var app = null;
      var path = window.location.pathname;
      var pathparts = path.match(/index\.php\/apps\/([a-z0-9]+)\/?/i) || path.match(/index\.php\/([a-z0-9]+)(\/([a-z0-9]+))?/i) || [];

      if (pathparts.length >= 2) {
         app = pathparts[1];

         if (app === 's') {
            // rewrite app name
            app = 'share';

            var sharevalue = $('input[name="filename"]').val();

            if (sharevalue) {
               sharevalue = pathparts[3] + ' (' + sharevalue + ')';

               // save share id + share name in slot 3
               _paq.push(['setCustomVariable', '3', 'ShareNodes', sharevalue, 'page']);
            } else {
               sharevalue = pathparts[3];
            }

            // save share id in slot 2
            _paq.push(['setCustomVariable', '2', 'Shares', pathparts[3], 'page']);
         }

         // save app name in slot 1
         _paq.push(['setCustomVariable', '1', 'App', app, 'page']);
      }

      if (OC && OC.currentUser) {
         // set user id
         _paq.push(['setUserId', OC.currentUser]);
      }

      if (options.trackDir === 'on') {
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
   }
}());
