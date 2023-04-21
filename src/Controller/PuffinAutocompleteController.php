<?php

namespace Drupal\puffin_autocomplete\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Returns responses for Gtec routes.
 */
class PuffinAutocompleteController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $search_query = \Drupal::request()->get('q');

    $ids = \Drupal::entityQuery('node')
      ->condition('type', 'course')
      ->condition('title',  $search_query, 'CONTAINS')
      ->accessCheck(FALSE)
      ->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);

    $results = [];
    foreach($nodes as $node) {
      $results[] = [
        "title" => $node->get("title")->value,
        "url" => $node->toUrl('canonical')->toString(),
      ];
    }

    return new JsonResponse($results);
  }

}

