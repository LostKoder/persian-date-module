<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/18/17
 * Time: 4:18 PM
 */

namespace Drupal\persian_date\Plugin\Datetime;


use Drupal\Component\Datetime\DateTimePlus;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\persian_date\Converter\PersianDateFactory;
use Drupal\persian_date\Library\Jalali\jDateTime;

class PersianDrupalDateTime extends DrupalDateTime
{
    public function format($format, $settings = [])
    {
        $dateTime = PersianDateFactory::buildFromOriginalDateTime($this->dateTimeObject);
        return $dateTime->format($format);
    }

    public static function createFromDrupalDateTime(DrupalDateTime $dateTime)
    {
        $object = new self();
        $object->dateTimeObject = $dateTime->dateTimeObject;
        $object->langcode = $dateTime->langcode;
        $object->formatTranslationCache = $dateTime->formatTranslationCache;
        $object->stringTranslation = $dateTime->stringTranslation;
        $object->errors = $dateTime->errors;
        $object->inputFormatAdjusted = $dateTime->inputFormatAdjusted;
        $object->inputFormatRaw = $dateTime->inputFormatRaw;
        $object->inputTimeZoneRaw = $dateTime->inputTimeZoneRaw;
        $object->inputTimeZoneAdjusted = $dateTime->inputTimeZoneAdjusted;
        $object->inputTimeRaw = $dateTime->inputTimeRaw;
        $object->inputTimeAdjusted = $dateTime->inputTimeAdjusted;
        return $object;
    }

    public static function createFromFormat($format, $time, $timezone = NULL, $settings = [])
    {
        if (!isset($settings['validate_format'])) {
            $settings['validate_format'] = TRUE;
        }

        // Tries to create a date from the format and use it if possible.
        // A regular try/catch won't work right here, if the value is
        // invalid it doesn't return an exception.
        $datetimeplus = new static('', $timezone, $settings);

        $date = false;
        if ($time) {
            list($year, $month, $day, $hour, $minute, $second)= array_values(jDateTime::parseFromFormat($format, $time));
            $date = PersianDateFactory::buildFromExactDate($hour, $minute, $second, $month, $day, $year);
        }

        if (!$date instanceof \DateTime) {
            throw new \InvalidArgumentException('The date cannot be created from a format.');
        } else {
            // Functions that parse date is forgiving, it might create a date that
            // is not exactly a match for the provided value, so test for that by
            // re-creating the date/time formatted string and comparing it to the input. For
            // instance, an input value of '11' using a format of Y (4 digits) gets
            // created as '0011' instead of '2011'.
            if ($date instanceof DateTimePlus) {
                $test_time = $date->format($format, $settings);
            } elseif ($date instanceof \DateTime) {
                $test_time = $date->format($format);
            }

            if ($settings['validate_format'] && $test_time != $time) {
                throw new \UnexpectedValueException('The created date does not match the input value.');
            }

            $date = $date->getOriginalDateTime();
            $date->setTimezone($datetimeplus->getTimezone());
            $datetimeplus->setTimestamp($date->getTimestamp());
            $datetimeplus->setTimezone($date->getTimezone());
        }
        return $datetimeplus;
    }

    public function getDateTime()
    {
        return $this->dateTimeObject;
    }
}