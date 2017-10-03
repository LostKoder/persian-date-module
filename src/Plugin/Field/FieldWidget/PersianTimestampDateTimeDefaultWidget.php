<?php

namespace Drupal\persian_date\Plugin\Field\FieldWidget;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Datetime\Element\Datetime;
use Drupal\Core\Datetime\Entity\DateFormat;
use Drupal\Core\Datetime\Plugin\Field\FieldWidget\TimestampDatetimeWidget;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\persian_date\Element\PersianDateTime;
use Drupal\persian_date\Plugin\Datetime\PersianDrupalDateTime;

/**
 * Plugin implementation of the 'datetime_default' widget.
 *
 * @FieldWidget(
 *   id = "datetime_timestamp",
 *   label = @Translation("Datetime Timestamp"),
 *   field_types = {
 *     "timestamp",
 *     "created",
 *   }
 * )
 */
class PersianTimestampDateTimeDefaultWidget extends TimestampDatetimeWidget
{
    public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state)
    {
        $date_format = DateFormat::load('html_date')->getPattern();
        $time_format = DateFormat::load('html_time')->getPattern();
        $drupalDate = DrupalDateTime::createFromTimestamp((int)$items[$delta]->value);
        $default_value = isset($items[$delta]->value) ? PersianDrupalDateTime::createFromDrupalDateTime($drupalDate) : '';
        $element['value'] = $element + [
                '#type' => 'datetime',
                '#default_value' => $default_value,
            ];
        $element['value']['#description'] = $this->t('Format: %format. Leave blank to use the time of form submission.', ['%format' => PersianDateTime::formatExample($date_format . ' ' . $time_format)]);

        return $element;
    }

}
