<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 19/02/2018
 * Time: 13:12
 */

namespace Drupal\ales_custom_entity\Entity;


use Drupal\Core\Entity\ContentEntityInterface;

interface ReviewInterface extends ContentEntityInterface {

  /**
   * @return string
   */
  public function getTitle();

  /**
   * @param string $title
   *
   * @return $this
   */
  public function setTitle($title);


  /**
   * @return string
   */
  public function getDescription();

  /**
   * @param string $description
   * @param string $format
   *
   * @return $this
   */
  public function setDescription($description);

  /**
   * @return bool
   */
  public function isPublished();

  /**
   * @return $this
   */
  public function publish();

  /**
   * @return $this
   */
  public function unpublish();
}