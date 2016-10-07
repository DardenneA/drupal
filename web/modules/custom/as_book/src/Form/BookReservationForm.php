<?php

namespace Drupal\as_book\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BookReservationForm.
 *
 * @package Drupal\as_book\Form
 */
class BookReservationForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'book_reservation_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

//get the user currentUser
$user = \Drupal::currentUser();

if($user->hasPermission('access book reservation form')){

    $form['book_id'] = [
      '#type' => 'textfield',
      //'#title' => $this->t('book_id'),
    ];
    $form['user_id'] = [
      '#type' => 'hidden',
      //'#title' => $this->t('user_id'),
    ];

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Book me !'),
    ];

    return $form;
  }
  return ['#markup' => 'Veuillez vous connecter pour réserver le livre.'];
}

  /**
    * {@inheritdoc}
    * $form_state : valeurs soumises via le formulaire
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    //partie vérification
    // exemple : vérifier qu'il ne s'agisse pas d'un robot,...

    //vérification si la valeur des champs de $form n'ont pas été changé par l'utilisateur ou un robot

    //recup le livre courant
    $current_uri=\Drupal::request()->getRequestUri();
    $original_book_id = str_replace('/node/','',$current_uri);

    //recup le user courant
    $current_user=\Drupal::currentUser();
    $original_user_id = $current_user->id();

    $submitted_book_id=$form_state->getValue('book_id');
    $submitted_user_id=$form_state->getValue('user_id');

    // comparaison entre la valeur réelle et la valeur retournée (vrai si different)
    $invalid_book_id = $original_book_id =! $submitted_book_id;
    $invalid_user_id = $original_user_id =! $submitted_user_id;

    if ($invalid_book_id || $invalid_user_id){
      //envoi message d'erreur$form_state->setError('book_id','');
      //kint($form_state);
      $form_state->setErrorByName('book_id','Mauvais format de donnée');
      //die();
    }

    if($current_user->isAnonymous()){
      $form_state->setErrorByName('user_id',$this->t('utilisateur non connecté'));

    }

    kint($form_state); die();

    // kint($book_id);
    // kint($user_id);
    //
    // kint($form_state->getValue('book_id')); die();
    //kint($form_state->getValues());die();
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

        $book_id=$form_state->getValue('book_id');
        $user_id=$form_state->getValue('user_id');

        /*Reservation*/
        //$node : notre noeud de type reservation
        $node = \Drupal\node\Entity\Node::create([
          'type'=>'reservation',
          'title'=> 'Réservation n°'. $book_id .  '-' . $user_id ,
          'status'=> 1,
          'field_book'=>$book_id,
          'field_subscriber'=>$user_id,
         ]);
        // kint($node->get('field_book')->getValue());
        // kint($node); die();
      //  $node->save();

      if($node->save()){
        drupal_set_message('la réservation a bien été prise en compte.','status');

      }
      else{
        drupal_set_message('problème de réservation..','error');
      }


kint($form_state); die();

    // Display all values insert
    // foreach ($form_state->getValues() as $key => $value) {
    //     drupal_set_message($key . ': ' . $value);
    // }

  }

}
