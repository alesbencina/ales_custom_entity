<?php

namespace Drupal\ales_custom_entity\Controller;


use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

class ReviewTypeListBuilder extends EntityListBuilder {
  public function buildHeader() {
    $header = [];
    $header['label'] = $this->t('label');
    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $review) {
    /** @var \Drupal\event\Entity\EventInterface $review */
    $row = [];
    $row['label'] = $review->label();
    return $row + parent::buildRow($review);
  }
}