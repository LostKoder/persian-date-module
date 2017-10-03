<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 10/3/17
 * Time: 9:37 PM
 */

namespace Drupal\persian_date;


use Drupal\Core\Datetime\DateHelper;
use Drupal\persian_date\Plugin\Datetime\PersianDrupalDateTime as DrupalDateTime;

class PersianDateHelper extends DateHelper
{

    /**
     * Constructs an untranslated array of month names.
     *
     * @return array
     *   An array of month names.
     */
    public static function monthNamesUntranslated() {
        // Force the key to use the correct month value, rather than
        // starting with zero.
        return [
            1  => 'فروردین',
            2  => 'اردیبهشت',
            3  => 'خرداد',
            4  => 'تیر',
            5  => 'مرداد',
            6  => 'شهریور',
            7  => 'مهر',
            8  => 'آبان',
            9  => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];
    }

    /**
     * Constructs an untranslated array of abbreviated month names.
     *
     * @return array
     *   An array of month names.
     */
    public static function monthNamesAbbrUntranslated() {
        // Force the key to use the correct month value, rather than
        // starting with zero.
        return self::monthNamesUntranslated();
    }

    /**
     * Returns a translated array of month names.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of month names.
     */
    public static function monthNames($required = FALSE) {
        // Force the key to use the correct month value, rather than
        // starting with zero.
        $monthnames = [
            1  => t('فروردین', [], ['context' => 'Long month name']),
            2  => t('اردیبهشت', [], ['context' => 'Long month name']),
            3  => t('خرداد', [], ['context' => 'Long month name']),
            4  => t('تیر', [], ['context' => 'Long month name']),
            5  => t('مرداد', [], ['context' => 'Long month name']),
            6  => t('شهریور', [], ['context' => 'Long month name']),
            7  => t('مهر', [], ['context' => 'Long month name']),
            8  => t('آبان', [], ['context' => 'Long month name']),
            9  => t('آذر', [], ['context' => 'Long month name']),
            10 => t('دی', [], ['context' => 'Long month name']),
            11 => t('بهمن', [], ['context' => 'Long month name']),
            12 => t('اسفند', [], ['context' => 'Long month name']),
        ];
        $none = ['' => ''];
        return !$required ? $none + $monthnames : $monthnames;
    }

    /**
     * Constructs a translated array of month name abbreviations
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of month abbreviations.
     */
    public static function monthNamesAbbr($required = FALSE) {
        // Force the key to use the correct month value, rather than
        // starting with zero.
        $monthnames = [
            1  => t('فروردین', [], ['context' => 'Abbreviated month name']),
            2  => t('اردیبهشت', [], ['context' => 'Abbreviated month name']),
            3  => t('خرداد', [], ['context' => 'Abbreviated month name']),
            4  => t('تیر', [], ['context' => 'Abbreviated month name']),
            5  => t('مرداد', [], ['context' => 'Abbreviated month name']),
            6  => t('شهریور', [], ['context' => 'Abbreviated month name']),
            7  => t('مهر', [], ['context' => 'Abbreviated month name']),
            8  => t('آبان', [], ['context' => 'Abbreviated month name']),
            9  => t('آذر', [], ['context' => 'Abbreviated month name']),
            10 => t('دی', [], ['context' => 'Abbreviated month name']),
            11 => t('بهمن', [], ['context' => 'Abbreviated month name']),
            12 => t('اسفند', [], ['context' => 'Abbreviated month name']),
        ];
        $none = ['' => ''];
        return !$required ? $none + $monthnames : $monthnames;
    }

    /**
     * Constructs an untranslated array of week days.
     *
     * @return array
     *   An array of week day names
     */
    public static function weekDaysUntranslated() {
        return [
            'Sunday',
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
        ];
    }

    /**
     * Returns a translated array of week names.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of week day names
     */
    public static function weekDays($required = FALSE) {
        $weekdays = [
            t('Sunday'),
            t('Monday'),
            t('Tuesday'),
            t('Wednesday'),
            t('Thursday'),
            t('Friday'),
            t('Saturday'),
        ];
        $none = ['' => ''];
        return !$required ? $none + $weekdays : $weekdays;
    }

    /**
     * Constructs a translated array of week day abbreviations.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of week day abbreviations
     */
    public static function weekDaysAbbr($required = FALSE) {
        $weekdays = [
            t('Sun', [], ['context' => 'Abbreviated weekday']),
            t('Mon', [], ['context' => 'Abbreviated weekday']),
            t('Tue', [], ['context' => 'Abbreviated weekday']),
            t('Wed', [], ['context' => 'Abbreviated weekday']),
            t('Thu', [], ['context' => 'Abbreviated weekday']),
            t('Fri', [], ['context' => 'Abbreviated weekday']),
            t('Sat', [], ['context' => 'Abbreviated weekday']),
        ];
        $none = ['' => ''];
        return !$required ? $none + $weekdays : $weekdays;
    }

