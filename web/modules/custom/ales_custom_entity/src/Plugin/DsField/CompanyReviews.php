<?php

namespace Drupal\ales_custom_entity\Plugin\DsField;

use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\ds\Plugin\DsField\DsFieldBase;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Url;
use Drupal\user\Entity\User;
use Drupal\Core\Cache\Cache;

/**
 * Plugin that renders the terms from a chosen taxonomy vocabulary.
 *
 * @DsField(
 *   id = "add_review",
 *   title = @Translation("add review"),
 *   entity_type = "node",
 *   provider = "ales_custom_entity"
 * )
 */
class CompanyReviews extends DsFieldBase {

  protected $formController;

  /**
   * {@inheritdoc}
   *
   * The method which should return the result to the field.
   */
  public function build() {
    $currentUser = User::load(\Drupal::currentUser()->id());
    $fieldConfig = $this->getConfiguration();
    $id = $fieldConfig['entity']->id();
    $nids = \Drupal::entityQuery('review')
      ->condition('nid', $id)
      ->condition('owner', $currentUser->id())
      ->execute();

    if (count($nids) > 0) {
      $content['review_added_already'] = [
        '#type' => 'markup',
        '#markup' => 'You have already gave review.',
      ];
    }
    else {
      //get node id, search in reviews for node and check if current logged in user ID exists
      $content['build'] = [
        '#type' => 'link',
        '#title' => $this->t('Add Recommendation'),
        '#url' => Url::fromRoute('ales_custom_entity.recommendation.add_recommendation', [
            'node_id' => $id,
            'review_type' => $fieldConfig['entity']->getType() . '_review',
          ]
        ),
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => Json::encode([
            'width' => 700,
          ]),
          'id' => 'add_recommendation_link',
        ],
        '#cache' => [
          'contexts' => ['url.path'],
          'tags' => ['node:' . $id]
        ],
      ];
    }
    /*
     *   '#cache' => [
          'contexts' => ['url.path'],
          'tags' => ['node:' . $id]
        ],
     * */

    return $content;

  }


}