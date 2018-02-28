<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 19/02/2018
 * Time: 14:01
 */

namespace Drupal\ales_custom_entity\Access;


use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

class ReviewAccessControlHandler extends EntityAccessControlHandler {

  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    $access_result = AccessResult::allowedIfHasPermission($account, 'create reviews');
    return $access_result->orIf(parent::checkCreateAccess($account, $context, $entity_bundle));
  }

  protected function checkAccess(EntityInterface $review, $operation, AccountInterface $account) {
    /** @var \Drupal\event\Entity\EventInterface $event */
    // The parent class grants access based on the administrative permission.
    $access_result = parent::checkAccess($review, $operation, $account);
    switch ($operation) {
      case "view":
        // Only allow administrators to view unpublished events.
        if ($review->isPublished()) {
          $permission = 'view reviews';
        }
        else {
          $permission = 'administer reviews';
        }
        $access_result->addCacheableDependency($review);
        break;

      case "update":
        $permission = 'edit reviews';
        break;

      case "delete":
        $permission = 'delete reviews';
        break;

    }
    return $access_result->orIf(AccessResult::allowedIfHasPermission($account, $permission));
  }

}