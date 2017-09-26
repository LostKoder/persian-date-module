<?php
/**
 * Created by PhpStorm.
 * User: evolve
 * Date: 9/26/17
 * Time: 8:41 PM
 */

namespace Drupal\persian_date\Element;


use Drupal\Core\Datetime\Element\Datetime;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Annotation\FormElement;

/**
 * Class PersianDateTime
 * @package Drupal\persian_date\Element
 * @FormElement("persian_datetime")
 */
class PersianDateTime extends Datetime
{
    public static function processDatetime(&$element, FormStateInterface $form_state, &$complete_form)
    {
        $element = parent::processDatetime($element, $form_state, $complete_form);
        $element['date']['#type'] = 'persian_date';
        $element['time']['#type'] = 'persian_date';
        return $element;
    }

}