    /**
     * Constructs a translated array of 2-letter week day abbreviations.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of week day 2 letter abbreviations
     */
    public static function weekDaysAbbr2($required = FALSE) {
        $weekdays = [
            t('Su', [], ['context' => 'Abbreviated weekday']),
            t('Mo', [], ['context' => 'Abbreviated weekday']),
            t('Tu', [], ['context' => 'Abbreviated weekday']),
            t('We', [], ['context' => 'Abbreviated weekday']),
            t('Th', [], ['context' => 'Abbreviated weekday']),
            t('Fr', [], ['context' => 'Abbreviated weekday']),
            t('Sa', [], ['context' => 'Abbreviated weekday']),
        ];
        $none = ['' => ''];
        return !$required ? $none + $weekdays : $weekdays;
    }

    /**
     * Constructs a translated array of 1-letter week day abbreviations.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of week day 1 letter abbreviations
     */
    public static function weekDaysAbbr1($required = FALSE) {
        $weekdays = [
            t('S', [], ['context' => 'Abbreviated 1 letter weekday Sunday']),
            t('M', [], ['context' => 'Abbreviated 1 letter weekday Monday']),
            t('T', [], ['context' => 'Abbreviated 1 letter weekday Tuesday']),
            t('W', [], ['context' => 'Abbreviated 1 letter weekday Wednesday']),
            t('T', [], ['context' => 'Abbreviated 1 letter weekday Thursday']),
            t('F', [], ['context' => 'Abbreviated 1 letter weekday Friday']),
            t('S', [], ['context' => 'Abbreviated 1 letter weekday Saturday']),
        ];
        $none = ['' => ''];
        return !$required ? $none + $weekdays : $weekdays;
    }

    /**
     * Reorders weekdays to match the first day of the week.
     *
     * @param array $weekdays
     *   An array of weekdays.
     *
     * @return array
     *   An array of weekdays reordered to match the first day of the week. The
     *   keys will remain unchanged. For example, if the first day of the week is
     *   set to be Monday, the array keys will be [1, 2, 3, 4, 5, 6, 0].
     */
    public static function weekDaysOrdered($weekdays) {
        $first_day = \Drupal::config('system.date')->get('first_day');
        if ($first_day > 0) {
            for ($i = 1; $i <= $first_day; $i++) {
                // Reset the array to the first element.
                reset($weekdays);
                // Retrieve the first week day value.
                $last = current($weekdays);
                // Store the corresponding key.
                $key = key($weekdays);
                // Remove this week day from the beginning of the array.
                unset($weekdays[$key]);
                // Add this week day to the end of the array.
                $weekdays[$key] = $last;
            }
        }
        return $weekdays;
    }

    /**
     * Constructs an array of years in a specified range.
     *
     * @param int $min
     *   (optional) The minimum year in the array. Defaults to zero.
     * @param int $max
     *   (optional) The maximum year in the array. Defaults to zero.
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of years in the selected range.
     */
    public static function years($min = 0, $max = 0, $required = FALSE) {
        // Ensure $min and $max are valid values.
        if (empty($min)) {
            $min = intval(date('Y', REQUEST_TIME) - 3);
        }
        if (empty($max)) {
            $max = intval(date('Y', REQUEST_TIME) + 3);
        }
        $none = ['' => ''];
        $range = range($min, $max);
        $range = array_combine($range, $range);
        return !$required ? $none + $range : $range;
    }

    /**
     * Constructs an array of days in a month.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     * @param int $month
     *   (optional) The month in which to find the number of days. Defaults to
     *   NULL.
     * @param int $year
     *   (optional) The year in which to find the number of days. Defaults to
     *   NULL.
     *
     * @return array
     *   An array of days for the selected month.
     */
    public static function days($required = FALSE, $month = NULL, $year = NULL) {
        // If we have a month and year, find the right last day of the month.
        if (!empty($month) && !empty($year)) {
            $date = new DrupalDateTime($year . '-' . $month . '-01 00:00:00', 'UTC');
            $max = $date->format('t');
        }
        // If there is no month and year given, default to 31.
        if (empty($max)) {
            $max = 31;
        }
        $none = ['' => ''];
        $range = range(1, $max);
        $range = array_combine($range, $range);
        return !$required ? $none + $range : $range;
    }


    /**
     * Constructs an array of hours.
     *
     * @param string $format
     *   (optional) A date format string that indicates the format to use for the
     *   hours. Defaults to 'H'.
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of hours in the selected format.
     */
    public static function hours($format = 'H', $required = FALSE) {
        $hours = [];
        if ($format == 'h' || $format == 'g') {
            $min = 1;
            $max = 12;
        }
        else {
            $min = 0;
            $max = 23;
        }
        for ($i = $min; $i <= $max; $i++) {
            $formatted = ($format == 'H' || $format == 'h') ? DrupalDateTime::datePad($i) : $i;
            $hours[$i] = $formatted;
        }
        $none = ['' => ''];
        return !$required ? $none + $hours : $hours;
    }

