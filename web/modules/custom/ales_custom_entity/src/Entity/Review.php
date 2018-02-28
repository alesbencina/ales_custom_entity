<?php

namespace Drupal\ales_custom_entity\Entity;


use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * @ContentEntityType(
 *   id = "review",
 *   label = @Translation("review"),
 *   label_singular = @Translation("review"),
 *   label_plural = @Translation("reviews"),
 *   label_count = @PluralTranslation(
 *     singular = "@count review",
 *     plural = "@count reviews"
 *   ),
 *   base_table = "review",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "bundle" = "type",
 *   },
 *   bundle_entity_type = "review_type",
 *   handlers = {
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\DefaultHtmlRouteProvider",
 *     },
 *     "form" = {
 *       "add" = "Drupal\ales_custom_entity\Form\ReviewForm",
 *       "edit" = "Drupal\ales_custom_entity\Form\ReviewForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *    "list_builder" = "Drupal\ales_custom_entity\Controller\ReviewListBuilder",
 *    "views_data" = "Drupal\views\EntityViewsData",
 *    "access" = "Drupal\ales_custom_entity\Access\ReviewAccessControlHandler"
 *   },
 *   links = {
 *     "canonical" = "/reviews/{review}",
 *     "add-page" = "/admin/content/reviews/add",
 *     "add-form" = "/admin/content/reviews/add/{review_type}",
 *     "edit-form" = "/admin/content/reviews/manage/{review}",
 *     "delete-form" = "/admin/content/reviews/manage/{review}/delete",
 *     "collection" = "/admin/content/reviews",
 *   },
 *   admin_permission = "administer reviews",
 *   field_ui_base_route = "entity.review_type.edit_form",
 * )
 */
class Review extends ContentEntityBase implements ReviewInterface {

  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setDisplayOptions('form', [
        'weight' => 0,
      ])
      ->setLabel(t('Title'))
      ->setRequired(TRUE);


    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'weight' => 0,
      ])
      ->setLabel(t('Description'));

    $fields['published'] = BaseFieldDefinition::create('boolean')
      ->setDisplayConfigurable('view', TRUE)
      ->setLabel(t('Published'))
      ->setDefaultValue(FALSE);

    $fields['owner'] = BaseFieldDefinition::create('entity_reference')
      ->setDisplayConfigurable('view', TRUE)
      ->setLabel(t('Owner'))
      ->setSetting('target_type', 'user')
      ->setDefaultValueCallback(static::class . '::getCurrentUser');

    $fields['nid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Node id'))
      ->setDisplayConfigurable('view', TRUE)
      ->setSetting('target_type', 'node');

    $fields['voteid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Vote ID'))
      ->setDisplayConfigurable('view', TRUE)
      ->setSetting('target_type', 'vote');

    return $fields;
  }

  public function getTitle() {
    return $this->get('title')->value;
  }

  public function setTitle($title) {
    return $this->set('title', $title);
  }

  public function setDescription($description) {
    return $this->set('description', $description);
  }

  public function isPublished() {
    return (bool) $this->get('published')->value;
  }

  public function publish() {
    return $this->set('published', TRUE);
  }

  public function unpublish() {
    return $this->set('published', FALSE);
  }

  public function getDescription() {
    return $this->get('description')->processed;
  }

  public function getNodeId() {
    return $this->get('nid')->value;
  }

  public function setNodeId($value) {
    return $this->set('nid', $value);
  }

  public static function getCurrentUser() {
    return \Drupal::currentUser()->id();
  }

  /**
   * Invalidates the block plugin cache after changes and deletions.
   */
  protected static function invalidateBlockPluginCache() {
    // Invalidate the block cache to update custom block-based derivatives.
    \Drupal::service('plugin.manager.block')->clearCachedDefinitions();
  }

}
