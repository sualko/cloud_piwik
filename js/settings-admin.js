/* global OCP, OC */

$(function() {
   function setValue(data) {
      if (data) {
         try {
            data = JSON.parse(data);
         } catch (err) {}
      }
      data = data || {};

      var form = $('#piwikSettings form');

      $.each(data, function(name, val) {
         var el = form.find('[name=' + name + ']');

         if (el.attr('type') === 'checkbox') {
            el.prop('checked', val === 'yes' || val === 'on');
         } else {
            el.val(val);
         }
      });
   }

   if (typeof OCP !== 'undefined') {
      OCP.AppConfig.getValue('piwik', 'piwik', {}, {
         success: function(result) {
            setValue($(result).find('data data').text());
         }
      });
   } else {
      OC.AppConfig.getValue('piwik', 'piwik', {}, setValue);
   }

   $('#piwikUrl').attr('placeholder', 'e.g. //' + window.location.host + '/piwik/');

   $('#piwikSettings input').change(function() {
      var formData = $('#piwikSettings form').serializeArray();
      var data = {};

      $.each(formData, function(index, obj) {
         data[obj.name] = obj.value;
      });

      if (!data.url.match(/\/$/)) {
         data.url += '/';
      }

      if (typeof OCP !== 'undefined') {
         OCP.AppConfig.setValue('piwik', 'piwik', JSON.stringify(data));
      } else {
         OC.AppConfig.setValue('piwik', 'piwik', JSON.stringify(data));
      }
   });
});
