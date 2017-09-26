<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/19/17
 * Time: 3:58 PM
 */

namespace Drupal\persian_date;


class PersianLanguageDiscovery
{
    private static $isPersian = null;

    /**
     * @return bool
     */
    public static function isPersian()
    {
        if (self::$isPersian === null) {
            // only convert farsi on multi lingual sites
            $isMultiLingual = count(\Drupal::languageManager()->getLanguages()) > 1;
            if ($isMultiLingual) {
                $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
                if ($language !== 'fa') {
                    self::$isPersian = false;
                } else {
                    self::$isPersian = true;
                }
            } else {
                self::$isPersian = true;
            }
        }

        return self::$isPersian;
    }
}