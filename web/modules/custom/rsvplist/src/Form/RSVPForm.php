<?php

/**
 * @file
 * This file creates RSVP form frontend
 */

 namespace Drupal\rsvplist\Form;

 use Drupal\Core\Form\FormBase;

 class RSVPForm extends FormBase {
    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'rsvplist_email_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state){
        //Attempt to get fully loaded node object from the viewed page
        $node = \Drupal::routeMatch() -> getParameter('node');
        
        //If node is loaded, get node id
        if (!is_null($node)) {
            $nid = $node->id();

        //If node is not loaded, set nid to 0    
        } else {
            $nid = 0;
        }
        
        //Establish a form render array with 'Email ID' text field and 'Submit' button
        $form['email'] = [
            '#type' => 'textfield',
            '#title' => t('Email ID'),
            '#size' => 25,
            '#description' => t('We will send you an email'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('RSVP'),
        ];
        $form['nid'] = [
            '#type' => 'hidden',
            '#value' => $nid,
        ];

        return $form;
    }
    
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, \Drupal\Core\Form\FormStateInterface $form_state) {
        $submitted_email = $form_state->getValue('email');
        $this->messenger()->addMessage(t('This form is form is your email is @email',
        ['@email' => $submitted_email]));
    }
 }