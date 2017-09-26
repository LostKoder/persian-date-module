<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/26/17
 * Time: 6:42 PM
 */

namespace Drupal\persian_date\Element;


use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Annotation\FormElement;
use Drupal\Core\Render\Element\Date;

/**
 * Class PersianDate
 * @package Drupal\persian_date\Element
 * @FormElement("persian_date")
 */
class PersianDate extends Date
{
    public static function processDate(&$element, FormStateInterface $form_state, &$complete_form)
    {
        // Attach JS support for the date field, if we can determine which date
        // format should be used.
        if ($element['#attributes']['type'] == 'date' && !empty($element['#date_date_format'])) {
            $element['#attached']['library'][] = 'persian_date/core';
            $element['#attributes']['data-drupal-date-format'] = [$element['#date_date_format']];
        }
        return $element;
    }

}