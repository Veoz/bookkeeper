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
    }
    else {
      $form_state->set("last_table_name", 100500);
    }
    if ($form_state->getValue('100500')) {
      $order_list = [];
      for ($n = 100500; $n <= $form_state->get('last_table_name'); $n++) {
        $test = $form_state->getValue($n);
        $form_current_fields = count($test);
        $order_list[] = $form_current_fields;
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
    $form['submit'] = [
      '#type' => 'submit',
      '#name' => 'run',
      '#value' => 'Submit',
    ];
    return $form;
  }
  
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getTriggeringElement()['#name'] == "run") {
      $year = [
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'jun',
        'jul',
        'aug',
        'sep',
        'oct',
        'nov',
        'dec',
      ];
      
      for ($n = 100500; $n <= $form_state->getValue("$n"); $n++) {
        if (!$form_state->getValue("$n")) {
          break;
        }
        $order1[] = $form_state->getValue("$n");
      }
      $order2 = count($order1);
      foreach ($order1 as $values => $fields) {
        $count_fields = count($fields);
        $orders[] = $count_fields;
      }
      $table_start = 100500;
      foreach ($orders as $tables => $row) {

        $year = [
          'jan',
          'feb',
          'mar',
          'apr',
          'may',
          'jun',
          'jul',
          'aug',
          'sep',
          'oct',
          'nov',
          'dec',
        ];
        for ($i = 0; $i < $row; $i++) {
          foreach ($year as $q) {
            if ($table_start == 100500) {
              $val = $form["100500"]["$i"][$q]['#value'];
              if ($val === '') {
                continue;
              }
              else {
                $pattern_period[] = $q;
                $years_to_string = $form["100500"]["$i"]['year']['#value'];
                $years_period["$i"] = "$years_to_string";
                $audit_false_ye[] = [$table_start => $years_period];
              }
            }
            if ($table_start > 100500) {
              $val = $form["$table_start"]["$i"][$q]['#value'];
              if ($val === '') {
                continue;
              }
              else {
                $chek_period[] = $q;
                $years_to_string = $form["$table_start"]["$i"]['year']['#value'];
                $years_period["$i"] = "$years_to_string";
                $audit_true_ye[] = [$table_start => $years_period];
              }
            }
          }
        }
        if ($row > 1) {
          $shortage = ($row - 1) * 12;
          for ($m = 0; $m < $shortage; $m++) {
            $year[] = $year[$m];
          }
        }
        
        if (isset($pattern_period) && $pattern_period != FALSE){
          $pattern_input = count($pattern_period);
          $chek_period = $pattern_period;
        }
        $test123 = isset($chek_period);
        if ($test123 === FALSE) {
          $form_state->setErrorByName(
            'error',
            $this->t('Invalid empty Check-period!!!!'));
          return;
        }
        
        $month_input = count($chek_period);
        $run = $chek_period;
        $start = array_shift($run);
        $finish = array_pop($run);
        $un_valid_months = array_search($start, $year);
        $start_valid_period = array_slice($year, $un_valid_months);
        $valid_period = array_slice($start_valid_period, 0, $month_input);
//        $auditor_un_flipp[] = [ $table_start => $valid_period];
//        $audit_flip = array_flip($valid_period);
//        $auditor_flip_on[] = [ $table_start => $valid_period];
        $years_list = array_unique($years_period);
//        if (isset($years_pattern) && isset($months_pattern) && isset($pattern_input)) {
        if (isset($years_pattern, $months_pattern)) {
          
          if ($pattern_input != $month_input){
            $form_state->setErrorByName('error', $this->t('Invalid Count'));
          }
          $validate_years = array_diff_assoc($years_pattern, $years_list);
          $years_pattern_count = count($years_pattern);
          $list_years_count = count($years_list);
          $auie_year[] =[$table_start => [$validate_years]];
          $audir_arr_year[] = [$table_start =>[$years_pattern , $years_list]];
//          if ($validate_years != FALSE ) {
          if (($years_pattern_count != $list_years_count) || $validate_years != FALSE) {
            $form_state->setErrorByName('error', $this->t('Invalid years'));
            $years_error = "Error";
            //break;
          }else{
            $validate_months = array_diff_assoc($months_pattern, $chek_period);
            $auditor_valid_assoc[] = [$table_start =>$validate_months];
            if ($validate_months != FALSE) {
              $form_state->setErrorByName('error', $this->t('Invalid months'));
              $months_error = "Error";
              //break;
            }
          }
          
        }
        else {
          $test = array_diff_assoc($valid_period, $chek_period);
          if ($test == FALSE && isset($pattern_period)) {
            $months_pattern = $valid_period;
            $years_pattern = $years_list;
            $create_patterns = TRUE;
          }
          else {
            $valid = FALSE;
            $form_state->setErrorByName(
              'error',
              $this->t('Invalid pre pattern')
            );
            $break = TRUE;
          }
          //$form_state->set('success', TRUE);
        }
        
        $chek_period = [];
        $years_period = [];
        if (isset($pattern_period)){
          unset($pattern_period);
        }
//        $pattern_period = [];
        $table_start ++;
      }
      if (!$form_state->hasAnyErrors()) {
        $form_state->set('success', TRUE);
      }else{
        $form_state->setErrorByName('error',$this->t('Invalid else')
        );
      }
    }
    $form['100500'][0]['jan']['#value'];
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->get('success')) {
      \Drupal::messenger()->addMessage($this->t("Valid!"), 'status');
    }
  }
  
  public function tableSkeleton($form, $form_state) {
    $first_table = 100500;
    $orders = $form_state->get('order_list');
    $i = 0;
    foreach ($orders as $table_set => $field_set) {
      if ($field_set == FALSE) {
        $field_set++;
      }
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
            'class' => ['year'],
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
        $b = 1;
        $qtd = 1;
        foreach ($seasons as $months) {
          
          
          $isQ = 'Q';
          $isYTD = 'YTD';
          if (stristr($months, $isQ) != FALSE){
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
                'class' => ['reports','qtd-input'],
                'data-qtd' => $months,
              ],
              '#step' => '0.01',
            ];
            $b++;
            $qtd++;
          }
          elseif(stristr($months,$isYTD) == 'YTD')  {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
                'class' => ['reports', 'year-input', ],
              ],
              '#step' => '0.01',
            ];
            $b++;
          }else{
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
               'class' => ['month-input'],
               'data-month' => $b,
               'data-qtd' => 'Q' . $qtd,
            ],
              '#step' => '0.01',
            ];
            $b++;
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

