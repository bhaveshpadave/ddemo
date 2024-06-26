<?php

/**
 * @file
 * Creates block that displays the RSVPForm
 */

 namespace Drupal\rsvplist\Plugin\Block;

 use Drupal\Core\Block\BlockBase;
 use Drupal\Core\Session\AccountInterface;
 use Drupal\Core\Access\AccessResult;

 /**
  * Provides RSVP main block
  * 
  * @Block (
  *   id = "rsvp_block",
  *   admin_label = @Translation("The RSVP Block")
  * )
  */
 Class RSVPBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        return \Drupal::formBuilder()->getForm('\Drupal\rsvplist\Form\RSVPForm');
    }

    /**
     * {@inheritdoc}
     */
    public function blockAccess(AccountInterface $account) {
        $node = \Drupal::routeMatch()->getParameter('node');

        if(!(is_null($node))){
            return AccessResult::allowedIfHasPermission($account,'view rsvplist');
        }
        
        return AccessResult::forbidden();
    }
 }