<?php
/**
 * Created by PhpStorm.
 * User: alesbencina
 * Date: 27/02/2018
 * Time: 15:02
 */

use Drupal\votingapi\Entity\Vote;
$vote = Vote::create(['type' => 'vote']);
//    $this->vote = Vote::create(['type' => 'fake_vote_type']);
$vote->setVotedEntityId(113);
$vote->setVotedEntityType('review');
$vote->setValue(5);
$vote->setValueType('points');
$vote->save();
