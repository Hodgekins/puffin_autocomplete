<?php

namespace Drupal\puffin_autocomplete\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "puffin_autocomplete_example",
 *   admin_label = @Translation("Example"),
 *   category = @Translation("Puffin Autocomplete")
 * )
 */
class ExampleBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build['content'] = [
      '#markup' => $this->t('It works!'),
    ];
    return $build;
  }

}
