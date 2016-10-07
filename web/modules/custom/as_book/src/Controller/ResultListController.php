<?php

namespace Drupal\as_book\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ResultListController.
 *
 * @package Drupal\as_book\Controller
 */
class ResultListController extends ControllerBase {

  /**
   * Booklistingresearchfound.
   *
   * @return string
   *   Return Hello string.
   */
  public function bookListingResearchFound() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: bookListingResearchFound')
    ];
  }

}
