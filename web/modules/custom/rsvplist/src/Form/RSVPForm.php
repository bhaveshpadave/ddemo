<?php

/**
 * @file
 * This file creates RSVP form frontend
 */

 namespace Drupal\rsvplist\Form;

 use Drupal\Core\Form\FormBase;
 use Drupal\Core\Form\FormStateInterface;

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
    public function buildForm(array $form, FormStateInterface $form_state){
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

     public function validateForm(array &$form, FormStateInterface $form_state) {
        $submitted_email = $form_state->getValue('email');
        if (!(\Drupal::service('email.validator')->isValid($submitted_email))) {
            $form_state->setErrorByName('email',
            $this->t('%value is not valid email, please enter a valid email address.',
            ['%value' => $submitted_email]));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        // $submitted_email = $form_state->getValue('email');
        // $this->messenger()->addMessage(t('This is RSVP form and your email is @email',
        // ['@email' => $submitted_email]));
        
        try {
            
            //Get current user's id
            $uid = \Drupal::currentUser()->id();

            //Obtain values from form
            $nid = $form_state->getValue('nid');  
            $mail = $form_state->getValue('email');

            //Cuurent timestamp
            $created = \Drupal::time()->getRequestTime();

            //Build query builder with object $query
            $query = \Drupal::database()->insert('rsvplist');
            $query->fields([
                'uid',
                'nid',
                'mail',
                'created',
            ]);

            $query->values([
                $uid,
                $nid,
                $mail,
                $created,
            ]);

            $query->execute();

            \Drupal::messenger()->addMessage(t('Thank you for RSVP, you are on the list of event'));
            
        } catch (\Exception $e) {

            \Drupal::messenger()->addError(t('Unable to save RSVP due to database error'));
        }
    }
 }