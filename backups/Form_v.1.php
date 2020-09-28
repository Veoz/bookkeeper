<?php

namespace Drupal\bookkeeper\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TableGenerate extends FormBase{



  public function getFormID(){

    return 'run_render';

  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $tableName = 'bookkeeper';
    $form[$tableName] = [
      '#type' => 'table',
      '#header' => [t('Year'),
        t('Jan'), t('Feb'), t('Mar'), t('Q1'),
        t('Apr'), t('May'), t('Jun'), t('Q2'),
        t('Jul'), t('Aug'), t('Sep'), t('Q3'),
        t('Oct'), t('Nov'), t('Dec'), t('Q4'),
        t('YTD')],
    ];

    $form['actions']['button'] = [
      '#type'  => 'button',
      '#name'  => 'add_year',
      '#value' => 'Додати Рік',
      '#add_field' => 1,
      '#ajax'  => [
        'callback' => '::ajaxSubmitCallback',
        'event'    => 'click',

      ],
    ];

    if($form_state->getTriggeringElement()['#name'] == "add_year"){
      $add_field =  $form_state->getTriggeringElement()['#add_field'];
      $add_field ++;
    }else{
      $add_field =  1;
    }
    $year = date('Y');
    // coll count loop
    for ($coll = 1 ;$coll <= $add_field; $coll++) {

      $index = $coll - 1;

      $form[$tableName][$index]['year'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => $year,
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];

      $year --;

      $form[$tableName][$index]['jan'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'jan',

      ];
      $form[$tableName][$index]['feb'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'feb',
      ];
      $form[$tableName][$index]['mar'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'mar',
      ];
      $form[$tableName][$index]['Q1'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => 'Q1',
        '#name' => 'Q1',
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];
      $form[$tableName][$index]['apr'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'apr',
      ];
      $form[$tableName][$index]['may'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'may',
      ];
      $form[$tableName][$index]['jun'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'jun',
      ];
      $form[$tableName][$index]['Q2'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => 'Q2',
        '#name' => 'Q2',
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];
      $form[$tableName][$index]['jul'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'jul',
      ];
      $form[$tableName][$index]['aug'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'aug',
      ];
      $form[$tableName][$index]['sep'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'sep',
      ];
      $form[$tableName][$index]['Q3'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => 'Q3',
        '#name' => 'Q3',
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];
      $form[$tableName][$index]['oct'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'oct',
      ];
      $form[$tableName][$index]['nov'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'nov',
      ];
      $form[$tableName][$index]['dec'] = [
        '#type' => 'number',
        '#required' => FALSE,
        '#name' => 'dec',

      ];
      $form[$tableName][$index]['Q4'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => 'Q4',
        '#name' => 'Q4',
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];
      $form[$tableName][$index]['YTD'] = [
        '#type' => 'textfield',
        '#required' => FALSE,
        '#value' => 'YTD',
        '#name' => 'YTD',
        '#attributes' => [
          'readonly' => 'readonly'
        ],
      ];

    }



    return $form;

  }
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }
  public function submitForm(array &$form, FormStateInterface $form_state) {

  }
  public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state) {
    return $form;
  }



}

