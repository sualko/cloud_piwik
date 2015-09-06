/*!
 * owncloud_piwik v0.1.0 - 2015-09-06
 * 
 * Copyright (c) 2015 Klaus Herberth <klaus@jsxc.org> <br>
 * Released under the MIT license
 * 
 * Please see https://github.com/sualko/owncloud_piwik
 * 
 * @author Klaus Herberth <klaus@jsxc.org>
 * @version 0.1.0
 * @license MIT
 */

/* global OC */

$(function() {
   OC.AppConfig.getValue('piwik', 'piwik', {}, function(piwik) {
      piwik = JSON.parse(piwik) || {};

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
