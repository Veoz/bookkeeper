<?php

namespace Drupal\bookkeeper\Controller;

use Drupal\bookkeeper\Form\TableGenerate;
use Drupal\Core\Controller\ControllerBase;

class Table_rr extends ControllerBase {

  public function getFormId() {
    return 'bookkeeper';
  }

  public function table_render(){
    global $base_url;
    $run_render = \Drupal::formBuilder()->getform('Drupal\bookkeeper\Form\TableGenerate');
    return [
      '#theme'       => 'bookkeeper_theme',
      '#run_render' => $run_render,
      '#base_url' => $base_url,
    ];
  }


}
