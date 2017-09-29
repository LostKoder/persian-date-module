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
use Drupal\Core\Datetime\DrupalDateTime;
use ReflectionObject;


/**
 * This class converts Gregorian datetime to Persian datetime and reverse.
 *
 * @package Drupal\persian_date\Convertor
 */
class PersianDateConverter
{
    /**
     * Convert Gregorian date parameters to Persian.
     *
     * @param int $year Gregorian year
     * @param int $month Gregorian month
     * @param int $day Gregorian day
     * @param string $mod
     * @return array|string
     */
    static function gregorian_to_jalali($year, $month, $day, $mod = '')
    {
        $g_d_m = array(0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334);
        $jy = ($year <= 1600) ? 0 : 979;
        $year -= ($year <= 1600) ? 621 : 1600;
        $gy2 = ($month > 2) ? ($year + 1) : $year;
        $days = (365 * $year) + ((int)(($gy2 + 3) / 4)) - ((int)(($gy2 + 99) / 100))
            + ((int)(($gy2 + 399) / 400)) - 80 + $day + $g_d_m[$month - 1];
        $jy += 33 * ((int)($days / 12053));
        $days %= 12053;
        $jy += 4 * ((int)($days / 1461));
        $days %= 1461;
        $jy += (int)(($days - 1) / 365);
        if ($days > 365) $days = ($days - 1) % 365;
        $jm = ($days < 186) ? 1 + (int)($days / 31) : 7 + (int)(($days - 186) / 30);
        $jd = 1 + (($days < 186) ? ($days % 31) : (($days - 186) % 30));
        return ($mod == '') ? array($jy, $jm, $jd) : $jy . $mod . $jm . $mod . $jd;
    }


    /**
     * Convert Persian date parameters to Gregorian.
     *
     * @param int $year Persian year
     * @param int $month Persian month
     * @param int $day Persian day
     * @param string $mod
     * @return array|string
     */
    static function jalali_to_gregorian($year, $month, $day, $mod = '')
    {
        $gy = ($year <= 979) ? 621 : 1600;
        $year -= ($year <= 979) ? 0 : 979;
        $days = (365 * $year) + (((int)($year / 33)) * 8) + ((int)((($year % 33) + 3) / 4))
            + 78 + $day + (($month < 7) ? ($month - 1) * 31 : (($month - 7) * 30) + 186);
        $gy += 400 * ((int)($days / 146097));
        $days %= 146097;
        if ($days > 36524) {
            $gy += 100 * ((int)(--$days / 36524));
            $days %= 36524;
            if ($days >= 365) $days++;
        }
        $gy += 4 * ((int)(($days) / 1461));
        $days %= 1461;
        $gy += (int)(($days - 1) / 365);
        if ($days > 365) $days = ($days - 1) % 365;
        $gd = $days + 1;
        foreach (array(0, 31, (($gy % 4 == 0 and $gy % 100 != 0) or ($gy % 400 == 0)) ? 29 : 28
                 , 31, 30, 31, 30, 31, 31, 30, 31, 30, 31) as $gm => $v) {
            if ($gd <= $v) break;
            $gd -= $v;
        }
        return ($mod == '') ? array($gy, $gm, $gd) : $gy . $mod . $gm . $mod . $gd;
    }

    /**
     * Converts wrongly formatted shamsi datetime to standard one
     *
     * @param mixed $dateTime
     * @return \DateTime
     */
    public static function normalizeDate($dateTime)
    {
        $return =  PersianDateFactory::buildFromExactDate(
            $dateTime->format('H'),
            $dateTime->format('i'),
            $dateTime->format('s'),
            $dateTime->format('m'),
            $dateTime->format('d'),
            $dateTime->format('Y')
        )->getOriginalDateTime();

        return $return;
    }
}