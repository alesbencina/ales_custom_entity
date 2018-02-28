<?php

namespace Drupal\ales_custom_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Url;
use Drupal\Component\Serialization\Json;
use Drupal\ales_custom_entity\Entity\Review;

class RecommendationController extends ControllerBase {

  public function content(Request $request) {
  }

  //parameter isti id kot v routing!!!
  public function getReviewForm($node_id, $review_type) {
    //rating - dropdownlist, in da na company list pokažem povprečje
    $review = $this->entityTypeManager()->getStorage('review')->create([
      'nid' => $node_id, //isto kot v entity
      'type' => $review_type,
      'title' => $review_type,
    ]);

    $formObject = $this->entityTypeManager()
      ->getFormObject('review', 'add')
      ->setEntity($review);

    $build = $this->formBuilder()->getForm($formObject);

    return $build;

  }

}