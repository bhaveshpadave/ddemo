<?php

/**
 * @file
 * This file contains the FirstController class
 */

 namespace Drupal\my_custom_module\Controller;

 use Drupal\Core\Controller\ControllerBase;

  class FirstController extends ControllerBase {

    public function simpleContent() {
      return [
        '#type' =>'markup',
        '#markup' => t('Time flies like arrows and fruit flies like banana'),
      ];
    }

    public function slugVariable($name1, $name2) {
        return [
          '#type' =>'markup',
          '#markup' => t('Hello @name1 and @name2', ['@name1' => $name1, '@name2' => $name2]),
        ];  
    }
  }