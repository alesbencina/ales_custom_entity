<?php

namespace Drupal\ales_custom_entity\Form;

use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\CloseModalDialogCommand;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\views\Views;
use Drupal\ales_custom_entity\Plugin\Block\LazyLoadedBlock;
use Drupal\block\Entity\Block;

class ReviewForm extends ContentEntityForm {

  protected $nodeId;

  protected $view;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'modal_form_example_modal_form';
  }

  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $this->nodeId = $entity->get('nid')->target_id;
    $entity->save();
    /*
       $entity = $this->getEntity();
       $entity_type = $entity->getEntityType();

       $arguments = [
         '@entity_type' => $entity_type->getLowercaseLabel(),
         '%entity' => $entity->label(),
         'link' => $entity->toLink($this->t('View'), 'canonical')->toString(),
       ];

       $this->logger($entity->getEntityTypeId())
         ->notice('The @entity_type %entity has been saved.', $arguments);
       drupal_set_message($this->t('The @entity_type %entity has been saved.', $arguments));

       $form_state->setRedirect('entity.node.canonical', ['node' => $entity->get('nid')->target_id]);
    */
  }


  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $form['#prefix'] = "<div id=\"{$this->getFormId()}-wrapper\">";
    $form['#suffix'] = '</div>';

    $form['actions']['submit']['#ajax'] = [
      'wrapper' => $this->getFormId() . '-wrapper',
      'callback' => [$this, 'ajaxRebuildCallback'],
      'effect' => 'fade',
    ];

    $form['actions']['alt_button'] = [
      '#type' => 'submit',
      '#value' => t('Close'),
      '#ajax' => [
        'wrapper' => $this->getFormId() . '-wrapper',
        'callback' => [$this, 'closeForm'],
        'effect' => 'fade',
      ],
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * Callback for ajax form submission.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The rebuilt form.
   */
  public function ajaxRebuildCallback(array $form, FormStateInterface $form_state) {
    if (count($form_state->getErrors()) > 0) {
      return $form;
    }

    return $this->closeForm();
  }

  public function closeForm() {
    $response = new AjaxResponse();
    $command = new CloseModalDialogCommand();
    $response->addCommand($command);

    //VIEW block
    $view = Views::getView('article_reviews');
    $args = [$this->nodeId];
    $view->setArguments($args);
    $view->setDisplay('block_1');
    $view->preExecute();
    $view->execute();

    $content = $view->buildRenderable('block_1', $args);

    $response->addCommand(new HtmlCommand('#block-views-block-article-reviews-block-1 .content', $content));
    $response->addCommand(new ReplaceCommand('#add_recommendation_link', 'Added review!'));

    //normal block
    $block = Block::load('myreviews');
    $rndr = \Drupal::entityTypeManager()
      ->getViewBuilder('block')
      ->view($block);
    $r = render($rndr);

    $response->addCommand(new ReplaceCommand('#block-myreviews', $r));

    Cache::invalidateTags(['node:' . $this->nodeId]);

    return $response;
  }

}
