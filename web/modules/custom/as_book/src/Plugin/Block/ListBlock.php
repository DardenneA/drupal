<?php

namespace Drupal\as_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ListBlock' block.
 *
 * @Block(
 *  id = "list_block",
 *  admin_label = @Translation("List block"),
 * )
 */
class ListBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $build['list_block']['#markup'] = 'Implement ListBlock.';

    return $build;
  }

}
