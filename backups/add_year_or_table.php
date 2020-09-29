<?php


namespace Drupal\bookkeeper\Form;


use Drupal\Core\Form\FormStateInterface;

class add_year_or_table {
  public function getFormID(){
    return 'run_render';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $form = $this->form_skeleton($form, $form_state);
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {}
  public function submitForm(array &$form, FormStateInterface $form_state) {}


  public function  form_skeleton($form, $form_state)
  {
    if($form_state->getTriggeringElement()['#name'] == "new_table"){
      $table_count = $form_state->getTriggeringElement()['#table_count'] + 1;
      $form['actions-bot']['button'] = [
        '#type'  => 'button',
        '#name'  => 'new_table',
        '#value' => 'Add table',
        '#new_table' => 100500,
        '#table_count' =>  $table_count,
      ];
    }else{

      $form['actions-bot']['button'] = [
        '#type'  => 'button',
        '#name'  => 'new_table',
        '#value' => 'Add table',
        '#new_table' => 100500,
        '#table_count' =>  1,
      ];


    }

    $new_table = $form['actions-bot']['button']['#new_table'];

    $table_count = $form['actions-bot']['button']['#table_count'];
    for ($table = 0; $table < $table_count; $table++ ) {

      $table_name = $new_table + $table;
      var_dump($table_name);

      if($form_state->getTriggeringElement()['#name'] == "add_year"){
        $new_year = $form_state->getTriggeringElement()['#add_field'] + 1;
        $form['actions']['button'] = [
          '#type'  => 'button',
          '#name'  => 'add_year',
          '#value' => 'Add year',
          '#add_field' =>  $new_year,

        ];

      }else{
        $form['actions']['button'] = [
          '#type'  => 'button',
          '#name'  => 'add_year',
          '#value' => 'Add year',
          '#add_field' => 1,
        ];
      }
      $add_field = $form['actions']['button']['#add_field'];
      $form[$table_name] = [
        '#type' => 'table',
        '#header' => [t('Year'),
          t('Jan'), t('Feb'), t('Mar'), t('Q1'),
          t('Apr'), t('May'), t('Jun'), t('Q2'),
          t('Jul'), t('Aug'), t('Sep'), t('Q3'),
          t('Oct'), t('Nov'), t('Dec'), t('Q4'),
          t('YTD')],
      ];

      $year = date('Y');
      // coll count loop
      for ($coll = 1 ;$coll <= $add_field; $coll++) {

        $index = $coll - 1;

        $form[$table_name][$index]['year'] = [
          '#type' => 'textfield',
          '#required' => FALSE,
          '#value' => $year,
          '#attributes' => [
            'readonly' => 'readonly'
          ],
        ];
        $year --;
        $seasons = ['jan','feb','mar','Q1','apr','may','jun','Q2','jul','aug','sep','Q3','oct','nov','dec','Q4','YTD',];
        foreach ($seasons as $months){
          $isQ = 'Q';
          $isYTD = 'YTD';
          if (stristr($months, $isQ) != FALSE || stristr($months, $isYTD) == 'YTD'){
            $form[$table_name][$index][$months] = [
              '#type' => 'textfield',
              '#required' => FALSE,
              '#value' => $months,
              '#name' => $months,
              '#attributes' => [
                'readonly' => 'readonly'
              ],
            ];
          }else {
            $form[$table_name][$index][$months] = [
              '#type'     => 'number',
              '#required' => FALSE,
              '#name'     => $months,
            ];
          }
        }
      }
    }
    var_dump($table_count);

    return $form;
  }
}
