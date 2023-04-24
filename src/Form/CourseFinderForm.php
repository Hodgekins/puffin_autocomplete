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
      '#value' => $this->t('Send'),
    ];

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
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('message')) < 10) {
      $form_state->setErrorByName('message', $this->t('Message should be at least 10 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The message has been sent.'));
    $form_state->setRedirect('<front>');
  }

}
