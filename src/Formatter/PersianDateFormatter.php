<?php

namespace Drupal\persian_date\Formatter;

use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Datetime\FormattedDateDiff;
use Drupal\persian_date\Converter\PersianDateConverter;
use Drupal\persian_date\Converter\PersianDateFactory;
use Drupal\persian_date\PersianLanguageDiscovery;

class PersianDateFormatter extends DateFormatter
{
    public function format($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL)
    {
        if (!PersianLanguageDiscovery::isPersian()) {
            return parent::format($timestamp, $type, $format, $timezone, $langcode);
        }

        if (!isset($timezone)) {
            $timezone = date_default_timezone_get();
        }

        // Store DateTimeZone objects in an array rather than repeatedly
        // constructing identical objects over the life of a request.
        if (!isset($this->timezones[$timezone])) {
            $this->timezones[$timezone] = timezone_open($timezone);
        }

        if (empty($langcode)) {
            $langcode = $this->languageManager->getCurrentLanguage()->getId();
        }

        $date = PersianDateFactory::buildFromTimestamp($timestamp, $this->timezones[$timezone]);

        // If we have a non-custom date format use the provided date format pattern.
        if ($type !== 'custom') {
            if ($date_format = $this->dateFormat($type, $langcode)) {
                $format = $date_format->getPattern();
            }
        }

        // called by query builder
        if ($type === 'custom' & $format === DATETIME_DATETIME_STORAGE_FORMAT) {
            // convert shamsi to georgian
            $parent = parent::format($timestamp, $type, $format, $timezone, $langcode);
            $other = PersianDateConverter::normalizeDate(new \DateTime($parent));
            return parent::format($other->getTimestamp(), $type, $format, $timezone, $langcode);
        }

        // Fall back to the 'medium' date format type if the format string is
        // empty, either from not finding a requested date format or being given an
        // empty custom format string.
        if (empty($format)) {
            $format = $this->dateFormat('fallback', $langcode)->getPattern();
        }

        return $date->format($format);
    }

    public function formatDiff($from, $to, $options = [])
    {

        $options += [
            'granularity' => 2,
            'langcode' => NULL,
            'strict' => TRUE,
            'return_as_object' => FALSE,
        ];

        if ($options['strict'] && $from > $to) {
            $string = $this->t('0 seconds');
            if ($options['return_as_object']) {
                return new FormattedDateDiff($string, 0);
            }
            return $string;
        }

        $date_time_from = new \DateTime();
        $date_time_from->setTimestamp($from);

        $date_time_to = new \DateTime();
        $date_time_to->setTimestamp($to);

        $interval = $date_time_to->diff($date_time_from);

        $granularity = $options['granularity'];
        $output = '';

        // We loop over the keys provided by \DateInterval explicitly. Since we
        // don't take the "invert" property into account, the resulting output value
        // will always be positive.
        $max_age = 1e99;
        foreach (['y', 'm', 'd', 'h', 'i', 's'] as $value) {
            if ($interval->$value > 0) {
                // Switch over the keys to call formatPlural() explicitly with literal
                // strings for all different possibilities.
                switch ($value) {
                    case 'y':
                        $interval_output = $this->formatPlural($interval->y, '1 سال', '@count سال', [], ['langcode' => $options['langcode']]);
                        $max_age = min($max_age, 365 * 86400);
                        break;

                    case 'm':
                        $interval_output = $this->formatPlural($interval->m, '1 ماه', '@count ماه', [], ['langcode' => $options['langcode']]);
                        $max_age = min($max_age, 30 * 86400);
                        break;

                    case 'd':
                        // \DateInterval doesn't support weeks, so we need to calculate them
                        // ourselves.
                        $interval_output = '';
                        $days = $interval->d;
                        $weeks = floor($days / 7);
                        if ($weeks) {
                            $interval_output .= $this->formatPlural($weeks, '1 هفته', '@count هفته', [], ['langcode' => $options['langcode']]);
                            $days -= $weeks * 7;
                            $granularity--;
                            $max_age = min($max_age, 7 * 86400);
                        }

                        if ((!$output || $weeks > 0) && $granularity > 0 && $days > 0) {
                            $interval_output .= ($interval_output ? ' ' : '') . $this->formatPlural($days, '1 روز', '@count روز', [], ['langcode' => $options['langcode']]);
                            $max_age = min($max_age, 86400);
                        } else {
                            // If we did not output days, set the granularity to 0 so that we
                            // will not output hours and get things like "1 week 1 hour".
                            $granularity = 0;
                        }
                        break;

                    case 'h':
                        $interval_output = $this->formatPlural($interval->h, '1 ساعت', '@count ساعت', [], ['langcode' => $options['langcode']]);
                        $max_age = min($max_age, 3600);
                        break;

                    case 'i':
                        $interval_output = $this->formatPlural($interval->i, '1 دقیقه', '@count دقیقه', [], ['langcode' => $options['langcode']]);
                        $max_age = min($max_age, 60);
                        break;

                    case 's':
                        $interval_output = $this->formatPlural($interval->s, '1 ثانیه', '@count ثانیه', [], ['langcode' => $options['langcode']]);
                        $max_age = min($max_age, 1);
                        break;

                }
                $output .= ($output && $interval_output ? ' ' : '') . $interval_output;
                $granularity--;
            } elseif ($output) {
                // Break if there was previous output but not any output at this level,
                // to avoid skipping levels and getting output like "1 year 1 second".
                break;
            }

            if ($granularity <= 0) {
                break;
            }
        }

        if (empty($output)) {
            $output = $this->t('0 seconds');
            $max_age = 0;
        }

        if ($options['return_as_object']) {
            return new FormattedDateDiff($output, $max_age);
        }

        return $output;
    }


}