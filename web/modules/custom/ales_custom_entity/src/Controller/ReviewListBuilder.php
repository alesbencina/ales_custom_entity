<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 19/02/2018
 * Time: 13:44
 */

namespace Drupal\ales_custom_entity\Controller;


use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\node\Entity\Node;

/**
 * Class ReviewListBuilder
 *
 * @package Drupal\ales_custom_entity\Controller
 */
class ReviewListBuilder extends EntityListBuilder {
  public function buildHeader() {
    $header = [];
    $header['title'] = $this->t('Title');
    $header['published'] = $this->t('Published');
    $header['node'] = $this->t('Node');

    return $header + parent::buildHeader();
  }

  /**
   * @param \Drupal\Core\Entity\EntityInterface $review
   *
   * @return array
   * @throws \Drupal\Core\Entity\EntityMalformedException
   */
  public function buildRow(EntityInterface $review) {
    $nodeId = $review->get('nid')->getValue();

    $row = [];
    $row['title'] = $review->toLink($review->getTitle());
    $row['published'] = $review->isPublished() ? $this->t('Yes') : $this->t('No');
    $row['node'] = Node::load($nodeId[0]['target_id'])->toLink();

    return $row + parent::buildRow($review);
  }
}