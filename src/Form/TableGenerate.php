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
    $table_count = 1;
    
    if ($form_state->getTriggeringElement()['#name'] == "first_table") {
      $table_count = $form_state->getTriggeringElement()['#table_count'] + 1;
    }
    $form['actions-bot']['button'] = [
      '#type' => 'button',
      '#name' => 'first_table',
      '#value' => 'Add table',
      '#table_count' => $table_count,
      '#attributes' => ['class' => ["test-test"]],
      '#ajax' => [
        'callback' => '::ajaxSubmitCallback',
        'wrapper' => 'test_test',
      ],
    ];
    $table_count = $form['actions-bot']['button']['#table_count'];
    $this->tableSkeleton($form, $form_state, $table_count);
    return $form;
  }
  
  public function validateForm(array &$form, FormStateInterface $form_state) {
  }
  
  public function submitForm(array &$form, FormStateInterface $form_state) {
  }
  
  
  public function tableSkeleton(
    &$form,
    $form_state,
    $table_count = 1
  ) {
    $first_table = 100500;
    $new_year = 1;
    for ($i = 0; $i < $table_count; $i++) {
      $table_name = $first_table + $i;
      $actions_name = 'actions' . $table_name;
      if ($form_state->getTriggeringElement()['#name'] == "add_year") {
        $new_year = $form_state->getTriggeringElement()['#add_field'] + 1;
      }
      $form[$actions_name]['button'] = [
        '#type' => 'button',
        '#name' => 'add_year',
        '#value' => 'Add year',
        '#add_field' => $new_year,
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
      $form = $this->tableRow(
        $form,
        $table_name,
        $add_field
      );
    }
  }
  
  public function tableRow($form, $table_name, $add_field) {
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
    return $form;
  }
  
  public function ajaxSubmitCallback(
    array &$form,
    FormStateInterface $form_state
  ) {
    return $form;
  }
  
  
}

