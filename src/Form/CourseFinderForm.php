<?php

namespace Drupal\puffin_autocomplete\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\BubbleableMetadata;
use Drupal\Core\Url;

/**
 * Provides a form.
 */
class CourseFinderForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'puffin_autocomplete_course_finder';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['course_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Course search'),
      '#description' => $this->t('What do you want to study?'),
      '#required' => TRUE,
      '#puffin_autocomplete_route_name' => 'puffin_autocomplete.autocomplete',
      '#theme' => 'course_finder_input',
    ];
    $form['course_name']['#process'][] = [
      $this,
      'courseFinderAutocomplete',
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Search'),
    ];
    $form['actions']['submit']['#attributes']['class'][] = 'ms-md-4';
    $form['actions']['submit']['#attributes']['class'][] = 'btn-lg';

    $form['#description_display']['attributes']['class'][] = 'mt-5';

    $form['#attached']['library'][] = 'puffin_autocomplete/autocomplete';
    $form['#theme'] = 'course_finder';

    return $form;
  }

  /**
   * Similar to Drupal core's processAutocomplete function but uses our own library
   */
  public static function courseFinderAutocomplete(&$element, FormStateInterface $form_state, &$complete_form) {

    $url = Url::fromRoute($element['#puffin_autocomplete_route_name'])->toString(TRUE);
    $element['#attributes']['data-puffin-autocomplete-path'] = $url->getGeneratedUrl();

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $path_param = [
      'title' => $form_state->getValue('course_name'),
    ];
    $url = Url::fromUserInput('/course-search', ['query' => $path_param]);
    $form_state->setRedirectUrl($url);
  }

}
