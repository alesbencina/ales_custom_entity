<?php

namespace Drupal\ales_custom_entity\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\ales_custom_entity\Controller\LazyLoaderController;
/**
 * Provides a block which describe how many stars have event.
 *
 * @Block(
 *   id = "my_reviews",
 *   admin_label = @Translation("My reviews"),
 *   category = @Translation("My rev")
 * )
 */
class LazyLoadedBlock extends BlockBase {

  public function build() {
    $build['lazy_builder'] = [
      '#lazy_builder' => [
        'ales_custom_entity.lazy_loaded:lazyCallback',
        []
      ],
      '#create_placeholder' => TRUE,
    ];

    return $build;
  }
}