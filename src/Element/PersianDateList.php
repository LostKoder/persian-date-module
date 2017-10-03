<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 10/3/17
 * Time: 8:15 PM
 */

namespace Drupal\persian_date\Element;


use Drupal\Core\Datetime\DateHelper;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Datetime\Element\Datelist;
use Drupal\Core\Form\FormStateInterface;
use Drupal\persian_date\PersianDateHelper;
use Drupal\persian_date\Plugin\Datetime\PersianDrupalDateTime;

/**
 * Class PersianDateList
 * @FormElement("datelist")
 */
class PersianDateList extends Datelist
{
    public static function valueCallback(&$element, $input, FormStateInterface $form_state) {
        $parts = $element['#date_part_order'];
        $increment = $element['#date_increment'];

        $date = NULL;
        if ($input !== FALSE) {
            $return = $input;
            if (empty(static::checkEmptyInputs($input, $parts))) {
                if (isset($input['ampm'])) {
                    if ($input['ampm'] == 'pm' && $input['hour'] < 12) {
                        $input['hour'] += 12;
                    }
                    elseif ($input['ampm'] == 'am' && $input['hour'] == 12) {
                        $input['hour'] -= 12;
                    }
                    unset($input['ampm']);
                }
                $timezone = !empty($element['#date_timezone']) ? $element['#date_timezone'] : NULL;
                try {
                    $date = DrupalDateTime::createFromArray($input, $timezone);
                }
                catch (\Exception $e) {
                    $form_state->setError($element, t('Selected combination of day and month is not valid.'));
                }
                if ($date instanceof DrupalDateTime && !$date->hasErrors()) {
                    static::incrementRound($date, $increment);
                }
            }
        }
        else {
            $return = array_fill_keys($parts, '');
            if (!empty($element['#default_value'])) {
                $date = $element['#default_value'];
                if ($date instanceof DrupalDateTime && !$date->hasErrors()) {
                    static::incrementRound($date, $increment);
                    foreach ($parts as $part) {
                        switch ($part) {
                            case 'day':
                                $format = 'j';
                                break;

                            case 'month':
                                $format = 'n';
                                break;

                            case 'year':
                                $format = 'Y';
                                break;

                            case 'hour':
                                $format = in_array('ampm', $element['#date_part_order']) ? 'g' : 'G';
                                break;

                            case 'minute':
                                $format = 'i';
                                break;

                            case 'second':
                                $format = 's';
                                break;

                            case 'ampm':
                                $format = 'a';
                                break;

                            default:
                                $format = '';

                        }
                        $return[$part] = $date->format($format);
                    }
                }
            }
        }
        $timezone = isset($timezone) ?: null;
        $date = PersianDrupalDateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'), $timezone);
        $date = DrupalDateTime::createFromDateTime($date->getDateTime());
        $return['object'] = $date;
        return $return;
    }
    public static function processDatelist(&$element, FormStateInterface $form_state, &$complete_form)
    {

        // Load translated date part labels from the appropriate calendar plugin.
        $date_helper = new PersianDateHelper();

        // The value callback has populated the #value array.
        $date = !empty($element['#value']['object']) ? $element['#value']['object'] : NULL;

        // Set a fallback timezone.
        if ($date instanceof DrupalDateTime) {
            $element['#date_timezone'] = $date->getTimezone()->getName();
        }
        elseif (!empty($element['#timezone'])) {
            $element['#date_timezone'] = $element['#date_timezone'];
        }
        else {
            $element['#date_timezone'] = drupal_get_user_timezone();
        }

        $element['#tree'] = TRUE;

        // Determine the order of the date elements.
        $order = !empty($element['#date_part_order']) ? $element['#date_part_order'] : ['year', 'month', 'day'];
        $text_parts = !empty($element['#date_text_parts']) ? $element['#date_text_parts'] : [];

        // Output multi-selector for date.
        foreach ($order as $part) {
            switch ($part) {
                case 'day':
                    $options = $date_helper->days($element['#required']);
                    $format = 'j';
                    $title = t('Day');
                    break;

                case 'month':
                    $options = $date_helper->monthNamesAbbr($element['#required']);
                    $format = 'n';
                    $title = t('Month');
                    break;

                case 'year':
                    $range = static::datetimeRangeYears($element['#date_year_range'], $date);
                    $options = $date_helper->years($range[0], $range[1], $element['#required']);
                    $format = 'Y';
                    $title = t('Year');
                    break;

                case 'hour':
                    $format = in_array('ampm', $element['#date_part_order']) ? 'g' : 'G';
                    $options = $date_helper->hours($format, $element['#required']);
                    $title = t('Hour');
                    break;

                case 'minute':
                    $format = 'i';
                    $options = $date_helper->minutes($format, $element['#required'], $element['#date_increment']);
                    $title = t('Minute');
                    break;

                case 'second':
                    $format = 's';
                    $options = $date_helper->seconds($format, $element['#required'], $element['#date_increment']);
                    $title = t('Second');
                    break;

                case 'ampm':
                    $format = 'a';
                    $options = $date_helper->ampm($element['#required']);
                    $title = t('AM/PM');
                    break;

                default:
                    $format = '';
                    $options = [];
                    $title = '';
            }

            $default = isset($element['#value'][$part]) && trim($element['#value'][$part]) != '' ? $element['#value'][$part] : '';
            $value = $date instanceof DrupalDateTime && !$date->hasErrors() ? $date->format($format) : $default;
            if (!empty($value) && $part != 'ampm') {
                $value = intval($value);
            }

            $element['#attributes']['title'] = $title;
            $element[$part] = [
                '#type' => in_array($part, $text_parts) ? 'textfield' : 'select',
                '#title' => $title,
                '#title_display' => 'invisible',
                '#value' => $value,
                '#attributes' => $element['#attributes'],
                '#options' => $options,
                '#required' => $element['#required'],
                '#error_no_message' => FALSE,
                '#empty_option' => $title,
            ];
        }

        // Allows custom callbacks to alter the element.
        if (!empty($element['#date_date_callbacks'])) {
            foreach ($element['#date_date_callbacks'] as $callback) {
                if (function_exists($callback)) {
                    $callback($element, $form_state, $date);
                }
            }
        }

        return $element;

    }

}