<?php

namespace Drupal\persian_date\Formatter;

use Drupal\persian_date\Converter\PersianDate;

class PersianDateFormatter extends \Drupal\Core\Datetime\DateFormatter
{
    public function format($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL)
    {
        $date = new PersianDate();
        $date->setTimestamp($timestamp);
        if ($timezone) {
            $date->setTimezone(new \DateTimeZone($timezone));
        }

        if ($type !== 'custom') {
            if ($date_format = $this->dateFormat($type, $langcode)) {
                $format = $date_format->getPattern();
            }
        }else{
            dd($format);
        }
//        dump($langcode);die;
        if (empty($format)) {
            $format = $this->dateFormat('fallback', $langcode)->getPattern();
        }
        return $date->format($format);

    }

}