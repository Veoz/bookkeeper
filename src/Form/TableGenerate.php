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
      $year_start = [
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
        $year = $year_start;
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
                $start_value_write[] = $val;
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
        if (isset($pattern_period) && $pattern_period != FALSE) {
          $pattern_input = count($pattern_period);
          $chek_period = $pattern_period;
        }
        $test123 = isset($chek_period);
        if ($test123 === FALSE) {
          $form_state->setErrorByName(
            'error',
            $this->t('Invalid empty Check-period!!!!')
          );
          return;
        }
        $month_input = count($chek_period);
        $run = $chek_period;
        $start = array_shift($run);
        $finish = array_pop($run);
        $un_valid_months = array_search($start, $year);
        $start_valid_period = array_slice($year, $un_valid_months);
        $valid_period = array_slice($start_valid_period, 0, $month_input);
        $years_list = array_unique($years_period);
        if (isset($years_pattern, $months_pattern)) {
          if ($pattern_input != $month_input) {
            $form_state->setErrorByName('error', $this->t('Invalid Count'));
          }
          $validate_years = array_diff_assoc($years_pattern, $years_list);
          $years_pattern_count = count($years_pattern);
          $list_years_count = count($years_list);
          if (($years_pattern_count != $list_years_count) || $validate_years != FALSE) {
            $form_state->setErrorByName('error', $this->t('Invalid years'));
            $years_error = "Error";
          }
          else {
            $validate_months = array_diff_assoc($months_pattern, $chek_period);
            if ($validate_months != FALSE) {
              $form_state->setErrorByName('error', $this->t('Invalid months'));
              $months_error = "Error";
            }
          }
        }
        else {
          $test = array_diff_assoc($valid_period, $chek_period);
          if ($test == FALSE && isset($pattern_period)) {
            $months_pattern = $valid_period;
            $years_pattern = $years_list;
//            $create_patterns = TRUE;
          }
          else {
            $valid = FALSE;
            $form_state->setErrorByName(
              'error',
              $this->t('Invalid pre pattern')
            );
            $break = TRUE;
          }
        }
        $chek_period = [];
        $years_period = [];
        if (isset($pattern_period)) {
          $go_next_step = $pattern_period;
          unset($pattern_period);
        }
        $table_start++;
      }
      if (!$form_state->hasAnyErrors()) {
        
//        $a_start_count = $go_next_step;
//        $a_start_months = $start_value_write;
//        $i_months = 0;
        $q1 = [$year_start[0],$year_start[1],$year_start[2], ];
        $q2 = [$year_start[3],$year_start[4],$year_start[5], ];
        $q3 = [$year_start[6],$year_start[7],$year_start[8], ];
        $q4 = [$year_start[9],$year_start[10],$year_start[11], ];
        $q1_values=[];
        $q2_values=[];
        $q3_values=[];
        $q4_values=[];
        foreach ($orders as $tables => $row) {
          for ($i = 0; $i < $row; $i++) {
            foreach ($year_start as $q) {
              $val = $form["100500"]["$i"][$q]['#value'];
              if ((array_search("$q" ,$q1))!==FALSE && $val != ''){
                $q1_values[] =  $val;
              }
              if ((array_search("$q" ,$q2))!==FALSE && $val != ''){
                $q2_values[] =  $val;
              }
              if ((array_search("$q" ,$q3))!==FALSE && $val != ''){
                $q3_values[] =  $val;
              }
              if ((array_search("$q" ,$q4))!==FALSE && $val != ''){
                $q4_values[] =  $val;
              }
              
              $a_count_ytd = $form["100500"]["$i"]['YTD']['#value'];
            }
            $counter = 1;
            $q_values = [$q1_values, $q2_values, $q3_values, $q4_values,];
            
            foreach ($q_values as $lava) {
              //              $res[] = $lava;
              
              $get_q = $form["100500"]["$i"]["Q"."$counter"]['#value'];
              $a_lava_q[] = [$lava,$get_q];
//              if ($lava === [] || $get_q === ''){
              if ($lava === [] ){
                if ( $get_q !== ''){
                  $form_state->setErrorByName('error',$this->t('Invalid! Count false!'));
                }
              }else{
                $start_count_q = array_sum($lava);
                $mid_count_q = (($start_count_q)+1)/3;
                $end_count_q = round($mid_count_q, 2);
                $start_check_q = $end_count_q - $get_q;
                $a_ress[] = $start_check_q;
              }
              
              $counter++;
            }
            
          
            
          }
        }
        
        
        $form_state->set('success', TRUE);
      }
      else {
        $form_state->setErrorByName(
          'error',
          $this->t('Invalid else')
        );
        
        
        
        
      }
    }
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
          if (stristr($months, $isQ) != FALSE) {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
                'class' => ['reports', 'qtd-input'],
                'data-qtd' => $months,
              ],
              '#step' => '0.01',
            ];
            $b++;
            $qtd++;
          }
          elseif (stristr($months, $isYTD) == 'YTD') {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
                'class' => ['reports', 'year-input',],
              ],
              '#step' => '0.01',
            ];
            $b++;
          }
          else {
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

