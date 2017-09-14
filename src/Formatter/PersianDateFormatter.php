<?php

namespace Drupal\persian_date\Formatter;

use Drupal\Core\Datetime\DateFormatter;
use Drupal\persian_date\Converter\PersianDateFactory;

class PersianDateFormatter extends DateFormatter
{
    public function format($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL)
    {
        $date = PersianDateFactory::buildFromTimestamp($timestamp, $timezone);

        if ($type !== 'custom') {
            if ($date_format = $this->dateFormat($type, $langcode)) {
                $format = $date_format->getPattern();
            }
        }

        if (empty($format)) {
            $format = $this->dateFormat('fallback', $langcode)->getPattern();
        }

        return $date->format($format);
    }

}