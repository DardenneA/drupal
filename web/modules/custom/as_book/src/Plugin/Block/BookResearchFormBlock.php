<?php

namespace Drupal\as_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'BookResearchFormBlock' block.
 *
 * @Block(
 *  id = "book_research_form_block",
 *  admin_label = @Translation("Book research form block"),
 * )
 */
class BookResearchFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $form = \Drupal::formBuilder()->getForm('\Drupal\as_book\Form\BookResearchForm');

    $build = [];
    $build['book_research_form_block'] = $form;


    return $build;
  }

}
