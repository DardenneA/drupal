<?php

namespace Drupal\as_book\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 *
 * @package Drupal\as_book\Controller
 */
class DefaultController extends ControllerBase {

  /**
   * Booklisting.
   *
   * @return string
   *   Return Hello string.
   */
  public function bookListing() {

    $query = \Drupal::entityQuery('node');
    $query->condition('type', 'as_book');
    $query->condition('status', 1);
    $query->sort('created', 'DESC');
    $query->range(0, 10);
    $result = $query->execute();

    $nodes = \Drupal\node\Entity\Node::loadMultiple($result);

    $books = [];
    foreach ($nodes as $node) {
      $books[] = node_view($node, 'teaser');
    }

    return [
      '#theme' => 'book_listing',
      'books' => $books,
    ];
  }


  /**
   * Book Listing Found.
   *
   * @return string
   *   Return Hello string.
   */
  public function bookListingResearchFound() {



    //recuperation listing de livre
    $query = \Drupal::entityQuery('node');
    //kint($_GET); die();
    $query->condition('type', 'as_book');
    $query->condition('status', 1);
    //$query->condition('title', $_GET['keyword'],'CONTAINS');
        //bonne façon de faire, mais un hacker peut insérer des caractères
        // spécaux pour flinguer notre requete

        //On préfèrera passer par Drupal directement :
    $keyword = \Drupal::request()->get('keyword');
    $query->condition('title', $keyword, 'CONTAINS');

    $query->sort('created', 'DESC');
    $query->range(0, 10);
    $result = $query->execute();

    $nodes = \Drupal\node\Entity\Node::loadMultiple($result);

    $books = [];
    foreach ($nodes as $node) {
      $books[] = node_view($node, 'teaser');
    }

    return [
      '#theme' => 'book_listing',
      'books' => $books,
    ];





    // return [
    //   '#markup' => 'Notre page de recherche de livre',
    // ];
}













}