    /**
     * Constructs an array of minutes.
     *
     * @param string $format
     *   (optional) A date format string that indicates the format to use for the
     *    minutes. Defaults to 'i'.
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     * @param int $increment
     *   An integer value to increment the values. Defaults to 1.
     *
     * @return array
     *   An array of minutes in the selected format.
     */
    public static function minutes($format = 'i', $required = FALSE, $increment = 1) {
        $minutes = [];
        // Ensure $increment has a value so we don't loop endlessly.
        if (empty($increment)) {
            $increment = 1;
        }
        for ($i = 0; $i < 60; $i += $increment) {
            $formatted = $format == 'i' ? DrupalDateTime::datePad($i) : $i;
            $minutes[$i] = $formatted;
        }
        $none = ['' => ''];
        return !$required ? $none + $minutes : $minutes;
    }

    /**
     * Constructs an array of seconds.
     *
     * @param string $format
     *   (optional) A date format string that indicates the format to use for the
     *   seconds. Defaults to 's'.
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     * @param int $increment
     *   An integer value to increment the values. Defaults to 1.
     *
     * @return array
     *   An array of seconds in the selected format.
     */
    public static function seconds($format = 's', $required = FALSE, $increment = 1) {
        $seconds = [];
        // Ensure $increment has a value so we don't loop endlessly.
        if (empty($increment)) {
            $increment = 1;
        }
        for ($i = 0; $i < 60; $i += $increment) {
            $formatted = $format == 's' ? DrupalDateTime::datePad($i) : $i;
            $seconds[$i] = $formatted;
        }
        $none = ['' => ''];
        return !$required ? $none + $seconds : $seconds;
    }

    /**
     * Constructs an array of AM and PM options.
     *
     * @param bool $required
     *   (optional) If FALSE, the returned array will include a blank value.
     *   Defaults to FALSE.
     *
     * @return array
     *   An array of AM and PM options.
     */
    public static function ampm($required = FALSE) {
        $none = ['' => ''];
        $ampm = [
            'am' => t('am', [], ['context' => 'ampm']),
            'pm' => t('pm', [], ['context' => 'ampm']),
        ];
        return !$required ? $none + $ampm : $ampm;
    }

    /**
     * Identifies the number of days in a month for a date.
     *
     * @param mixed $date
     *   (optional) A DrupalDateTime object or a date string.
     *   Defaults to NULL, which means to use the current date.
     *
     * @return int
     *   The number of days in the month.
     */
    public static function daysInMonth($date = NULL) {
        if (!$date instanceof DrupalDateTime) {
            $date = new DrupalDateTime($date);
        }
        if (!$date->hasErrors()) {
            return $date->format('t');
        }
        return NULL;
    }

    /**
     * Identifies the number of days in a year for a date.
     *
     * @param mixed $date
     *   (optional) A DrupalDateTime object or a date string.
     *   Defaults to NULL, which means to use the current date.
     *
     * @return int
     *   The number of days in the year.
     */
    public static function daysInYear($date = NULL) {
        if (!$date instanceof DrupalDateTime) {
            $date = new DrupalDateTime($date);
        }
        if (!$date->hasErrors()) {
            if ($date->format('L')) {
                return 366;
            }
            else {
                return 365;
            }
        }
        return NULL;
    }

    /**
     * Returns day of week for a given date (0 = Sunday).
     *
     * @param mixed $date
     *   (optional) A DrupalDateTime object or a date string.
     *   Defaults to NULL, which means use the current date.
     *
     * @return int
     *   The number of the day in the week.
     */
    public static function dayOfWeek($date = NULL) {
        if (!$date instanceof DrupalDateTime) {
            $date = new DrupalDateTime($date);
        }
        if (!$date->hasErrors()) {
            return $date->format('w');
        }
        return NULL;
    }

    /**
     * Returns translated name of the day of week for a given date.
     *
     * @param mixed $date
     *   (optional) A DrupalDateTime object or a date string.
     *   Defaults to NULL, which means use the current date.
     * @param string $abbr
     *   (optional) Whether to return the abbreviated name for that day.
     *   Defaults to TRUE.
     *
     * @return string
     *   The name of the day in the week for that date.
     */
    public static function dayOfWeekName($date = NULL, $abbr = TRUE) {
        if (!$date instanceof DrupalDateTime) {
            $date = new DrupalDateTime($date);
        }
        $dow = self::dayOfWeek($date);
        $days = $abbr ? self::weekDaysAbbr() : self::weekDays();
        return $days[$dow];
    }

}