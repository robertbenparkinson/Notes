<?php

namespace Drupal\ovr_under_construction\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class UnderConstructionController.
 */
class UnderConstructionController extends ControllerBase {


  public function underconstruction_page() {

    return [
      '#theme' => 'ovr_under_construction',
      '#type' => 'markup',
      '#title' => '',
      '#markup' => $this->t('Implement method: underconstruction_page')
    ];
  }

}
