<?php

namespace Drupal\bookkeeper\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class TableGenerate extends FormBase {
  
  public function getFormID() {
    return 'run_render';
  }
  
  /**
   * This function creates  buttons and call "table_sceleton()" function,
   * for create tables, rows (years area), and cells (fields area).
   *
   * @param   array                                 $form
   * @param   \Drupal\Core\Form\FormStateInterface  $form_state
   *
   * @return array
   */
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
      //Order list is an array where contains number of tables that was created.
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
    //Call "table skeleton" function, for build forms (tables)
    $form = $this->tableSkeleton($form, $form_state);
    //Here creates buttons "Add table" and "Submit" and its attributes.
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
  
  /**
   * This function is validate the period of input cells
   * and calculate of quarters and years.
   *
   * @param   array                                 $form
   * @param   \Drupal\Core\Form\FormStateInterface  $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getTriggeringElement()['#name'] == "run") {
      //years_start is example sequence of months for check, period from cells.
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
      //This loop return number of tables and cell for starts validate
      foreach ($order1 as $values => $fields) {
        $count_fields = count($fields);
        $orders[] = $count_fields;
      }
      $table_start = 100500; // name of first table
      //START PERIODS checks
      //first loop work with tables, and change tables name
      foreach ($orders as $tables => $row) {
        $year = $year_start;
        //second loop work with rows of tables, and change number of row
        for ($i = 0; $i < $row; $i++) {
          //third loop work with cell of table and take value from there, for work with it
          foreach ($year as $q) {
            //this code will works if first table is on queue to validate. result will the pattern for validate other tables.
            if ($table_start == 100500) {
              $val = $form["100500"]["$i"][$q]['#value'];
              if ($val === '') {
                continue;
              }
              else {
                $pattern_period[] = $q;
                $years_to_string = $form["100500"]["$i"]['year']['#value'];
                $years_period["$i"] = "$years_to_string";
              }
            }
            // Here we take information from other tables for validate
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
        //if number of tables rows more that one, we add months to example array "years_start[]"
        if ($row > 1) {
          $shortage = ($row - 1) * 12;
          for ($m = 0; $m < $shortage; $m++) {
            $year[] = $year[$m];
          }
        }
        if (isset($pattern_period) && $pattern_period != FALSE) {
          $pattern_input = count(
            $pattern_period
          ); // value for validate number of filled cells
          $chek_period = $pattern_period; // if it is first table, we must validate pattern
        }
        $test123 = isset($chek_period); // if all cells is empty, prints the error!
        if ($test123 === FALSE) {
          $form_state->setErrorByName(
            'error',
            $this->t('Invalid')
          );
          return;
        }
        //START validate of periods
        $month_input = count($chek_period);
        $run = $chek_period;
        $start = array_shift($run);
        $finish = array_pop($run);
        $un_valid_months = array_search($start, $year);
        $start_valid_period = array_slice($year, $un_valid_months);
        $valid_period = array_slice($start_valid_period, 0, $month_input);
        $years_list = array_unique($years_period);
        // if we was build pattern earlier, now we go to validate others tables
        if (isset($years_pattern, $months_pattern)) {
          // it is validate of numbers of full cells
          if ($pattern_input != $month_input) {
            $form_state->setErrorByName('error', $this->t('Invalid'));
          }
          //it is validate of full cells in year rows
          $validate_years = array_diff_assoc($years_pattern, $years_list);
          $years_pattern_count = count($years_pattern);
          $list_years_count = count($years_list);
          if (($years_pattern_count != $list_years_count) || $validate_years != FALSE) {
            $form_state->setErrorByName('error', $this->t('Invalid'));
          }
          else {
            //it is validate of the months period by pattern period array
            $validate_months = array_diff_assoc($months_pattern, $chek_period);
            if ($validate_months != FALSE) {
              $form_state->setErrorByName('error', $this->t('Invalid'));
            }
          }
        }
        else {
          //it is validate of the pattern
          $test = array_diff_assoc($valid_period, $chek_period);
          if ($test == FALSE && isset($pattern_period)) {
            $months_pattern = $valid_period;
            $years_pattern = $years_list;
          }
          else {
            // Error create pattern
            $form_state->setErrorByName(
              'error',
              $this->t('Invalid')
            );
          }
        }
        $chek_period = [];    //resetting working arrays
        $years_period = [];
        if (isset($pattern_period)) {
          $go_next_step = $pattern_period;
          unset($pattern_period);
        }
        $table_start++;
      }
      //END period validate
      //START validate calculations
      if (!$form_state->hasAnyErrors()) {
        //if we don't have errors of validate periods. We start validate calculations.
        // Create working arrays
        $q1 = [$year_start[0], $year_start[1], $year_start[2],];
        $q2 = [$year_start[3], $year_start[4], $year_start[5],];
        $q3 = [$year_start[6], $year_start[7], $year_start[8],];
        $q4 = [$year_start[9], $year_start[10], $year_start[11],];
        $q1_values = [];
        $q2_values = [];
        $q3_values = [];
        $q4_values = [];
        //Three loops work as in validate of period
        foreach ($orders as $tables => $row) {
          $table_start_count = 100500 + $tables;
          for ($i = 0; $i < $row;) {
            foreach ($year_start as $q) {
              //here we group the months values in cells of table in quarters
              $val = $form["$table_start_count"]["$i"][$q]['#value'];
              if ((array_search("$q", $q1)) !== FALSE && $val != '') {
                $q1_values[] = $val;
              }
              if ((array_search("$q", $q2)) !== FALSE && $val != '') {
                $q2_values[] = $val;
              }
              if ((array_search("$q", $q3)) !== FALSE && $val != '') {
                $q3_values[] = $val;
              }
              if ((array_search("$q", $q4)) !== FALSE && $val != '') {
                $q4_values[] = $val;
              }
            }
            $counter = 1;
            $q_values = [$q1_values, $q2_values, $q3_values, $q4_values,];
            //here we validate calculation
            foreach ($q_values as $lava) {
              $get_q = $form["$table_start_count"]["$i"]["Q" . "$counter"]['#value'];
              $a_lava_q[] = [$lava, $get_q];
              if ($lava == []) {
                if ($get_q !== '') {
                  // error, because was empty quarter area
                  $form_state->setErrorByName(
                    'error',
                    $this->t('Invalid!')
                  );
                }
              }
              //start of calculate quarters
              $start_count_q = array_sum($lava);
              $a_starter[] = $start_count_q;
              if ($get_q == 0.00 && $start_count_q == 0) {
                $mid_check_q = 0.00;
                $end_count_q = 0.00;
              }
              else {
                $mid_count_q = (($start_count_q) + 1) / 3;
                $end_count_q = round($mid_count_q, 2);
                $start_check_q = $get_q - $end_count_q;
                $mid_check_q = round($start_check_q, 2);
              }
              if ($get_q <= 0.05 || $get_q < -0.05) {
                $mid_check_q = 0.00;
                $end_count_q = $get_q;
              }
              if ($mid_check_q != 0.00) {
                $min = $end_count_q - 0.05;
                $max = $end_count_q + 0.05;
                $aaa_ress[] = [$min, $max];
                if ($get_q < $min || $get_q > $max) {
                  //error, quarter result correction limit exceeded
                  $form_state->setErrorByName(
                    'error',
                    $this->t('Invalid!')
                  );
                }
              }
              if ($end_count_q == '') {
                $end_count_q = 0;
              }
              $qrt[] = $end_count_q;
              if (count($qrt) === 4) {
                $sum_qrt = array_sum($qrt);
                if ($sum_qrt > 0) {
                  $sum_qrt = round($sum_qrt, 2);
                  $ytd_pattern = ((($sum_qrt) + 1) / 4);
                  $ytd_pattern = round($ytd_pattern, 2);
                  $get_ytd = $form["$table_start_count"]["$i"]["YTD"]['#value'];
                  if (($ytd_pattern + 0.05) < $get_ytd || ($ytd_pattern - 0.05) > $get_ytd) {
                    //error, Year result correction limit exceeded
                    $form_state->setErrorByName(
                      'error',
                      $this->t('Invalid!')
                    );
                  }
                  $all_qrt[] = $ytd_pattern;
                }
                unset($qrt);
              }
              $count_lava[] = $lava;
              unset($start_count_q);
              $counter++;
            }
            $q1_values = [];
            $q2_values = [];
            $q3_values = [];
            $q4_values = [];
            $i++;
          }
          $a_t[] = $table_start_count;
        }
        
        $form_state->set('success', TRUE);
      }
      else {
        $form_state->setErrorByName(
          'error',
          $this->t('Invalid')
        );
      }
    }
  }
  
  /**
   * @param   array                                 $form
   * @param   \Drupal\Core\Form\FormStateInterface  $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->get('success')) {
      \Drupal::messenger()->addMessage($this->t("Valid!"), 'status');
    }
  }
  
  /**
   * This function is body of table, it help create tables,
   * rows, and cells for "build form" function.
   *
   * @param $form
   * @param $form_state
   *
   * @return mixed
   */
  public function tableSkeleton($form, $form_state) {
    $first_table = 100500;
    $orders = $form_state->get('order_list');
    $i = 0;
    //first loop is create tables
    foreach ($orders as $table_set => $field_set) {
      if ($field_set == FALSE) {
        $field_set++;
      }
      $new_year = $field_set;
      $table_name = $first_table + $i;
      $actions_name = 'actions_' . $table_name;
      //button for adds rows (years) (save information about number of rows)
      if ($form_state->getTriggeringElement()['#name'] == "add_year{$i}") {
        $new_year = $form_state->getTriggeringElement()['#add_field'] + 1;
      }
      $form[$actions_name]['button'] = [
        '#type' => 'button',
        '#name' => 'add_year' . $i,
        '#value' => 'Add year',
        '#add_field' => $new_year,
        '#ajax' => [
          'callback' => '::ajaxSubmitCallback',
          'wrapper' => 'test_test',
        ],
      ];
      $add_field = $form[$actions_name]['button']['#add_field'];
      //header of table
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
      //second loop is create  years area (rows of table)
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
  
  /**
   * @param   array                                 $form
   * @param   \Drupal\Core\Form\FormStateInterface  $form_state
   *
   * @return array
   */
  public function ajaxSubmitCallback(
    array &$form,
    FormStateInterface $form_state
  ) {
    return $form;
  }
  
}
