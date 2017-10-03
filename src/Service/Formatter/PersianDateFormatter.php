<?php

namespace Drupal\persian_date\Service\Formatter;

use Drupal\Core\Datetime\DateFormatter;
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
}