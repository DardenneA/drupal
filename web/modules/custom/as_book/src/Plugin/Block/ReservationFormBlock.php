<?php

namespace Drupal\as_book\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'ReservationFormBlock' block.
 *
 * @Block(
 *  id = "reservation_form_block",
 *  admin_label = @Translation("Reservation form block"),
 * )
 */
class ReservationFormBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {


    //recup le livre courant
    $current_uri=\Drupal::request()->getRequestUri();
    //kint($current_uri);
    $book_id = str_replace('/node/','',$current_uri);

    //recup le user courant
    $current_user=\Drupal::currentUser();
    $user_id = $current_user->id();


    $form = \Drupal::formBuilder()->getForm('\Drupal\as_book\Form\BookReservationForm');
    $form['book_id']['#value']=$book_id;
    $form['user_id']['#value']=$user_id;


    $build = [];
    $build['reservation_form_block'] = $form;

    return $build;
  }

}
