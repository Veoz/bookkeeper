
public function buildForm(array $form, FormStateInterface $form_state)
{

  $tableName = '100500';
  if($form_state->getTriggeringElement()['#name'] == "add_year"){
    $new_year = $form_state->getTriggeringElement()['#add_field'] + 1;
    $form['actions-top']['button'] = [
      '#type'  => 'button',
      '#name'  => 'add_year',
      '#value' => 'Додати Рік',
      '#add_field' =>  $new_year,
    ];
  }else{

    $form['actions-top']['button'] = [
      '#type'  => 'button',
      '#name'  => 'add_year',
      '#value' => 'Додати Рік',
      '#add_field' => 1,
    ];
  }

  $form[$tableName] = [
    '#type' => 'table',
    '#header' => [t('Year'),
      t('Jan'), t('Feb'), t('Mar'), t('Q1'),
      t('Apr'), t('May'), t('Jun'), t('Q2'),
      t('Jul'), t('Aug'), t('Sep'), t('Q3'),
      t('Oct'), t('Nov'), t('Dec'), t('Q4'),
      t('YTD')],
  ];

  $add_field = $form_state->getTriggeringElement()['#add_field'];

  $year = date('Y');
  // coll count loop
  for ($coll = 0 ;$coll <= $add_field; $coll++) {

    $index = $coll;

    $form[$tableName][$index]['year'] = [
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
        $form[$tableName][$index][$months] = [
          '#type' => 'textfield',
          '#required' => FALSE,
          '#value' => $months,
          '#name' => $months,
          '#attributes' => [
            'readonly' => 'readonly'
          ],
        ];
      }else {
        $form[$tableName][$index][$months] = [
          '#type'     => 'number',
          '#required' => FALSE,
          '#name'     => $months,
        ];
      }
    }
  }
  return $form;

}
