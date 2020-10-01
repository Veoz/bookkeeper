<?php

namespace Drupal\bookkeeper\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TableGenerate extends FormBase {
  
  
  public function getFormID() {
    return 'run_render';
  }
  
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['#prefix'] = "<div id='test_test'>";
    $form['#suffix'] = "</div>";
    
    if ($form_state->get('last_table_name')) {
      if ($form_state->getTriggeringElement()['#name'] == "add_table") {
        $last_table_name = $form_state->getTriggeringElement(
          )['#last_table_name'] + 1;
        $form_state->set("last_table_name", $last_table_name);
      }
    } else {
      $form_state->set("last_table_name", 100500);
    }
    
    
    if ($form_state->getValue('100500')) {
      $order_list = [];
      for ($n = 100500; $n <= $form_state->get('last_table_name'); $n++) {
        $test = $form_state->getValue($n);
        $form_current_fields = count($test);
        array_push($order_list, $form_current_fields);
      }
    }
    else {
      $order_list[] = 1;
    }
    $form_state->set('order_list', $order_list);
    $form = $this->tableSkeleton($form, $form_state);
    $form['actions-bot']['button'] = [
      '#type' => 'button',
      '#name' => 'add_table',
      '#value' => 'Add table',
      '#last_table_name' => $form_state->get('last_table_name'),
      '#attributes' => ['class' => ["test-test"]],
      '#ajax' => [
        'callback' => '::ajaxSubmitCallback',
        'wrapper' => 'test_test',
      ],
    ];
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
  
  
  public function tableSkeleton($form, $form_state) {
    $first_table = 100500;
//    $new_year = 1;
    $orders = $form_state->get('order_list');
    $i = 0;
    foreach ($orders as $table_set => $field_set) {
      if ($field_set == FALSE) $field_set ++;
      $new_year = $field_set; //!!!
      $table_name = $first_table + $i;
      $actions_name = 'actions_' . $table_name;
      if ($form_state->getTriggeringElement()['#name'] == "add_year{$i}") {
        $new_year = $form_state->getTriggeringElement()['#add_field'] + 1;//!!!
      }
      
      $form[$actions_name]['button'] = [
        '#type' => 'button',
        '#name' => 'add_year' . $i,
        '#value' => 'Add year',
        '#add_field' => $new_year, //!!!
        '#ajax' => [
          'callback' => '::ajaxSubmitCallback',
          'wrapper' => 'test_test',
        ],
      ];
      $add_field = $form[$actions_name]['button']['#add_field'];
      $form[$table_name] = [
        '#type' => 'table',
        '#header' => [
          t('Year'),
          t('Jan'),
          t('Feb'),
          t('Mar'),
          t('Q1'),
          t('Apr'),
          t('May'),
          t('Jun'),
          t('Q2'),
          t('Jul'),
          t('Aug'),
          t('Sep'),
          t('Q3'),
          t('Oct'),
          t('Nov'),
          t('Dec'),
          t('Q4'),
          t('YTD'),
        ],
      ];
      
    
      
      $year = date('Y');
      
      for ($coll = 1; $coll <= $add_field; $coll++) {
        $index = $coll - 1;
        $form[$table_name][$index]['year'] = [
          '#type' => 'textfield',
          '#required' => FALSE,
          '#value' => $year,
          '#attributes' => [
            'readonly' => 'readonly',
          ],
        ];
        $year--;
        $seasons = [
          'jan',
          'feb',
          'mar',
          'Q1',
          'apr',
          'may',
          'jun',
          'Q2',
          'jul',
          'aug',
          'sep',
          'Q3',
          'oct',
          'nov',
          'dec',
          'Q4',
          'YTD',
        ];
        foreach ($seasons as $months) {
          $isQ = 'Q';
          $isYTD = 'YTD';
          if (stristr($months, $isQ) != FALSE || stristr(
              $months,
              $isYTD
            ) == 'YTD') {
            $form[$table_name][$index][$months] = [
              '#type' => 'textfield',
              '#required' => FALSE,
              '#value' => $months,
              '#name' => $months,
              '#attributes' => [
                'readonly' => 'readonly',
              ],
            ];
          }
          else {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#name' => $months,
            ];
          }
        }
      }
      $i++;
    }
    
    return $form;
  }
  public function ajaxSubmitCallback(
    array &$form,
    FormStateInterface $form_state
  ) {
    return $form;
  }
  
  
}

