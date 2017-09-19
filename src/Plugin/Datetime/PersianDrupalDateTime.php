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
}