<?php

namespace Drupal\puffin_autocomplete\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "puffin_autocomplete_course_finder",
 *   admin_label = @Translation("Course finder"),
 *   category = @Translation("Puffin Autocomplete")
 * )
 */
class CourseFinderBlock extends BlockBase {

  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\puffin_autocomplete\Form\CourseFinderForm');

    return $form;
  }
}
