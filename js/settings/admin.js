/* global OCP, OC */

$(function() {
   $('#piwikAdblockerWarning').hide();

   function showRequestResult(element, result) {
      if (element.attr('type') === 'checkbox') {
         element = $('label[for="' + element.attr('id') + '"]');
      }

      element.removeClass('piwik-success piwik-error');
      element.addClass('piwik-' + result);

      var timeout = element.data('timeout');

      if (timeout) {
         clearTimeout(timeout);
      }

      timeout = setTimeout(function() {
         element.removeClass('piwik-success piwik-error');
      }, 1000);

      element.data('timeout', timeout);
   }

   $('#piwikUrl').attr('placeholder', 'e.g. //' + window.location.host + '/piwik/');

   $('#piwikSettings input').change(function() {
      var element = $(this);
      var key = $(this).attr('name');
      var value = $(this).attr('type') === 'checkbox' ? $(this).prop('checked') : $(this).val();

      $.ajax({
         method: 'PUT',
         url: OC.generateUrl('apps/piwik/settings/' + key),
         data: {
            value: value
         },
         success: function(response) {
            showRequestResult(element, response.status)
         },
         error: function() {
            showRequestResult(element, 'error') 
         }
      });
   });
});
