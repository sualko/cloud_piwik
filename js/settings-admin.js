/* global OC */

$(function() {
   OC.AppConfig.getValue('piwik', 'piwik', {}, function(piwik) {
      if (piwik) {
        try {
          piwik = JSON.parse(piwik);
        } catch(err) {}
      }
      piwik = piwik || {};

      $('#piwikSiteId').val(piwik.siteId);
      $('#piwikUrl').val(piwik.url);
   });

   $('#piwikUrl').attr('placeholder', 'e.g. //' + window.location.host + '/piwik/');

   $('#piwikSettings input[type="text"]').change(function() {
      var piwik = {};

      piwik.siteId = $('#piwikSiteId').val();
      piwik.url = $('#piwikUrl').val();
      piwik.validity = 60 * 60 * 24;

      if (!piwik.url.match(/\/$/)) {
         piwik.url += '/';
      }

      OC.AppConfig.setValue('piwik', 'piwik', JSON.stringify(piwik));
   });

   OC.AppConfig.getValue('piwik', 'internal', false, function(internal) {
      $('#piwikInternal').prop('checked', internal === 'yes');
   });

   $('#piwikInternal').change(function() {
      OC.AppConfig.setValue('piwik', 'internal', $('#piwikInternal').prop('checked') ? 'yes' : 'no');
   });
});
