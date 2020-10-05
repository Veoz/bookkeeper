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
    
    $orders = $form_state->get('order_list');
    $fixik  = array_key_last($orders);
    $orders[$fixik]++;
    $chek_period = [];
    foreach ($orders as $tables => $row) {
      if ($row == 0) {
        $row++;
      }
      for ($i = 0; $i < $row; $i++) {
        foreach ($year as $q) {
          // we take one input from table
          $val = $form['100500'][$i][$q]['#value'];
          //And check! it is empty or not.
          
          if ($val != '') {
            //if not -> add to array!
            $chek_period[] = $q;
            
          }
          else {
            continue;
          }
        }
      }
      //$check_period is contains index => value;
      //where index is (int) => value is name of month (string)
      $month_input = count($chek_period);
      
      // we find first and last months input
      $run = $chek_period;
      $start = array_shift($run);
      $finish = array_pop($run);
      
      //if empty months > 1 -> we go to check periods!
      if ($start != 'dec') {
        //start creating validate Pattern (array)
        //step one - cut start of array ($start = first input months)
        $un_valid_months = array_search($start, $year);
        //$un_valid_months contains array, without empty field from start year
        $start_valid_period = array_slice($year, $un_valid_months);
        
        //stet two - cut end of array
        //We use number of count of input months for cut end from array
        $valid_period = array_slice($start_valid_period, 0, $month_input);
        
        //$valid_period - contains ordered list of months.
        // We ned to swap value with key for start validation.
        array_flip($valid_period);
        
        //$test returns name of the missed month or false.
        $test = array_diff($valid_period, $chek_period);
        if ($test != FALSE) {
          $valid = FALSE;
          $form_state->setErrorByName('error', $this->t('Invalid'));
          $break = TRUE;
        }
        else {
          $pattern[] = $valid_period;
          $valid1 = TRUE;
        }
      }
      else {
        $valid2 = TRUE;
        $pattern[] = 'dec';
      }
      
      
      // Loop for all months
      // we find empty inputs in table
      
      
    }
    $form['100500'][0]['jan']['#value'];
    
    //  $check_periods = $form_state->getValue('100500');
    // foreach ($check_periods as $period){
    //   $a =  $period;
    //  // in_array();
    // }
    //  $month = $check_period[0]['jan'];
    
    
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
        foreach ($seasons as $months) {
          $isQ = 'Q';
          $isYTD = 'YTD';
          if (stristr($months, $isQ) != FALSE || stristr(
              $months,
              $isYTD
            ) == 'YTD') {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
              '#attributes' => [
                'class' => ['reports'],
              ],
            ];
          }
          else {
            $form[$table_name][$index][$months] = [
              '#type' => 'number',
              '#required' => FALSE,
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

