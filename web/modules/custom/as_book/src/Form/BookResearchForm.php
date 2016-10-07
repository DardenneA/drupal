<?php

namespace Drupal\as_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;



/**
 * Class BookResearchForm.
 *
 * @package Drupal\as_book\Form
 */
class BookResearchForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'book_research_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['researchbook'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Vous recherchez un livre en particulier ? tapez-le :'),
      '#description' => $this->t('Research book or books list including the word written in the research form.'),
      '#maxlength' => 64,
      '#size' => 64,
      '#ajax' => array(
          'callback' => 'Drupal\as_book\Form\BookResearchForm::ajaxSearchCallback',
          'event' => 'keyup', //a chaque relachement du bouton, peut etre mouse, click, over,...
          'progress' => array(
            'type' => 'bar',//petite roue tournante
            'message' => 'Chargement....',
          ),
        ),

    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Search'),
    ];

    return $form;
  }

//ajout de cette methode vide, permet déjà de gérer l'ajax !
//on fait un copier-coller de buildForm.
public function ajaxSearchCallback(array &$form, FormStateInterface $form_state){

  //dsm($form_state->getValue('researchbook')); //debugage en ajax

  $keyword =$form_state->getValue('researchbook');

  //recuperation listing de livre
  $query = \Drupal::entityQuery('node');
  //kint($_GET); die();l
  $query->condition('type', 'as_book');
  $query->condition('status', 1);

  $query->condition('title', $keyword, 'CONTAINS');

  $query->sort('created', 'DESC');
  $query->range(0, 10);
  $result = $query->execute();

  $nodes = \Drupal\node\Entity\Node::loadMultiple($result);

  $books = [];
  foreach ($nodes as $node) {
    $books[] = node_view($node, 'teaser');
  }



  if(!empty($books)){
    $rendarable = [
      '#theme'=> 'book_listing',
      'books'=>$books,
  ];
    $output=render($rendarable); //execution du renderable array pour fournir code html
    $output=$output->__toString();
  }


  $response= new AjaxResponse();
  $htmlCommand = new htmlCommand('div.region.region-ontent',$output);
  $response->addCommand($htmlCommand);
  return $response;
  //
  // return [
  //   '#theme' => 'book_listing',
  //   'books' => $books,
  // ];

}


  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //kint($form);


  //  kint($form_state); //permet d'afficher les valeurs rentrées... et voir la
                        // méthode setRedirect avec ses arguments a renseigner
    $route_name = 'as_book.default_controller_bookListingResearchFound';
    $route_parameters = [
      'keyword' => $form_state->getValue('researchbook'), //recup le nom machine du form
    ];
    $form_state->setRedirect($route_name,$route_parameters);

    //kint($route_parameters);
    //die();

    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message($key . ': ' . $value);
    }

  }

}
