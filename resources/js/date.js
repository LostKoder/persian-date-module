/**
 * @file
 * Polyfill for HTML5 date input.
 */

(function ($, Modernizr, Drupal) {

  'use strict';

  /**
   * Attach datepicker fallback on date elements.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior. Accepts in `settings.date` an object listing
   *   elements to process, keyed by the HTML ID of the form element containing
   *   the human-readable value. Each element is an datepicker settings object.
   * @prop {Drupal~behaviorDetach} detach
   *   Detach the behavior destroying datepickers on effected elements.
   */
  Drupal.behaviors.date = {
    attach: function (context, settings) {
      var $context = $(context);
      $context.find('[type=date]').attr('type','text');
      $context.find('input[data-drupal-date-format]').once('datePicker').each(function () {
        var $input = $(this);
        var datepickerSettings = {};
        var dateFormat = $input.data('drupalDateFormat');
        // The date format is saved in PHP style, we need to convert to jQuery
        // datepicker.
        datepickerSettings.dateFormat = dateFormat
          .replace('Y', 'yy')
          .replace('m', 'mm')
          .replace('d', 'dd');
        // Add min and max date if set on the input.
        if ($input.attr('min')) {
          // datepickerSettings.minDate = $input.attr('min');
        }
        if ($input.attr('max')) {
          // datepickerSettings.maxDate = $input.attr('max');
        }
<<<<<<< HEAD
        datepickerSettings.changeMonth = true;
        datepickerSettings.changeYear = true;
        // datepickerSettings.yearRange = '1380:1400';
=======
        console.log(datepickerSettings);
>>>>>>> 4df666efc7a976082f2f839833944f370cfc26d8
        $input.datepicker(datepickerSettings);
      });
    },
    detach: function (context, settings, trigger) {
      if (trigger === 'unload') {
          $(context).find('input[data-drupal-date-format]').findOnce('datePicker').datepicker('destroy');
      }
    }
  };

})(jQuery, Modernizr, Drupal);
