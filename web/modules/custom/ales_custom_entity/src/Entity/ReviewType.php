<?php

namespace Drupal\ales_custom_entity\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the review type entity.
 *
 * @ConfigEntityType(
 *   id = "review_type",
 *   label = @Translation("review type"),
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *   },
 *   bundle_of = "review",
 *   config_prefix = "type",
 *   config_export = {
 *     "id",
 *     "label",
 *   },
 *   handlers = {
 *     "list_builder" = "Drupal\ales_custom_entity\Controller\ReviewTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *    "form" = {
 *       "add" = "Drupal\ales_custom_entity\Form\ReviewTypeForm",
 *       "edit" = "Drupal\ales_custom_entity\Form\ReviewTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/review-types/add",
 *     "edit-form" = "/admin/structure/review-types/manage/{review_type}",
 *     "delete-form" = "/admin/structure/review-types/manage/{review_type}/delete",
 *     "collection" = "/admin/structure/review-types"
 *   },
 *   admin_permission = "administer review types",
 * )
 */
class ReviewType extends ConfigEntityBase {

  protected $id;

  protected $label;

}
