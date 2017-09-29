<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/18/17
 * Time: 4:18 PM
 */

namespace Drupal\persian_date\Plugin\Datetime;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\persian_date\Converter\PersianDateFactory;

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

}