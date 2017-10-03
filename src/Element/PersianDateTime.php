<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/26/17
 * Time: 8:41 PM
 */

namespace Drupal\persian_date\Element;


use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Datetime\Element\Datetime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Annotation\FormElement;
use Drupal\persian_date\Plugin\Datetime\PersianDrupalDateTime;

/**
 * Class PersianDateTime
 * @package Drupal\persian_date\Element
 * @FormElement("persian_datetime")
 */
class PersianDateTime extends Datetime
{
    public function getInfo()
    {
        $info = parent::getInfo();
        $info['#date_date_element'] = 'text';
        return $info;
    }

    public static function formatExample($format) {
        if (!static::$dateExample) {
            static::$dateExample = new PersianDrupalDateTime();
        }
        return static::$dateExample->format($format);
    }

    public static function valueCallback(&$element, $input, FormStateInterface $form_state)
    {

        if ($input !== FALSE) {
            $date_input  = $element['#date_date_element'] != 'none' && !empty($input['date']) ? $input['date'] : '';
            $time_input  = $element['#date_time_element'] != 'none' && !empty($input['time']) ? $input['time'] : '';
            $date_format = $element['#date_date_element'] != 'none' ? static::getHtml5DateFormat($element) : '';
            $time_format = $element['#date_time_element'] != 'none' ? static::getHtml5TimeFormat($element) : '';
            $timezone = !empty($element['#date_timezone']) ? $element['#date_timezone'] : NULL;

            // Seconds will be omitted in a post in case there's no entry.
            if (!empty($time_input) && strlen($time_input) == 5) {
                $time_input .= ':00';
            }
            try {
                $date_time_format = trim($date_format . ' ' . $time_format);
                $date_time_input = trim($date_input . ' ' . $time_input);
                $date = PersianDrupalDateTime::createFromFormat($date_time_format, $date_time_input, $timezone);
                $date = DrupalDateTime::createFromDateTime($date->getDateTime());
            }
            catch (\Exception $e) {
                $date = NULL;
            }
            $input = [
                'date'   => $date_input,
                'time'   => $time_input,
                'object' => $date,
            ];
        }
        else {
            $date = $element['#default_value'];
            if ($date instanceof DrupalDateTime && !$date->hasErrors()) {
                $input = [
                    'date'   => $date->format($element['#date_date_format']),
                    'time'   => $date->format($element['#date_time_format']),
                    'object' => $date,
                ];
            }
            else {
                $input = [
                    'date'   => '',
                    'time'   => '',
                    'object' => NULL,
                ];
            }
        }
        return $input;
    }


}