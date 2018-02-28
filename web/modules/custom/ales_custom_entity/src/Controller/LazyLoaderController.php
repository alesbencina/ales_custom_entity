<?php

namespace Drupal\ales_custom_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\ales_custom_entity\Entity\Review;

class LazyLoaderController extends ControllerBase {

  /**
   * Example #lazy_builder callback.
   *
   * Demonstrates the use of a #lazy_builder callback to build out a render
   * array that can be substituted into the parent array wherever the cacheable
   * placeholder exists.
   *
   * This method is called during the process of rendering the array generated
   * by \Drupal\render_example\Controller\RenderExampleController::arrays().
   *
   * @param int $user_id
   *   UID of the user currently viewing the page.
   * @param string $date_format
   *   Date format to use with \Drupal\Core\Datetime\DateFormatter::format().
   *
   * @return array
   *   A renderable array with content to replace the #lazy_builder placeholder.
   */
  public static function lazyCallback() {
    $user = \Drupal::currentUser();

    $reviews = \Drupal::entityQuery('review')
      ->condition('owner', $user->id())
      ->execute();
    $reviews = Review::loadMultiple($reviews);

    $view_builder = \Drupal::entityTypeManager()->getViewBuilder('review');
    $b = $view_builder->viewMultiple($reviews);

    $build = [
      'reviews' => [
        '#markup' => render($b),
      ],
    ];

    // In order to demonstrate the use of lazy builders we use sleep here to
    // simulate an expensive request.
    return $build;
  }
}