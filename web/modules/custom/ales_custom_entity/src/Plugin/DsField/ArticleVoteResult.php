<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 28/02/2018
 * Time: 09:17
 */

namespace Drupal\ales_custom_entity\Plugin\DsField;

use Drupal\ds\Plugin\DsField\DsFieldBase;

/**
 * Plugin that renders the terms from a chosen taxonomy vocabulary.
 *
 * @DsField(
 *   id = "article_vote_result",
 *   title = @Translation("add review"),
 *   entity_type = "node",
 *   provider = "ales_custom_entity"
 * )
 */
class ArticleVoteResult extends DsFieldBase {

  public function build() {
    $reviews = \Drupal::entityQuery('review')
      ->condition('nid', 1)
      ->execute();
  }
}