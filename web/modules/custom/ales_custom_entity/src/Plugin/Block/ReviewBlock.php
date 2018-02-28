<?php

namespace Drupal\ad_general\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a block which describe how many stars have event.
 *
 * @Block(
 *   id = "review_block",
 *   admin_label = @Translation("Send to friend form"),
 *   category = @Translation("Send to friend")
 * )
 */
class ReviewBlock extends BlockBase {

  public function build() {
    $form = \Drupal::formBuilder()
      ->getForm('\Drupal\ad_general\Plugin\Form\SendToFriend');
    return $form;
  }
}