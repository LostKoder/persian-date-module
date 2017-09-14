<?php

/*
 * This file is part of the Persian Date (Object Oriented API) package.
 *
 * (c) Amin Alizade <motammem@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Drupal\persian_date\Converter;

/**
 * This class is responsible to build Persian DateTime instances.
 *
 * @package Drupal\persian_date\Convertor
 */
class PersianDateFactory
{
    /**
     * Build PersianDateTime instance from given parameters.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @param int $month
     * @param int $day
     * @param int $year
     * @param int $is_dst
     *
     * @return PersianDate
     */
    static function buildFromExactDate($hour = null, $minute = null, $second = null, $month = null, $day = null, $year = null, $is_dst = -1)
    {
        if (!$hour and !$minute and !$second and !$month and !$day and !$year) {
            $timestamp = mktime();
        } else {
            list($gy, $gm, $gd) = PersianDateConverter::jalali_to_gregorian($year, $month, $day);
            $timestamp = mktime($hour, $minute, $second, $gm, $gd, $gy, $is_dst);
        }

        $object = new PersianDate();
        $object->setTimestamp($timestamp);
        return $object;
    }

    /**
     * Bulid PersianDateTime instance from original PHP DateTime object.
     *
     * @param \DateTime $dateTime
     * @return PersianDate
     */
    static function buildFromOriginalDateTime(\DateTime $dateTime)
    {
        $object = new PersianDate();
        $object->setTimezone($dateTime->getTimezone());
        $object->setTimestamp($dateTime->getTimestamp());
        return $object;
    }

    /**
     * @param integer $timestamp
     * @param string $timezone
     * @return \DateTime
     */
    public static function buildFromTimestamp($timestamp, $timezone = null)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($timestamp);
        if ($timezone) {
            $dateTime->setTimezone(new \DateTimeZone($timezone));
        }
        return $dateTime;
    }
}